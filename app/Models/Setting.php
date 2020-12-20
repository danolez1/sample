<?php

namespace Demae\Auth\Models\Shop\Setting;

use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use ReflectionClass;
use ReflectionProperty;
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
    // WEBSITE DESIGN
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
    // PRODUCT
    private $displayOrderCount;
    private $currency;
    private $showTax;
    private $minOrder;
    private $displayRating;
    // DELIVERY
    private $shippingFee;
    private $deliveryTime;
    private $deliveryTimeRange;
    private $deliveryAreas;
    private $deliveryDistance;
    // PAYMENT
    private $paymentMethods;
    private $operationalTime; //show Image
    // OTHERS
    // <!--SEO: description,logo,title, store name , url, tags-->
    private $metaContent;
    private $theme;
    private $scripts;
    private $branches;


    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::SETTINGS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function add()
    {
        // if doesn not exist add
        //if exist update
    }

    public function get()
    {
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
            //$encKey = Encoding::encode($key, self::KEY_ENCODE_ITERTATION);
            //  $obj->{$key} = $data->{$encKey};
            $obj->{$key} =  ($data->{$encKey}); //,$key
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
        return $this->operationalTime;
    }

    /**
     * Set the value of operationalTime
     *
     * @return  self
     */
    public function setOperationalTime($operationalTime)
    {
        $this->operationalTime = $this->purify($operationalTime);

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
        return $this->displayRating;
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
        return $this->sliderType;
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
        return $this->menuDisplayOrientation;
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
        return $this->infoDisplayOrientation;
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
        return $this->displayOrderCount;
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
        return $this->productDisplayOrientation;
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
        return $this->footerType;
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
    public function getCurrency()
    {
        return $this->currency;
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
}
