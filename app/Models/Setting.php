<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Res\Email;
use danolez\lib\Res\Orientation;
use danolez\lib\Res\Server;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\CreditCard;
use Demae\Controller\HomeController;
use OperationalTime;
use ReflectionClass;
use ReflectionProperty;
use Sabberworm\CSS\Settings;
use SettingsColumn;

class Setting extends Model
{
    // HEADER INFO
    private $title;
    private $logo;
    private $storeName;
    private $bannerTitle;
    private $bannerText;
    private $mobileLogo;
    private $bannerImage;
    private $tags;
    private $description;
    // WEBSITE DESIGN
    private $useTitleAsLogo;
    private $sliderType;
    private $footerType;
    private $colors;
    private $menuDisplayOrientation;
    private $infoDisplayOrientation;
    private $productDisplayOrientation;
    // WEBSITE INFO
    private $address;
    private $phoneNumber;
    private $addressName;
    private $socials;
    private $websiteUrl;
    private $email;
    // PRODUCT
    private $displayOrderCount;
    private $currency;
    private $showTax;
    private $minOrder;
    private $displayRating;
    private $imagePlaceholder;
    // DELIVERY
    private $shippingFee;
    private $deliveryTime;
    private $deliveryTimeRange;
    private $deliveryAreas;
    private $deliveryDistance;
    private $freeDeliveryPrice;
    private $timeCreated;
    // PAYMENT
    private $paymentMethods;
    private $operationalTime; //show Image
    // OTHERS
    // <!--SEO: description,logo,title, store name , url, tags-->
    private $metaContent;
    private $theme;
    private $scripts;
    private $branches;
    private $subscriptions;

    private $defaultPrinter;
    private $printLanguage;
    private $takeOut;
    private $homeDelivery;
    private $printNodeApi;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;
    const BASE_PAYMENT = 5000;
    const ADDITIONAL_BRANCH = 3000;
    const TAX = 0.10;

    public function __construct()
    {
        parent::__construct(parent::FILE_MODEL);
        if ($this->file->getFile() == "") {
            $this->defaultSettings();
            $this->file->setFile(json_encode($this->object(false)));

            $this->file->save();
        } else {
            foreach ($this->file->getFile() as $property => $value) {
                $this->$property = $value;
            }
        }
    }


    protected function setTableName()
    {
        $this->tableName = Credential::SETTINGS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function getOrientationWords($ppt)
    {
        if (intval($ppt) == 1) {
            return array("Horizontal", "trn" => "horizontal", 'other' => array("Vertical", "trn" => "vertical"));
        } elseif (intval($ppt) == 2) {
            return array("Vertical", "trn" => "vertical", "other" => array("Horizontal", "trn" => "horizontal",));
        } else return null;
    }

    public static function getInstance()
    {
        return new Setting();
    }

    public function calculateSubscription(int $branch)
    {
        if ($branch < 2) return self::BASE_PAYMENT + (self::BASE_PAYMENT * self::TAX);
        else if ($branch > 1) {
            $cal = self::BASE_PAYMENT + (self::ADDITIONAL_BRANCH * ($branch - 1));
            return $cal + ($cal * self::TAX);
        }
    }

    public function update()
    {
        $return = array();
        $this->file->setFile(json_encode($this->object(false)));
        $return[parent::RESULT] = $this->file->save();
        $return[parent::ERROR] = null;
        return json_encode($return);
    }

    public function sendNotificationMail()
    {
        $mail = new Email();
        // $mail->setTo($this->email, $this->name); ADMIN
        $EN = $_COOKIE['lingo'] == 'en';
        $name = Setting::getInstance()->getStoreName();
        $mail->setSubject($EN ? "【 $name 】- Notification" : "【 $name 】- お知らせ");
        $message['en'] = "Thank you for using $name. You just added a payment method to your profile. This is an automatic message to indicate changes made on your profile, so you don't have to reply.";
        $message['jp'] = "$name ご利用いただきありがとうございます。お客様のクレジットカードを追加しました。　これは、メッセージを受け取ったことを示す自動返信なので、返信する必要はありません。";
        $body = file_get_contents('app/Views/email/contact.php');
        $body = str_replace("{name}",  $this->name . '様', $body);
        $body = str_replace("{message['en']}", $message["en"], $body);
        $body = str_replace("{message['jp']}", $message["jp"], $body);
        $body = str_replace("{{SOCIALS}}", "", $body);
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.facebook.com/" target="_blank"><img alt="Facebook" height="32" src="images/facebook2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Facebook" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://twitter.com/" target="_blank"><img alt="Twitter" height="32" src="images/twitter2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Twitter" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="images/instagram2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Instagram" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.linkedin.com/" target="_blank"><img alt="LinkedIn" height="32" src="images/linkedin2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="LinkedIn" width="32" /></a></td>
        $settings = HomeController::getSettings();
        if (!$settings->getUseTitleAsLogo()) {
            $mail->setAttachment($settings->getMetaContent());
            $mail->setAttachmentName("logo-img");
        }
        $logo = '<img align="center" border="0" class="center autowidth" src="cid:logo-img" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 140px; display: block;"  width="140" />';
        $body = str_replace("{{LOGO}}", $settings->getUseTitleAsLogo() ? $settings->getLogo() : $logo, $body);
        $mail->setBody($message['en'] . "\r\n \r\n" . $message['jp']);
        $mail->setHtml($body);
        $mail->sendWithHostSTMP();
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
        if ($data == null) return new Setting();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Setting();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
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
                // if ($key == SettingsColumn::PASSWORD) { 
                //     // $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION)
                //: $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
                // } else {
                $assoc ? $temp[$key] = ($value) : $temp[] = ($value);
                //  }
            }
            return $temp;
        } else {
            return Credential::encrypt($data); //,$key
        }
    }

    public function defaultSettings()
    {
        $this->setPaymentMethods(null);
        $this->setLogo('assets/images/home/logo_red.svg');
        $this->setBannerTitle("FOOD DELIVERY");
        $this->setBannerText("売上手数料なし,独自出前システム 飲食店、個人店舗のデリバリー＆テイクアウト、 手数料0円の独自受注システムがご利用できます。");
        $this->setDeliveryTime("30");
        $this->setOperationalTime(null);
        $this->setMinOrder(800);
        $this->setDisplayRating(true);
        $this->setTitle("Demae System");
        $this->setWebsiteUrl('https://test.demae-system.com');
        $this->setStoreName("店舗名");
        $this->setBannerImage('assets/image/shop/meatball.png');
        $this->setSliderType(2);
        $this->setMenuDisplayOrientation(Orientation::HORIZONTAL);
        $this->setInfoDisplayOrientation(Orientation::HORIZONTAL);
        $this->setDisplayOrderCount(true);
        $this->setProductDisplayOrientation(Orientation::GRID);
        // $this->setTheme();
        $this->setDeliveryDistance(15000);
        $this->setFooterType(1);
        // $this->setBranches();
        // $this->setColors();
        $this->setCurrency('jpy');
        $this->setAddress('Wagyu Creation 411 Hanare');
        $this->setPhoneNumber("000-0000-0000");
        $this->setAddressName(' 4-9-15 Ebisu, Shibuya-ku, Tokyo HAGIWA Building 5 3F');
        // $this->setSocials(null);
        $this->setShowTax(true);
        for ($i = 0; $i < count(daysOfWeek()); $i++) {
            $operationTime = new OperationalTime();
            $operationTime->setDay(daysOfWeek()[$i]);
            $operationTime->setOpen("");
            $operationTime->setBreakStart("");
            $operationTime->setBreakEnd("");
            $operationTime->setClose("");
            $times[] = $operationTime->properties(true);
        }
        $this->setOperationalTime(json_encode($times));
        $this->setDeliveryAreas('東、中央区、北区、南区、本町');
        $this->setShippingFee(200);
        $this->setDeliveryTimeRange(10);
        $this->setImagePlaceholder("assets/images/shop/food_placeholder.png");
        // $this->setSubscriptions();
        $this->setTags("pizza, rice, meat, 焼鳥、焼肉");
        $this->setDescription("pizza, rice, meat, 焼鳥、焼肉");
        $this->setUseTitleAsLogo(true);
        $this->setEmail('admin@demae-system.com');
        $this->setFreeDeliveryPrice(1000);
        $this->setTakeOut(true);
        $this->setHomeDelivery(true);
        // $this->setDefaultPrinter();
        $this->setPrintLanguage('en');
        $this->setPaymentMethods(array("cash" => true, 'card' => true));
        $this->setPrintNodeApi('');
        $this->setTimeCreated(time());
    }


    /**
     * Get the value of paymentMethods
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    /**
     * Set the value of paymentMethods
     *
     * @return  self
     */
    public function setPaymentMethods($paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;

        return $this;
    }

    /**
     * Get the value of logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @return  self
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get the value of bannerTitle
     */
    public function getBannerTitle()
    {
        return $this->bannerTitle;
    }

    /**
     * Set the value of bannerTitle
     *
     * @return  self
     */
    public function setBannerTitle($bannerTitle)
    {
        $this->bannerTitle = $bannerTitle;

        return $this;
    }

    /**
     * Get the value of bannerText
     */
    public function getBannerText()
    {
        return $this->bannerText;
    }

    /**
     * Set the value of bannerText
     *
     * @return  self
     */
    public function setBannerText($bannerText)
    {
        $this->bannerText = $bannerText;

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

    /**
     * Get the value of operationalTime
     */
    public function getOperationalTime()
    {
        return ($this->operationalTime);
    }

    /**
     * Set the value of operationalTime
     *
     * @return  self
     */
    public function setOperationalTime($operationalTime)
    {
        $this->operationalTime = ($operationalTime);

        return $this;
    }

    /**
     * Get the value of minOrder
     */
    public function getMinOrder()
    {
        return $this->minOrder;
    }

    /**
     * Set the value of minOrder
     *
     * @return  self
     */
    public function setMinOrder($minOrder)
    {
        $this->minOrder = $minOrder;

        return $this;
    }

    /**
     * Get the value of displayRating
     */
    public function getDisplayRating()
    {
        return (bool) $this->displayRating;
    }

    /**
     * Set the value of displayRating
     *
     * @return  self
     */
    public function setDisplayRating($displayRating)
    {
        $this->displayRating = $displayRating;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of websiteUrl
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Set the value of websiteUrl
     *
     * @return  self
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * Get the value of storeName
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * Set the value of storeName
     *
     * @return  self
     */
    public function setStoreName($storeName)
    {
        $this->storeName = $storeName;

        return $this;
    }

    /**
     * Get the value of metaContent
     */
    public function getMetaContent()
    {
        return $this->metaContent;
    }

    /**
     * Set the value of metaContent
     *
     * @return  self
     */
    public function setMetaContent($metaContent)
    {
        $this->metaContent = $metaContent;

        return $this;
    }

    /**
     * Get the value of mobileLogo
     */
    public function getMobileLogo()
    {
        return $this->mobileLogo;
    }

    /**
     * Set the value of mobileLogo
     *
     * @return  self
     */
    public function setMobileLogo($mobileLogo)
    {
        $this->mobileLogo = $mobileLogo;

        return $this;
    }

    /**
     * Get the value of bannerImage
     */
    public function getBannerImage()
    {
        return $this->bannerImage;
    }

    /**
     * Set the value of bannerImage
     *
     * @return  self
     */
    public function setBannerImage($bannerImage)
    {
        $this->bannerImage = $bannerImage;

        return $this;
    }

    /**
     * Get the value of sliderType
     */
    public function getSliderType()
    {
        return intval($this->sliderType) - 1;
    }

    /**
     * Set the value of sliderType
     *
     * @return  self
     */
    public function setSliderType($sliderType)
    {
        $this->sliderType = $sliderType;

        return $this;
    }

    /**
     * Get the value of menuDisplayOrientation
     */
    public function getMenuDisplayOrientation()
    {
        return intval($this->menuDisplayOrientation);
    }

    /**
     * Set the value of menuDisplayOrientation
     *
     * @return  self
     */
    public function setMenuDisplayOrientation($menuDisplayOrientation)
    {
        $this->menuDisplayOrientation = $menuDisplayOrientation;

        return $this;
    }

    /**
     * Get the value of infoDisplayOrientation
     */
    public function getInfoDisplayOrientation()
    {
        return intval($this->infoDisplayOrientation);
    }

    /**
     * Set the value of infoDisplayOrientation
     *
     * @return  self
     */
    public function setInfoDisplayOrientation($infoDisplayOrientation)
    {
        $this->infoDisplayOrientation = $infoDisplayOrientation;

        return $this;
    }

    /**
     * Get the value of displayOrderCount
     */
    public function getDisplayOrderCount()
    {
        return (bool) $this->displayOrderCount;
    }

    /**
     * Set the value of displayOrderCount
     *
     * @return  self
     */
    public function setDisplayOrderCount($displayOrderCount)
    {
        $this->displayOrderCount = $displayOrderCount;

        return $this;
    }

    /**
     * Get the value of productDisplayOrientation
     */
    public function getProductDisplayOrientation()
    {
        return intval($this->productDisplayOrientation);
    }

    /**
     * Set the value of productDisplayOrientation
     *
     * @return  self
     */
    public function setProductDisplayOrientation($productDisplayOrientation)
    {
        $this->productDisplayOrientation = $productDisplayOrientation;

        return $this;
    }

    /**
     * Get the value of theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set the value of theme
     *
     * @return  self
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get the value of deliveryDistance
     */
    public function getDeliveryDistance()
    {
        return $this->deliveryDistance;
    }

    /**
     * Set the value of deliveryDistance
     *
     * @return  self
     */
    public function setDeliveryDistance($deliveryDistance)
    {
        $this->deliveryDistance = $deliveryDistance;

        return $this;
    }

    /**
     * Get the value of footerType
     */
    public function getFooterType()
    {
        return intval($this->footerType) - 1;
    }

    /**
     * Set the value of footerType
     *
     * @return  self
     */
    public function setFooterType($footerType)
    {
        $this->footerType = $footerType;

        return $this;
    }

    /**
     * Get the value of scripts
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * Set the value of scripts
     *
     * @return  self
     */
    public function setScripts($scripts)
    {
        $this->scripts = $scripts;

        return $this;
    }

    /**
     * Get the value of branches
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * Set the value of branches
     *
     * @return  self
     */
    public function setBranches($branches)
    {
        $this->branches = $branches;

        return $this;
    }

    /**
     * Get the value of colors
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Set the value of colors
     *
     * @return  self
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }


    /**
     * Get the value of currency
     */
    public function getCurrencyLocale()
    {
        return strtoupper($this->currency);
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        $json = json_decode(file_get_contents(RESOURCES . 'json' . DIRECTORY_SEPARATOR . 'currency_code.json'));
        return $json->{strtoupper($this->currency)};
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

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
     * Get the value of phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of addressName
     */
    public function getAddressName()
    {
        return $this->addressName;
    }

    /**
     * Set the value of addressName
     *
     * @return  self
     */
    public function setAddressName($addressName)
    {
        $this->addressName = $addressName;

        return $this;
    }

    /**
     * Get the value of socials
     */
    public function getSocials()
    {
        return $this->socials;
    }

    /**
     * Set the value of socials
     *
     * @return  self
     */
    public function setSocials($socials)
    {
        $this->socials = $socials;

        return $this;
    }

    /**
     * Get the value of showTax
     */
    public function getShowTax()
    {
        return $this->showTax;
    }

    /**
     * Set the value of showTax
     *
     * @return  self
     */
    public function setShowTax($showTax)
    {
        $this->showTax = $showTax;

        return $this;
    }

    /**
     * Get the value of deliveryAreas
     */
    public function getDeliveryAreas()
    {
        return $this->deliveryAreas;
    }

    /**
     * Set the value of deliveryAreas
     *
     * @return  self
     */
    public function setDeliveryAreas($deliveryAreas)
    {
        $this->deliveryAreas = $deliveryAreas;

        return $this;
    }

    /**
     * Get the value of shippingFee
     */
    public function getShippingFee()
    {
        return $this->shippingFee;
    }

    /**
     * Set the value of shippingFee
     *
     * @return  self
     */
    public function setShippingFee($shippingFee)
    {
        $this->shippingFee = $shippingFee;

        return $this;
    }

    /**
     * Get the value of deliveryTimeRange
     */
    public function getDeliveryTimeRange()
    {
        return $this->deliveryTimeRange;
    }

    /**
     * Set the value of deliveryTimeRange
     *
     * @return  self
     */
    public function setDeliveryTimeRange($deliveryTimeRange)
    {
        $this->deliveryTimeRange = $deliveryTimeRange;

        return $this;
    }

    /**
     * Get the value of imagePlaceholder
     */
    public function getImagePlaceholder()
    {
        return $this->imagePlaceholder;
    }

    /**
     * Set the value of imagePlaceholder
     *
     * @return  self
     */
    public function setImagePlaceholder($imagePlaceholder)
    {
        $this->imagePlaceholder = $imagePlaceholder;

        return $this;
    }

    /**
     * Get the value of subscriptions
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * Set the value of subscriptions
     *
     * @return  self
     */
    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;

        return $this;
    }

    /**
     * Get the value of tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the value of tags
     *
     * @return  self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of useTitleAsLogo
     */
    public function getUseTitleAsLogo()
    {
        return (bool) $this->useTitleAsLogo;
    }

    /**
     * Set the value of useTitleAsLogo
     *
     * @return  self
     */
    public function setUseTitleAsLogo($useTitleAsLogo)
    {
        $this->useTitleAsLogo = $useTitleAsLogo;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of freeDeliveryPrice
     */
    public function getFreeDeliveryPrice()
    {
        return $this->freeDeliveryPrice;
    }

    /**
     * Set the value of freeDeliveryPrice
     *
     * @return  self
     */
    public function setFreeDeliveryPrice($freeDeliveryPrice)
    {
        $this->freeDeliveryPrice = $freeDeliveryPrice;

        return $this;
    }

    /**
     * Get the value of takeOut
     */
    public function getTakeOut()
    {
        return $this->takeOut;
    }

    /**
     * Set the value of takeOut
     *
     * @return  self
     */
    public function setTakeOut($takeOut)
    {
        $this->takeOut = $takeOut;

        return $this;
    }

    /**
     * Get the value of homeDelivery
     */
    public function getHomeDelivery()
    {
        return $this->homeDelivery;
    }

    /**
     * Set the value of homeDelivery
     *
     * @return  self
     */
    public function setHomeDelivery($homeDelivery)
    {
        $this->homeDelivery = $homeDelivery;

        return $this;
    }

    /**
     * Get the value of defaultPrinter
     */
    public function getDefaultPrinter()
    {
        return $this->defaultPrinter;
    }

    /**
     * Set the value of defaultPrinter
     *
     * @return  self
     */
    public function setDefaultPrinter($defaultPrinter)
    {
        $this->defaultPrinter = $defaultPrinter;

        return $this;
    }

    /**
     * Get the value of printLanguage
     */
    public function getPrintLanguage()
    {
        return $this->printLanguage;
    }

    /**
     * Set the value of printLanguage
     *
     * @return  self
     */
    public function setPrintLanguage($printLanguage)
    {
        $this->printLanguage = $printLanguage;

        return $this;
    }

    /**
     * Get the value of printNodeApi
     */
    public function getPrintNodeApi()
    {
        return $this->printNodeApi;
    }

    /**
     * Set the value of printNodeApi
     *
     * @return  self
     */
    public function setPrintNodeApi($printNodeApi)
    {
        $this->printNodeApi = $printNodeApi;

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
}
