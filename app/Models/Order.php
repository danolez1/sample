<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\DB\Column;
use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Res\Email;
use danolez\lib\Res\Payment\StripeApi;
use danolez\lib\Res\PrintNodeApi;
use danolez\lib\Res\Server;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Administrator;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Cart\CartItem;
use Demae\Auth\Models\Shop\Delivery;
use Demae\Auth\Models\Shop\CreditCard;
use Demae\Auth\Models\Shop\Product;
use Demae\Auth\Models\Shop\Setting;
use Demae\Controller\HomeController;
use Dompdf\Dompdf;
use OrderColumn;
use PaymentDetailsColumn;
use ReflectionClass;
use ReflectionProperty;
use Sabberworm\CSS\Settings;
use Tracking;

class Order extends Model
{
    private $id;
    private $displayId;
    private $cart; //array of cartItem
    private $amount;
    private $userDetails;
    private $visibility;
    private $status;
    private $deliveryOption;
    private $deliveryFee;
    private $scheduled; //time,date
    private $address;
    private $paymentDetails; //card(creditCard) or cash
    private $timeCreated;
    private $paymentMethod;
    private $log;
    private $branch;
    public $deliveryTime;


    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::ORDERS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function get($id = null, $userId = null, $branchId = null)
    {
        if ($id != null) {
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    OrderColumn::ID => $id,
                )
            );
            if (count($query) > 0)
                return $this->setData($query[0]);
            else return [];
        } else if ($userId != null) {
            $orders = [];
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    OrderColumn::USERDETAILS => $userId,
                )
            );
            foreach ($query as $order) {
                $orders[] = $this->setData($order);
            }
            return $orders;
        } else if ($branchId != null) {
            $orders = [];
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    OrderColumn::BRANCH => $branchId,
                )
            );
            foreach ($query as $order) {
                $orders[] = $this->setData($order);
            }
            return $orders;
        } else {
            $orders = [];
            $query = (array) $this->table->get();
            foreach ($query as $order) {
                $orders[] = $this->setData($order);
            }
            return $orders;
        }
    }

    public function updateStatus($id, $status, Administrator $admin, $location = null)
    {
        $return = array();
        $error = null;
        $return[parent::RESULT] = false;
        $delivery = new Delivery();
        $delivery->setOrderId($id);
        $delivery->setCourierId($admin->getId());
        $del = $delivery->get(null, $id);
        $stats = [];
        $stat = 0;
        if (!isEmpty($del)) {
            $stats = (array) fromDbJson($del->getStatus());
            $stat = (int) json_decode($stats[count($stats) - 1])->status;
        }
        if ($stat < intval($status)) {
            array_push($stats, json_encode(array('status' => $status, 'time' => time())));
            $delivery->setStatus(json_encode($stats));
            if (json_decode($delivery->update())->{Model::RESULT}) {
                $stmt = $this->table->update(array(OrderColumn::STATUS), array($status), array(OrderColumn::ID => $id));
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
            } else {
                $error = Error::ErrorOccured;
            }
        }
        $return[Model::ERROR] = $error;
        return json_encode($return);
    }

    public function hide($id = null)
    {
        $return = array();
        $stmt = $this->table->update(array(OrderColumn::VISIBILITY), array(1), array(OrderColumn::ID => $id ?? $this->id));
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        return json_encode($return);
    }


    public function request()
    {
        $return = array();
        $error = null;
        $id = $this->table->getLastSN() + 1;
        $this->setId(Encoding::encode(($id), self::VALUE_ENCODE_ITERTATION));
        $this->setDisplayId($id);
        if ($this->getPaymentMethod() == PaymentDetailsColumn::CARD) {
            $payment = json_decode($this->payWithStripe());
            if ($payment->{Model::RESULT} != true) {
                $return[parent::ERROR] = Error::PaymentUnsuccessful;
                return $return;
            } else {
                $this->setPaymentDetails(json_encode($payment->{Model::DATA}));
            }
        }
        $obj = $this->object();
        $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        if ($return[parent::RESULT]) {
            setcookie(base64_encode('recent-order'), base64_encode($this->object(false)[OrderColumn::ID]), time() + time(), "/");
            $cart = new CartItem();
            foreach (json_decode($this->getCart()) as $item) {
                $cart->setId($item->id);
                $cart->setUserId($item->userId);
                $cart->delete();
            }
            $this->printWithPrintNode();
        }
        $return[Model::ERROR] = $error;
        return ($return);
    }


    private function payWithStripe()
    {
        $payment = new StripeApi();
        $payment->setPrice(intval($this->amount) + intval($this->deliveryFee));
        $payment->setCurrency(Setting::getInstance()->getCurrencyLocale());
        $creditCard = $this->paymentDetails['creditCard'];
        $payment->setCreditCard($creditCard);
        //cookie based(lang), store name, payment
        $payment->setDescription("Payment");
        return $payment->charge();
    }


    public function generateEmailTemplate($EN = false)
    {
        $body = file_get_contents('app/Views/email/order.php');
        $settings = HomeController::getSettings();
        $address = json_decode($this->address);
        $logo = '<img align="center" border="0" class="center autowidth" src="cid:logo-img" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 140px; display: block;"  width="140" />';
        $body = str_replace("{{logo}}", $settings->getUseTitleAsLogo() ? $settings->getLogo() : $logo, $body);
        $body = str_replace("{{UserName}}", $EN ? "Dear " . $address->firstName . " " . $address->lastName . "," : $address->firstName . " " . $address->lastName . " 様,", $body);
        $time = '';
        $deliveryTime = explode('-', $this->deliveryTime);
        $range = intval($deliveryTime[1]);
        $deliveryTime = intval($deliveryTime[0]);
        $scheduled = json_decode($this->scheduled);
        $scheduledDate = $scheduled->date;
        $scheduledTime = $scheduled->time;
        if (isEmpty($scheduledTime) || isEmpty($scheduledDate)) {
            $time = date('d/m/y H:i', time() + ($deliveryTime * 60))
                . ' - ' . date('H:i', time() + ($deliveryTime * 60) + ($range * 60));
        } else {
            $time = $scheduledDate . " " . $scheduledTime;
        }

        $delTime = $EN ? "The delivery time  for your order is  $time" : "ご注文の配達時間は  $time";
        $takTime = $EN ? "The takeout time for your order is  $time" : "ご注文のテイクアウト時間は  $time";
        $timeInfo = (intval($this->deliveryOption) == OrderColumn::HOME_DELIVERY) ? $delTime : $takTime;

        $body = str_replace("{{Message}}", $EN ? "Thank you for your purchase from " . $settings->getStoreName() . ".$timeInfo. Here is an overview of your recent purchase:"
            : $settings->getStoreName() . "からお買い上げいただきありがとうございます。$timeInfo 。最近の購入の概要は次のとおりです。", $body);
        $body = str_replace("{{YOUR-PURCHASES}}", $EN ? "Your Purchases" : "注文内容", $body);

        $body = str_replace("{{ZIP}}", $address->address, $body);
        $body = str_replace("{{CITY}}", $address->city, $body);
        $body = str_replace("{{STREET}}", $address->zip, $body);
        $body = str_replace("{{BUILDING}}", $address->street . " " . $address->building, $body);
        $body = str_replace("{{INVOICE-ID-TXT}}", $EN ? "Order no" : "注文番号", $body);
        $body = str_replace("{{INVOICE-ID}}", $this->displayId, $body);
        $body = str_replace("{{INVOICE-DATE-TXT}}", $EN ? "Order date" : "注文日", $body);
        $body = str_replace("{{INVOICE-DATE}}", date("M d,Y h:i A"), $body);
        $body = str_replace("{{ORDER_BY}}", $EN ? "Ordered by" : "注文者", $body);
        $body = str_replace("{{ORDER_DETAILS}}", $EN ? "Order details" : "注文詳細", $body);
        $products = "";
        $cart = json_decode($this->cart);
        $attachments = [];
        foreach ($cart as $item) {
            $product = file_get_contents('app/Views/email/product-item.php');
            $cid = str_replace(" ", "_", $item->productImage);
            $attachments[$cid] = $item->productImage;
            $product = str_replace("{{PRODUCT_IMAGE}}", "cid:$cid", $product);
            $product = str_replace("{{PRODUCT_NAME}}", $item->productDetails . ' <b>(X' . $item->quantity . ")</b>", $product);
            $options = "";
            $item->productOptions = fromDbJson($item->productOptions);
            foreach ($item->productOptions as $option) {
                $options .= $option->category->name . " (" . unicode2html($option->name) . " <strong>x</strong>" . $option->amount . ")  = " . $settings->getCurrency() .  number_format(isEmpty($option->price) ? 0 : $option->price) . "<br>";
            }
            $product = str_replace("{{PRODUCT_DESCRIPTION}}", $options, $product);
            $product = str_replace("{{PRODUCT_PRICE}}", $settings->getCurrency() . number_format(intval($item->amount) * intval($item->quantity)), $product);
            $products .= $product;
        }
        $body = str_replace("{{PRODUCTS}}", $products, $body);
        $body = str_replace("{{PROMOTION}}", "", $body);
        $body = str_replace("{{DELIVERY_TYPE_TXT}}", $EN ? "Delivery Method" : "配送方法", $body);
        $body = str_replace("{{DELIVERY_TYPE}}", $this->getDeliveryMethodText()[$EN ? 'en' : 'jp'], $body);
        $body = str_replace("{{TOTAL-TXT}}", $EN ? "Total" : "合計", $body);
        $body = str_replace("{{TOTAL}}", $settings->getCurrency() . number_format($this->amount), $body);
        $body = str_replace("{{TAX-TXT}}", $EN ? "Tax" : "税金", $body); // 
        $body = str_replace("{{TAX}}", $settings->getCurrency() . number_format(intval($this->amount) * Product::TAX), $body);
        $body = str_replace("{{SHIPPING-TXT}}", $EN ? "Shipping Fee" : "送料", $body);
        $body = str_replace("{{SHIPPING}}", $settings->getCurrency() . number_format(intval($this->deliveryFee)), $body);
        $body = str_replace("{{SUBTOTAL-TXT}}", $EN ? "Subtotal" : "小計", $body);
        $body = str_replace("{{SUBTOTAL}}", $settings->getCurrency() . number_format(intval($this->amount) - intval($this->amount) * Product::TAX), $body);
        $body = str_replace("{{PAYMENT_METHOD}}", $EN ? "Payment method" : "支払方法", $body);
        $body = str_replace("{{PAYMENT_METHOD-TXT}}", $this->getPaymentMethodText()[$EN ? 'en' : 'jp'], $body);
        $body = str_replace("TEXT_COLOR", "", $body);
        $body = str_replace("{{SOCIALS}}", "", $body);
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.facebook.com/" target="_blank"><img alt="Facebook" height="32" src="images/facebook2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Facebook" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://twitter.com/" target="_blank"><img alt="Twitter" height="32" src="images/twitter2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Twitter" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="images/instagram2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Instagram" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.linkedin.com/" target="_blank"><img alt="LinkedIn" height="32" src="images/linkedin2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="LinkedIn" width="32" /></a></td>
        $body = str_replace("{{ALL_RIGHTS_RESERVED}}", $EN ? "<a href='https://demae-system.com'>CLB Solutions.</a> . All Rights Reserved" : "<a href='https://demae-system.com'>©株式会社ＣＬＢ(SystemSolution)。</a>全著作権所有", $body);
        $body = str_replace("{{TERMS_CONDITION}}", "", $body); // <a href="#" rel="noopener" style="text-decoration: none; color: #848484;" target="_blank">Terms &amp; Conditions</a> 

        return (object)array('body' => $body, 'attachments' => $attachments);
    }

    public function generateTemplate($EN = false)
    {
        $body = file_get_contents('app/Views/email/order-print.php');
        $settings = HomeController::getSettings();
        $address = json_decode($this->address);
        $logo = '<img align="center" border="0" class="center autowidth" src="cid:logo-img" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 140px; display: block;"  width="140" />';
        $body = str_replace("{{logo}}", $settings->getUseTitleAsLogo() ? $settings->getLogo() : $logo, $body);
        $body = str_replace("{{UserName}}",  $address->firstName . " " . $address->lastName . " 様", $body);
        $time = '';
        $deliveryTime = explode('-', $this->deliveryTime);
        $range = intval($deliveryTime[1]);
        $deliveryTime = intval($deliveryTime[0]);
        $scheduled = json_decode($this->scheduled);
        $scheduledDate = $scheduled->date;
        $scheduledTime = $scheduled->time;
        $reservation = "";
        if (isEmpty($scheduledTime) || isEmpty($scheduledDate)) {
            $time = date('Y/m/d H:i', time() + ($deliveryTime * 60))
                . ' ~ ' . date('H:i', time() + ($deliveryTime * 60) + ($range * 60));
        } else {
            $time = $scheduledDate . " " . $scheduledTime;
            $reservation = $EN ? "***RESERVATION***" : "***予約***";
        }
        $delTime = $EN ? "Delivery Time $time" : "配達時間 $time ";
        $takTime = $EN ? "Takeout Time $time" : "テイクアウト時間 $time";
        $timeInfo = (intval($this->deliveryOption) == OrderColumn::HOME_DELIVERY) ? $delTime : $takTime;
        $body = str_replace("{{TITLE}}",  $reservation . "<br>" . $timeInfo, $body);
        $body = str_replace("{{Message}}", $EN ? "You have a new order on your website"
            : "ウェブサイトから新しい注文があります", $body);
        $body = str_replace("{{YOUR-PURCHASES}}", $EN ? "Purchases" : "注文内容", $body);
        $body = str_replace("{{ZIP}}", $address->address . ' ' . $address->street . " " . $address->building, $body);
        $body = str_replace("{{CITY}}", "", $body);
        $body = str_replace("{{STREET}}", $address->city, $body);
        $body = str_replace("{{BUILDING}}", "", $body);
        $body = str_replace("{{INVOICE-ID-TXT}}", $EN ? "Order no" : "注文番号", $body);
        $body = str_replace("{{INVOICE-ID}}", $this->displayId, $body);
        $body = str_replace("{{INVOICE-DATE-TXT}}", $EN ? "Order date" : "注文日", $body);
        $body = str_replace("{{INVOICE-DATE}}", date("M d,Y H:i"), $body);
        $body = str_replace("{{ORDER_BY}}", $EN ? "Ordered by" : "注文者", $body);
        $body = str_replace("{{ORDER_DETAILS}}", $EN ? "Order details" : "注文詳細", $body);
        $products = "";
        $cart = json_decode($this->cart);
        foreach ($cart as $item) {
            $product = file_get_contents('app/Views/email/product-item-print.php');
            $product = str_replace("{{PRODUCT_IMAGE}}", ""/*encodeImage($item->productImage)*/, $product);
            $product = str_replace("{{PRODUCT_NAME}}", $item->productDetails . ' <b>(X' . $item->quantity . ")</b>", $product);
            $options = "";
            $item->productOptions = fromDbJson($item->productOptions);
            foreach ($item->productOptions as $option) {
                $options .= $option->category->name . " (" . unicode2html($option->name) . " <strong>x</strong>" . $option->amount . ")  = " . $settings->getCurrency() .  number_format(isEmpty($option->price) ? 0 : $option->price) . "<br>";
            }
            $product = str_replace("{{PRODUCT_DESCRIPTION}}", $options, $product);
            $product = str_replace("{{PRODUCT_PRICE}}", $settings->getCurrency() . number_format(intval($item->amount) * intval($item->quantity)), $product);
            $products .= $product;
        }
        $body = str_replace("{{PRODUCTS}}", $products, $body);
        $body = str_replace("{{PROMOTION}}", "", $body);
        $body = str_replace("{{DELIVERY_TYPE_TXT}}", $EN ? "Delivery Method" : "配送方法", $body);
        $body = str_replace("{{DELIVERY_TYPE}}", $this->getDeliveryMethodText()[$EN ? 'en' : 'jp'], $body);
        $body = str_replace("{{TOTAL-TXT}}", $EN ? "Total" : "合計", $body);
        $body = str_replace("{{TOTAL}}", $settings->getCurrency() . number_format(intval($this->amount) + intval($this->deliveryFee)), $body);
        $body = str_replace("{{TAX-TXT}}", $EN ? "Tax" : "税金", $body); // 
        $body = str_replace("{{TAX}}", $settings->getCurrency() . number_format(intval($this->amount) * Product::TAX), $body);
        $body = str_replace("{{SHIPPING-TXT}}", $EN ? "Shipping Fee" : "送料", $body);
        $body = str_replace("{{SHIPPING}}", $settings->getCurrency() . number_format(intval($this->deliveryFee)), $body);
        $body = str_replace("{{SUBTOTAL-TXT}}", $EN ? "Subtotal" : "小計", $body);
        $body = str_replace("{{SUBTOTAL}}", $settings->getCurrency() . number_format(intval($this->amount) - intval($this->amount) * Product::TAX), $body);
        $body = str_replace("{{PAYMENT_METHOD}}", $EN ? "Payment method" : "支払方法", $body);
        $body = str_replace("{{PAYMENT_METHOD-TXT}}", $this->getPaymentMethodText()[$EN ? 'en' : 'jp'], $body);
        $body = str_replace("{{SOCIALS}}", "", $body);
        $body = str_replace("TEXT_COLOR", "color:#000000 !important;", $body);
        $body = str_replace("{{ALL_RIGHTS_RESERVED}}", $EN ? "©CLB Co. Ltd. (System Solution) . All Rights Reserved" : "©株式会社ＣＬＢ(SystemSolution)。全著作権所有", $body);
        $body = str_replace("{{TERMS_CONDITION}}", "", $body); // <a href="#" rel="noopener" style="text-decoration: none; color: #848484;" target="_blank">Terms &amp; Conditions</a> 

        return ($body);
    }

    public function printWithPrintNode()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->generateTemplate(Setting::getInstance()->getPrintLanguage() == 'en'));
        $customPaper =  'A4'; //array(0, 0, 950, 950);
        $dompdf->setPaper($customPaper, 'portrait');
        $dompdf->render();
        $pdf = $dompdf->output();

        $branch = new Branch();
        $branch = $branch->get('', $this->branch) ?? new Branch();
        $printNode = new PrintNodeApi();
        $printNode->setDefaultPrinter($branch[0]->getDefaultPrinter() ?? Setting::getInstance()->getDefaultPrinter());
        $printNode->setApi($branch[0]->getPrintNodeApi() ?? Setting::getInstance()->getPrintNodeApi());
        $printNode->setContent($pdf);
        $printNode->setSrc('Demae System');
        $printNode->setTitle('New Order');
        $print = $printNode->print();
        // var_dump($print);
        if (!$print) {
            // $statusCode = json_decode($print)->statusCode;
            // var_dump($print);
            // if ($statusCode != 201) {
            //     // $this->printWithPrintNode();
            //     //Add to mail message
            // }
        }
        $this->sendNotificationMail();
    }


    public function sendNotificationMail()
    {
        $mail = new Email();
        $settings = HomeController::getSettings();
        $address = fromDbJson($this->address);
        if (!$settings->getUseTitleAsLogo()) {
            $mail->setAttachment($settings->getMetaContent());
            $mail->setAttachmentName("logo-img");
        }
        $mail->setTo(Email::DEFAULT_FROM_EMAIL, Email::DEFAULT_FROM);
        $EN = Setting::getInstance()->getPrintLanguage() == 'en';
        $mail->setSubject($EN ? $settings->getStoreName() . ': New Order. Order No:[' . $this->getDisplayId() . ']' : $settings->getStoreName() . ": 新しい注文 番号[" . $this->getDisplayId() . ']');
        $mail->setHtml($this->generateTemplate($EN));
        $mail->sendWithHostSTMP();


        $mail->setTo($address->email,  $address->firstName . " " . $address->lastName);
        $EN = $_COOKIE['lingo'] == 'en';
        $mail->setSubject($EN ? "【" . $settings->getStoreName() . "】Thank you for your order." : "【" . $settings->getStoreName() . "】　ご注文ありがとうございました。");
        $template = $this->generateEmailTemplate($EN);
        $mail->setHtml($template->body);
        $mail->setAttachments($template->attachments);
        // $mail->sendWithHostSTMP();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($template->body);
        $customPaper =  'A4'; //array(0, 0, 950, 950);
        $dompdf->setPaper($customPaper, 'portrait');
        $dompdf->render();
        if ($this->deliveryOption == OrderColumn::TAKE_OUT) {
            var_dump("DANIEL");
            $name = $_COOKIE['lingo'] == 'en' ? "Order " . $this->getDisplayId() : '注文' . $this->getDisplayId();
            $dompdf->stream("$name.pdf", array("Attachment" => 1));
        }
        return;
    }

    public function getDeliveryMethodText()
    {
        switch ($this->deliveryOption) {
            case OrderColumn::TAKE_OUT:
                return array('en' => "Take Out", 'jp' => 'テークアウト');
            case OrderColumn::HOME_DELIVERY:
                return array('en' => "Home Delivery", 'jp' => '宅配');
        }
    }


    public function getPaymentMethodText()
    {
        switch ($this->paymentMethod) {
            case PaymentDetailsColumn::CARD:
                return array('en' => "Card", 'jp' => 'クレジットカード');
            case PaymentDetailsColumn::CASH:
                return array('en' => "Cash", 'jp' => '現金');
        }
    }

    public function getStatusInfo()
    {
        $received = array('Order Received', 'color' => '#8816FA', 'data' => OrderColumn::ORDER_RECEIVED, 'trn' => 'order-received');
        $ready = array('Order Ready', 'color' => '#288DFA', 'data' => OrderColumn::ORDER_READY, 'trn' => 'order-ready');
        $shipped = array('Order Shipped', 'color' => '#28A745', 'data' => OrderColumn::ORDER_SHIPPED, 'trn' => 'order-shipped');
        $onway = array('On the way', 'color' => '#FA8816', 'data' => OrderColumn::ORDER_ONWAY, 'trn' => 'order-on-way');
        $delivered = array('Delivered', 'color' => '#EFF3F3', 'data' => OrderColumn::ORDER_DELIVERED, 'trn' => 'order-delivered');

        switch ($this->status) {
            case OrderColumn::ORDER_RECEIVED:
                return array($received, $ready, $shipped, $onway, $delivered);
            case OrderColumn::ORDER_READY:
                return array($ready, $shipped, $onway, $delivered, $received);
            case OrderColumn::ORDER_SHIPPED:
                return array($shipped, $onway, $delivered, $received, $ready);
            case OrderColumn::ORDER_ONWAY:
                return array($onway, $delivered, $received, $ready, $shipped);
            case OrderColumn::ORDER_DELIVERED:
                return array($delivered, $received, $ready, $shipped, $onway);
        }
    }

    public static function getChildren($options, $categoryId)
    {
        $children = [];
        foreach ($options as $option) {
            if ($categoryId == $option->category->id) {
                $child = [];
                $child['name'] = $option->name;
                $child['quantity'] = $option->amount;
                $child['price'] = $option->price;
                $children[] = $child;
            }
        }
        return $children;
    }


    public function properties($display = false): array
    {
        $return = array();
        $object = get_object_vars($this);
        $return[parent::KEYS] = array_keys($object);
        $return[parent::VALUES] = array_values($object);
        if (!$display)
            return $return;
        else return $object;
    }

    protected function setData($data)
    {
        if ($data == null) return new Order();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Order();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            //$encKey = Encoding::encode($key, self::KEY_ENCODE_ITERTATION);
            //  $obj->{$key} = $data->{$encKey};
            $obj->{$encKey} =  ($data->{$encKey}); //,$key
        }
        return $obj;
    }

    protected function object($upload = true) //: array
    {
        $return  = array();
        $reflect = new ReflectionClass($this);
        $object = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $return[parent::PROPERTIES] = $this->encode(array_values($object)); //assoc
        $object = array();
        foreach ($return[parent::PROPERTIES] as $ppt => $enc) {
            $object[$enc] = $this->properties(true)[$ppt];
        }
        $return[parent::VALUES] = $this->encrypt($object);  //non assoc
        if ($upload) {
            $return[parent::PROPERTIES] = array_values($return[parent::PROPERTIES]);
            return $return;
        } else {
            return $this->encrypt($object, true);
        }
    }
    protected function encode($data)
    {
        if (is_array($data)) {
            $temp  = array();
            foreach ($data as $key) {

                $temp[$key->name] = $key->name;
                //$temp[$key->name] = Encoding::encode($key->name, self::KEY_ENCODE_ITERTATION);
            }
            return $temp;
        } else {
            return Encoding::encode($data, self::KEY_ENCODE_ITERTATION);
        }
    }
    protected function encrypt($data, $assoc = false)
    {

        if (is_array($data)) {
            $temp  = array();
            foreach ($data as $key => $value) {
                if ($key == OrderColumn::PAYMENTDETAILS && $this->paymentMethod == PaymentDetailsColumn::CARD) {
                    $assoc ? $temp[$key] = Credential::encrypt($value) : $temp[] = Credential::encrypt($value);
                } else {
                    $assoc ? $temp[$key] = ($value) : $temp[] = ($value);
                }
            }
            return $temp;
        } else {
            return Credential::encrypt($data); //,$key 
        }
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of displayId
     */
    public function getDisplayId()
    {
        return $this->displayId;
    }

    /**
     * Set the value of displayId
     *
     * @return  self
     */
    public function setDisplayId($displayId)
    {
        $this->displayId = $displayId;

        return $this;
    }

    /**
     * Get the value of scheduled
     */
    public function getScheduled()
    {
        return $this->scheduled;
    }

    /**
     * Set the value of scheduled
     *
     * @return  self
     */
    public function setScheduled($scheduled)
    {
        $this->scheduled = $scheduled;

        return $this;
    }

    /**
     * Get the value of cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set the value of cart
     *
     * @return  self
     */
    public function setCart($cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of userDetails
     */
    public function getUserDetails()
    {
        return $this->userDetails;
    }

    /**
     * Set the value of userDetails
     *
     * @return  self
     */
    public function setUserDetails($userDetails)
    {
        $this->userDetails = $userDetails;

        return $this;
    }

    /**
     * Get the value of paymentDetails
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * Set the value of paymentDetails
     *
     * @return  self
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;

        return $this;
    }

    /**
     * Get the value of visibility
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the value of visibility
     *
     * @return  self
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of timeCreated
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * Set the value of timeCreated
     *
     * @return  self
     */
    public function setTimeCreated($timeCreated)
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    /**
     * Get the value of log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set the value of log
     *
     * @return  self
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of deliveryFee
     */
    public function getDeliveryFee()
    {
        return $this->deliveryFee;
    }

    /**
     * Set the value of deliveryFee
     *
     * @return  self
     */
    public function setDeliveryFee($deliveryFee)
    {
        $this->deliveryFee = $deliveryFee;

        return $this;
    }

    /**
     * Get the value of deliveryOption
     */
    public function getDeliveryOption()
    {
        return $this->deliveryOption;
    }

    /**
     * Set the value of deliveryOption
     *
     * @return  self
     */
    public function setDeliveryOption($deliveryOption)
    {
        $this->deliveryOption = $deliveryOption;

        return $this;
    }

    /**
     * Get the value of paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set the value of paymentMethod
     *
     * @return  self
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get the value of branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set the value of branch
     *
     * @return  self
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get the value of deliveryTime
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * Set the value of deliveryTime
     *
     * @return  self
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }
}
