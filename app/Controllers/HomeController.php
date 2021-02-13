<?php

namespace Demae\Controller;

use Colors;
use CommerceController;
use danolez\lib\DB\Controller;
use danolez\lib\DB\Model;
use danolez\lib\Res\Orientation;
use danolez\lib\Res\Server;
use danolez\lib\Res\Session;
use danolez\lib\Security\Encoding;
use danolez\lib\Security\KeyFactory;
use Demae\Auth\Models\Contact\Contact;
use Demae\Auth\Models\Shop\Address;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Cart\CartItem;
use Demae\Auth\Models\Shop\Delivery;
use Demae\Auth\Models\Shop\Favourite;
use Demae\Auth\Models\Shop\Log;
use Demae\Auth\Models\Shop\Order;
use Demae\Auth\Models\Shop\CreditCard;
use Demae\Auth\Models\Shop\PaymentDetails;
use Demae\Auth\Models\Shop\Product\Category;
use Demae\Auth\Models\Shop\Product;
use Demae\Auth\Models\Shop\Setting;
use Demae\Auth\Models\Shop\User\Administrator;
use Demae\Auth\Models\Shop\User;
use OperationalTime;
use Ratings;
use TrafficLogger;
use UserController;

class HomeController extends Controller
{
    private $page;
    private $session;
    private $user;
    private $addresses = array();
    private $payments = array();
    private $products;
    private $branches;
    private $cart;
    private $orderData;
    private $favorites;
    private $history;
    private $favProducts = [];
    private $branch;
    private $operationalTime;
    private $available;
    private $traffic;
    private $track;
    private static $q;

    const GUEST = "a0283fef1780f643a0639b0621eeeeeeee40ee40";
    const TODAY = "a0283fef1780f643a0";
    const GUEST_ID = "9c283fef1780f643a0631e0117934b28f17d1eeeee40ee40";
    const USER_ID = '942826bb3efa2237a02ad2e56b29f64c80b3ee8043d902d69cf96bf221eeeeeeee40ee40';
    const USER_EMAIL = '502826bb3efa2237a02ad2e56b29f64c80b3ee80434b0243d9d963d1a0939b28f17d1eeeee40ee40';
    const ORDER = 'a0f82a3ed980d2b39c939bf221eeeeeeee40ee40';
    const ORDER_TIME = 'aw0f82at3ed98i0d2b39mc939bf221eeeeeeeee40ee40';
    const BRANCH = 'a02843f6a0a026b4fa0a93f602eeeeeeee40ee40';
    const KEY_ENCODE_ITERTATION = 1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct($query)
    {
        self::$q = $query;
        parent::__construct($query);
        $this->session = new Session(Session::USER_SESSION);
        $pages = explode("/", $query);
        if (!is_null($this->session->get(self::USER_ID))) {
            $this->user = new User();
            $this->user->setId(Encoding::decode($this->session->get(self::USER_ID), self::VALUE_ENCODE_ITERTATION));
            $this->user->setEmail(Encoding::decode($this->session->get(self::USER_EMAIL), self::VALUE_ENCODE_ITERTATION));
            $this->user =  $this->user->get();
            if ($pages[0] == "auth") {
                header('location:' . 'profile');
            }
        } else {
            // $this->user = new User();
            if ($pages[0] == "profile") {
                header('location:' . 'auth');
            }
        }
        if (isset($_COOKIE["order"])) {
            $this->session->set(self::ORDER, $_COOKIE['order']);
            $this->session->set(self::ORDER_TIME, time());
            setcookie('order', null, time() - 30, "/");
        } else {
            if ($pages[0] != 'checkout') {
                $this->session->set(self::ORDER, null);
            }
            if (is_null($this->session->get(self::ORDER)) && ($pages[0] == 'checkout')) {
                header('location:' . 'home');
            }
        }

        $this->cart = new CartItem();

        $this->traffic = new TrafficLogger();
        $log = new Log();
        $this->traffic->setLog(json_encode($log->properties()));
        $this->traffic->setTime(time());
        $this->traffic->setUrl(Server::getUrl());

        ($_SESSION[self::BRANCH] = null);

        if (!is_null($this->session->get(self::USER_ID))) {
            $this->favorites = new Favourite();
            $this->favorites->setUserId($this->user->getId());
            $this->favorites = $this->favorites->get();

            foreach ($this->favorites as $fav) {
                $this->favorites[] = $fav->getProductId();
                $product = new Product();
                $this->favProducts[] = $product->get($fav->getProductId());
            }
            $this->traffic->setSession($this->session->get(self::USER_ID));
            $this->history = new Order();
            $this->history = $this->history->get(null, $this->user->getId());
            $this->payment = new PaymentDetails($this->user->getId());
            $this->payment = $this->payment->get();
            $this->addresses = new Address($this->user->getId());
            $this->addresses = $this->addresses->get();
            $this->cart = $this->cart->get($this->user->getId());
        } else {
            if (!is_null($this->session->get(self::GUEST)) || isset($_COOKIE[self::GUEST])) {
                $this->session->set(self::GUEST, $_COOKIE[self::GUEST]);
                $this->traffic->setSession($this->session->get(self::GUEST) ?? $_COOKIE[self::GUEST]);
                $this->cart = $this->cart->get($this->session->get(self::GUEST) ?? $_COOKIE[self::GUEST]);
            } else {
                $value = md5(Encoding::encode(KeyFactory::genCoke()));
                $this->session->set(self::GUEST, $value);
                setcookie(self::GUEST, $value, time() + time(), "/");
            }
        }

        $this->categories = [];
        $this->branches = new Branch();
        $this->branches = $this->branches->get();
        $this->products = new Product();
        $this->products = $this->products->get();
        $this->pageSwitch($pages);
    }

    public function pageSwitch(array $pages)
    {
        $traffic = new TrafficLogger();
        $traffic = $traffic->get($this->traffic->getSession());
        $traffic = count($traffic) > 0 ? $traffic[count($traffic) == 0 ? 0 : count($traffic) - 1] : new TrafficLogger();

        $trafficPage = is_null($traffic->getPagesViewed()) ? array() : (array) fromDbJson($traffic->getPagesViewed());
        $trafficPage[$pages[0]] = intval($trafficPage[$pages[0]] ?? 0) + 1;

        $this->traffic->setPagesViewed(json_encode($trafficPage));
        $this->traffic->update();

        switch ($pages[0]) {
            case 'profile':
                $this->page = "app/Views/profile/profile.php";
                break;
            case 'checkout':
                if ($this->session->get(self::ORDER) != 'ZnJvbS1jYXJ0') {
                    $this->orderData =  json_decode(base64_decode($this->session->get(self::ORDER)));
                    if (is_array($this->orderData)) {
                        $carts = [];
                        foreach ($this->orderData as $order) {
                            $cart = new CartItem();
                            $cart->setProductId($order->pId);
                            $cart->setProductOptions($order->options);
                            $cart->setAmount($order->total);
                            $cart->setAdditionalNote($order->note);
                            $carts[] = ($cart->verifyItem());
                        }
                        $this->cart = $carts;
                    } else {
                        try {
                            $cart = new CartItem();
                            $cart->setProductId($this->orderData->pId);
                            $cart->setProductOptions($this->orderData->options);
                            $cart->setAmount($this->orderData->total);
                            $cart->setAdditionalNote($this->orderData->note);
                            $cart = array($cart->verifyItem());
                            $this->cart = $cart;
                        } catch (\Exception $e) {
                        }
                    }
                }
                $this->getTracking();
                $this->orderData = new Order();

                foreach ($this->cart as $cartItem) {
                    if (is_null($cartItem)) {
                        header('location:home');
                        //display error page
                    } else
                        $this->orderData->setAmount(intval($this->orderData->getAmount()) + (intval($cartItem->getAmount()) * intval($cartItem->getQuantity())));
                }
                $this->orderData->setCart($this->cart);
                $this->page = "app/Views/shop/checkout.php";
                break;
            case 'track':
                // Run the server application through the WebSocket protocol on port 8080
                // $app = new Ratchet\App('localhost', 800);
                // $app->route('/delivery', new Tracking, array("*"));
                // $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
                // $app->run();
                $this->getTracking();
                $this->page = "app/Views/shop/track.php";
                break;
            case 'branch':
                $this->page = "app/Views/shop/track.php";
                break;
            case 'auth':
                $this->page = "app/Views/auth.php";
                break;
            case 'logout':
                $this->session->destroy();
                header('location:' . 'shop');
                break;
            default:
                $this->page = "app/Views/home.php";
                break;
        }
        $this->renderPage();
    }

    public function getTracking()
    {
        $this->track = (object)[];
        if (isset($_COOKIE["cmVjZW50LW9yZGVy"]) && !isEmpty($_COOKIE["cmVjZW50LW9yZGVy"])) {
            $id = base64_decode($_COOKIE["cmVjZW50LW9yZGVy"]);
            $order = new Order();
            $this->track->order = $order->get($id);
            $delivery = new Delivery();
            $this->track->delivery = $delivery->get(null, $id);
        }
    }

    public function removeTracking()
    {
        setcookie(base64_encode('recent-order'), null, time() - time(), "/");
    }

    public static function getSession()
    {
        return new Session(Session::USER_SESSION);
    }
    public function renderPage()
    {
        $userController = new UserController($_POST);
        $userController->setUser($this->user);
        $userController = $userController->profileManagement();

        $settings = self::getSettings();
        $script = '<script> setCookie("currency","' . $settings->getCurrencyLocale() . '",20);';

        if (count($this->branches) == 1) {
            $this->branch = $this->branches[0];
        } else {
            if (isset($_COOKIE["YnJhbmNo"])) {
                $this->session->set(self::BRANCH, $_COOKIE["YnJhbmNo"]);
                $this->branch = new Branch();
                $this->branch = $this->branch->get(null, $this->session->get(self::BRANCH));
                if (isset($this->branch[0])) {
                    $this->branch =  $this->branch[0];
                } else {
                    $this->branch = null;
                    unset($_COOKIE["YnJhbmNo"]);
                    setcookie('YnJhbmNo', null, time() - 30, "/");
                    $script .= "$('#selectBranch').modal('toggle')";
                }
            } else if (isEmpty($this->branch)) {
                $script .= "$('#selectBranch').modal('toggle')";
            }
        }

        if ($this->branch != null) {
            if ($this->orderData != null) {
                $this->orderData->setBranch($this->branch->getId());
            }
            if (!isEmpty($this->branch->getDeliveryDistance()))
                $settings->setDeliveryDistance($this->branch->getDeliveryDistance());
            if (!isEmpty($this->branch->getDeliveryTimeRange()))
                $settings->setDeliveryTimeRange($this->branch->getDeliveryTimeRange());
            if (!isEmpty($this->branch->getDeliveryAreas()))
                $settings->setDeliveryAreas($this->branch->getDeliveryAreas());
            if (!isEmpty($this->branch->getShippingFee()))
                $settings->setShippingFee($this->branch->getShippingFee());
            if (!isEmpty($this->branch->getMinOrder()))
                $settings->setMinOrder($this->branch->getMinOrder());
            if (!isEmpty($this->branch->getDeliveryTime()))
                $settings->setDeliveryTime($this->branch->getDeliveryTime());
            if (!isEmpty($this->branch->getAddress()))
                $settings->setAddress($this->branch->getAddress());
            if (!isEmpty($this->branch->getAddressName()))
                $settings->setAddressName($this->branch->getAddressName());
            if (!isEmpty($this->branch->getOperationTime()))
                $settings->setOperationalTime(fromDbJson($this->branch->getOperationTime()));
        }

        $this->setOperationalTime($settings->getOperationalTime());
        $this->available = self::getAvailability($this->operationalTime[0] ?? new OperationalTime());

        $script .= '</script>';
        $settings->setScripts($script);
        $commerceController = new CommerceController($_POST);
        $commerceController->setUser($this->user);
        $commerceController->setOrder($this->orderData);
        $commerceController->setOpened($this->available);
        $commerceController->setMinOrder($settings->getMinOrder());
        $commerceController->setSession($this->session);
        $commerceController = $commerceController->manage();

        $commerceController_error  = null;
        $commerceController_result = null;
        $showCommerceController_result = false;
        if ($commerceController != null) {
            $showCommerceController_result = true;
            $commerceController_error = (json_decode($commerceController)->{Model::ERROR});
            $commerceController_result = isset(json_decode($commerceController)->{Model::RESULT});
        }

        $userController_result = null;
        $userController_error = null;
        $showUserController_result = false;
        if ($userController != null) {
            $showUserController_result = true;
            $userController_error = (json_decode($userController)->{Model::ERROR});
            $userController_result = isset(json_decode($userController)->{Model::RESULT});
            if (isset(json_decode($userController)->{Model::DATA})) {
                $data = (json_decode($userController)->{Model::DATA});
                $this->session->set(
                    self::USER_ID,
                    Encoding::encode($data->id, self::VALUE_ENCODE_ITERTATION)
                );
                $this->session->set(
                    self::USER_EMAIL,
                    Encoding::encode($data->email, self::VALUE_ENCODE_ITERTATION)
                );
                header('location:' . 'profile');
            }
        }

        $productCategories = new Category();
        $productCategories->setType(Category::TYPE_PRODUCT);
        $productCategories = $productCategories->get();

        include 'app/Views/header.php';
        if (@include($this->page));
        include 'app/Views/footer.php';
    }

    public function setOperationalTime($settingsTime)
    {
        foreach ($settingsTime ?? [] as $day) {
            $operationalTime = new OperationalTime();
            $operationalTime->setOpen($day->open);
            $operationalTime->setClose($day->close);
            $operationalTime->setBreakStart($day->breakStart);
            $operationalTime->setBreakEnd($day->breakEnd);

            switch (substr($day->day, 0, 3)) {
                case date('D'):
                    $this->operationalTime[0] = $operationalTime;
                    break;
                case date('D', strtotime("+1 day")):
                    $this->operationalTime[1] = $operationalTime;
                    break;
                case date('D', strtotime("+2 days")):
                    $this->operationalTime[2] = $operationalTime;
                    break;
                case date('D', strtotime("+3 days")):
                    $this->operationalTime[3] = $operationalTime;
                    break;
                case date('D', strtotime("+4 days")):
                    $this->operationalTime[4] = $operationalTime;
                    break;
                case date('D', strtotime("+5 days")):
                    $this->operationalTime[5] = $operationalTime;
                    break;
                case date('D', strtotime("+6 days")):
                    $this->operationalTime[6] = $operationalTime;
                    break;
            }
        }
    }

    public function getOperationalTime()
    {
        $days = [];
        for ($i = 0; $i < count(($this->operationalTime)); $i++) {
            $day = $this->operationalTime[$i];
            $nday = (object)[];
            $nday->open = $day->getOpen();
            $nday->close = $day->getClose();
            $nday->breakStart = $day->getBreakStart();
            $nday->breakEnd = $day->getBreakEnd();
            $days[$i] = $nday;
        }
        return $days;
    }
    public static function getAvailability(OperationalTime $operationalTime)
    {
        $available = false;
        $open = strtotime($operationalTime->getOpen());
        $close = strtotime($operationalTime->getClose());
        $breakS = strtotime($operationalTime->getBreakStart());
        $breakE = strtotime($operationalTime->getBreakEnd());
        if ($open == false) {
            $available = false;
        } else if (time() >= $open && time() <= $close) {
            $available = true;

            if (time() >= $breakS && time() <= $breakE) {
                $available = false;
            }
        }
        if (time() > $close) {
            $available = false;
        }
        return $available;
    }

    public static function getSettings()
    {
        $settings  =  new Setting();
        $settings->setMetaContent($settings->getLogo());
        $settings->setOperationalTime(fromDbJson($settings->getOperationalTime()));
        if ($settings->getUseTitleAsLogo()) {
            $settings->setLogo('<h1 class="title">' . $settings->getStoreName() . '</h1>');
            $settings->setMobileLogo('<h1 class="title-m">' . $settings->getStoreName() . '</h1>');
        } else {
            $settings->setMobileLogo('<img src="' . $settings->getLogo() . '" alt="" height="48" width="120" class="img img-fluid">');
            $settings->setLogo('<img src="' . $settings->getLogo() . '" alt="" height="48" width="120"  class="img img-fluid">');
        } //'<i class="icofont-stripe"></i>',

        if (isset($settings->getPaymentMethods()->card))
            $payment = ((bool)$settings->getPaymentMethods()->card) ? array(
                '<i class="icofont-mastercard"></i>', '<i class="icofont-visa"></i>',
                '<i class="icofont-diners-club"></i>', '<i class="icofont-amazon-alt"></i>', '<i class="icofont-american-express"></i>'
            ) : array();
        // <!-- <img class="img-fluid" src="assets/images/shop/mastercard.svg" height="48"><img class="img-fluid ml-4" src="assets/images/shop/amex.svg" height="48"><br>
        // <img class="img-fluid mt-4" src="assets/images/shop/stripe.svg" height="32"><img class="img-fluid ml-4 mt-4" src="assets/images/shop/visa.svg" height="32"> -->
        if (isset($settings->getPaymentMethods()->cash))
            $payment[] =  ((bool)$settings->getPaymentMethods()->cash) ? '<i class="icofont-cash-on-delivery-alt"></i>' : '';
        $settings->setPaymentMethods($payment ?? array());
        return $settings;
    }

    protected function decode()
    {
    }

    public function setApi($api)
    {
    }

    protected function setProperties()
    {
    }

    public function __destruct()
    {
        session_write_close();
    }
}
