<?php

use danolez\lib\DB\Controller;
use danolez\lib\DB\Model;
use danolez\lib\Res\Payment\StripeApi;
use danolez\lib\Security\Encoding;
use danolez\lib\Security\KeyFactory;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Administrator;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Log;
use Demae\Auth\Models\Shop\CreditCard;
use Demae\Auth\Models\Shop\PaymentDetails;
use Demae\Auth\Models\Shop\Product;
use Demae\Auth\Models\Shop\Setting;
use Demae\Auth\Models\Shop\User;

class DashboardController extends Controller
{
    private $admin;
    private $editProduct;
    private $branch;

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function management()
    {
        if (isset($this->data['add-branch'])) {
            return  $this->createBranch();
        } else if (isset($this->data['add-staff'])) {
            return $this->createAdmin();
        } else if (isset($this->data['create-product'])) {
            $product = $this->setProduct();
            return $product->create();
        } else if (isset($this->data['update-product'])) {
            $product = $this->setProduct();
            return $product->update();
        } else if (isset($this->data['upload-banner'])) {
            $settings  =  new Setting();
            $upload = uploadFile('browse',  "images/", Encoding::encode('banner'));
            if ($upload == null) {
                //
            } else {
                $settings->setBannerImage($upload);
            }
            return $settings->update();
        } else if (isset($this->data['save-header-info'])) {
            $settings  =  new Setting();
            $settings->setTitle($this->data['store-title']);
            $settings->setStoreName($this->data['store-name']);
            $settings->setWebsiteUrl($this->data['website-url']);
            if (isset($this->data['use-title-as-logo'])) {
                $settings->setUseTitleAsLogo($this->data['use-title-as-logo']);
            } else {
                $settings->setUseTitleAsLogo(null);
            }
            $settings->setTags($this->data['seo-tags']);
            $settings->setDescription($this->data['seo-description']);
            return $settings->update();
        } else if (isset($this->data['upload-logo'])) {
            $settings  =  new Setting();
            $upload = uploadFile('browse1',  "images/", Encoding::encode('logo'));
            $settings->setLogo($upload);
            $settings->setMobileLogo($upload);
            return $settings->update();
        } else if (isset($this->data['save-website-design'])) {
            $settings  =  new Setting();
            $settings->setBannerTitle($this->data['banner-title']);
            $settings->setBannerText($this->data['banner-content']);
            $settings->setMenuDisplayOrientation($this->data['menu-display']);
            $settings->setInfoDisplayOrientation($this->data['info-display']);
            $settings->setProductDisplayOrientation(1/*$this->data['product-display']*/);
            // $settings->setProductDisplayOrientation($this->data['product-display']);
            $settings->setSliderType($this->data['slider-type']);
            $settings->setFooterType($this->data['footer-type']);
            $settings->setColors($this->data['theme-color']);
            return $settings->update();
        } else if (isset($this->data['website-info'])) {
            $settings  =  new Setting();
            $settings->setEmail($this->data['email']);
            $settings->setPhoneNumber($this->data['phone']);
            $settings->setSocials(array('facebook' => $this->data['fb'], 'twitter' => $this->data['twitter'], 'instagram' => $this->data['ig'],));
            return $settings->update();
        } else if (isset($this->data['delivery-options'])) {
            $settings  =  new Setting();
            $settings->setShippingFee($this->data['shipping-fee']);
            $settings->setFreeDeliveryPrice($this->data['free-shipping-price']);
            $settings->setDeliveryTimeRange($this->data['time-range']);
            $settings->setDeliveryTime($this->data['delivery-time']);
            $settings->setAddress($this->data['address']);
            $settings->setAddressName($this->data['address-name']);
            $settings->setDeliveryAreas($this->data['delivery-area']);
            $settings->setDeliveryDistance($this->data['delivery-distance']);
            return $settings->update();
        } else if (isset($this->data['save-product-info'])) {
            $settings  =  new Setting();
            $settings->setCurrency($this->data['currency']);
            $settings->setMinOrder($this->data['min-order']);
            if (isset($this->data['display-tax'])) {
                $settings->setShowTax($this->data['display-tax']);
            } else {
                $settings->setShowTax(null);
            }
            if (isset($this->data['display-order-count'])) {
                $settings->setDisplayOrderCount($this->data['display-order-count']);
            } else {
                $settings->setDisplayOrderCount(null);
            }
            if (isset($this->data['display-rating'])) {
                $settings->setDisplayRating($this->data['display-rating']);
            } else {
                $settings->setDisplayRating(null);
            }
            return $settings->update();
        } else if (isset($this->data['upload-placeholder'])) {
            $settings  =  new Setting();
            $upload = uploadFile('browse2',  "images/", Encoding::encode('placeholder'));
            if ($upload == null) {
                //
            } else {
                $settings->setImagePlaceholder($upload);
            }
            return $settings->update();
        } else if (isset($this->data['payment-method'])) {
            $settings  =  new Setting();
            $cash = $this->data['pm-cash'] ?? null;
            $card = $this->data['pm-card'] ?? null;
            $settings->setPaymentMethods(array("cash" => $cash, 'card' => $card));
            return $settings->update();
        } else if (isset($this->data['operational-time'])) {
            $settings  =  new Setting();
            $times = array();
            for ($i = 0; $i < count(daysOfWeek()); $i++) {
                $operationTime = new OperationalTime();
                $operationTime->setDay(daysOfWeek()[$i]);
                $operationTime->setOpen(array_values($this->data['shop-open'])[$i]);
                $operationTime->setBreakStart(array_values($this->data['shop-break-start'])[$i]);
                $operationTime->setBreakEnd(array_values($this->data['shop-break-end'])[$i]);
                $operationTime->setClose(array_values($this->data['shop-close'])[$i]);
                $times[] = $operationTime->properties(true);
            }
            $settings->setOperationalTime(json_encode($times));
            return $settings->update();
        } else if (isset($this->data['save-branch-optime'])) {
            $return = array();
            $error = null;
            $branch = null;
            foreach ($this->branch as $key => $value) {
                if ($value->getId() == $this->data['branch-id']) {
                    $branch = $value;
                    break;
                }
            }
            if ($branch instanceof Branch) {
                $times = array();
                for ($i = 0; $i < count(daysOfWeek()); $i++) {
                    $operationTime = new OperationalTime();
                    $operationTime->setDay(daysOfWeek()[$i]);
                    $operationTime->setOpen(array_values($this->data['shop-open'])[$i]);
                    $operationTime->setBreakStart(array_values($this->data['shop-break-start'])[$i]);
                    $operationTime->setBreakEnd(array_values($this->data['shop-break-end'])[$i]);
                    $operationTime->setClose(array_values($this->data['shop-close'])[$i]);
                    $times[] = $operationTime->properties(true);
                }
                $branch->setOperationTime(json_encode($times));
                $return[Model::RESULT] = $branch->update();
            } else {
                $error = Error::Unauthorised;
            }
            $return[Model::ERROR] = $error;
            return json_encode($return);
        } else if (isset($this->data['branch-details'])) {
            $return = array();
            $error = null;
            $branch = null;
            foreach ($this->branch as $key => $value) {
                if ($value->getId() == $this->data['branch-id']) {
                    $branch = $value;
                    break;
                }
            }
            if ($branch instanceof Branch) {
                $branch->setMinOrder($this->data["min-order"]);
                $branch->setShippingFee($this->data['shipping-fee']);
                $branch->setDeliveryTimeRange($this->data['time-range']);
                $branch->setDeliveryTime($this->data['delivery-time']);
                $branch->setAddress($this->data['address']);
                $branch->setDeliveryAreas($this->data['delivery-area']);
                $branch->setDeliveryDistance($this->data['delivery-distance']);
                $return[Model::RESULT] = $branch->update();
            } else {
                $error = Error::Unauthorised;
            }
            $return[Model::ERROR] = $error;
            return json_encode($return);
        } else if (isset($this->data['branch-printer-info'])) {
            $return = array();
            $error = null;
            $branch = null;
            foreach ($this->branch as $key => $value) {
                if ($value->getId() == $this->data['branch-id']) {
                    $branch = $value;
                    break;
                }
            }
            if ($branch instanceof Branch) {
                $branch->setDefaultPrinter($this->data['default-printer']);
                $branch->setPrintLanguage($this->data["print-lang"]);
                $branch->setPrintNodeApi($this->data['pnapi']);
                $return[Model::RESULT] = $branch->update();
            } else {
                $error = Error::Unauthorised;
            }
            $return[Model::ERROR] = $error;
            return json_encode($return);
        } else if (isset($this->data['delivery-method'])) {
            $settings  =  new Setting();
            $settings->setHomeDelivery($this->data['home-delivery'] ?? null);
            $settings->setTakeOut($this->data['takeout'] ?? null);
            return $settings->update();
        } else if (isset($this->data['printer-info'])) {
            $settings  =  new Setting();
            $settings->setDefaultPrinter($this->data['default-printer']);
            $settings->setPrintLanguage($this->data["print-lang"]);
            $settings->setPrintNodeApi($this->data['pnapi']);
            return $settings->update();
        } else if (isset($this->data['add-card'])) {
            $settings  =  new Setting();
            $creditCard = new CreditCard();
            $creditCard->cardName = $this->data['name'];
            $creditCard->cardNumber = removeSpace($this->data['number']);
            $creditCard->expiryDate = removeSpace($this->data['expiry']);
            $creditCard->cardType = get_card_brand($creditCard->cardNumber);
            $creditCard->cvv = $this->data['cvc'];
            $paymentDetails = new PaymentDetails();
            $paymentDetails->setTimeCreated(time());
            $paymentDetails->email = $this->admin->getEmail();
            $paymentDetails->name = $this->admin->getName();
            $settings->setSubscriptions(KeyFactory::genCoke());
            $paymentDetails->setUserId($settings->getSubscriptions());
            $log = new Log();
            $paymentDetails->setLog(json_encode($log->properties()));
            $paymentDetails->setCreditCard($creditCard);
            $save = $paymentDetails->saveCard();
            if ((json_decode($save)->{Model::RESULT})) {
                return $settings->update();
            } else return $save;
        } else return null;
    }



    private function setProduct($edit = false): Product
    {
        $product = new Product();
        $product->setAvailability($this->data['product-availability']);
        $product->setPrice($this->data['product-price']);
        $product->setName($this->data['product-name']);
        $product->setDescription(str_replace("\\", "", $this->data['product-description']));
        $upload = uploadFile('product-image',  "images/products/", Encoding::encode($product->getName() . time()));
        if ($upload == null) {
            $product->setDisplayImage($this->data['product-image']);
        } else {
            $product->setDisplayImage($upload);
        }

        if (isset($this->data['product-category']))
            $product->setCategory(json_encode($this->data['product-category']));
        $product->setProductOptions(base64_decode($this->data['options']));
        $product->setTimeCreated(time());
        $product->tempAuthor = array($this->admin->getUsername(), $this->admin->getId());
        if (!is_null($this->getEditProduct())) {
            $product->setId($this->editProduct->getId());
        }
        $product->setAuthor(is_null($this->getEditProduct()) ? $this->admin->getId() : $this->editProduct->getAuthor());
        if ($this->admin->getRole() == '1') {
            $product->setBranchId(json_encode($this->data['product-branch'] ?? null));
        } else {
            $product->setBranchId(isset($this->data['product-branch']) ? $this->data['product-branch'] : json_encode([$this->admin->getBranchId()]));
        }
        return $product;
    }

    protected function createBranch()
    {
        if ($this->admin->getRole() == 1) {
            $branch = new Branch();
            $branch->setName($this->data['name']);
            $branch->setLocation($this->data['location']);
            $branch->setStaffNo($this->data['staff-no'] ?? 0);
            $branch->setStatus($this->data['status'] ?? 1);
            $log = new Log();
            $branch->setLog(json_encode($log->properties()));
            $branch->setAdmin($this->admin->getId());
            $branch->setTimeCreated(time());
            return $branch->add();
        } else {
            $return[Model::ERROR] = Error::Unauthorised;
            return json_encode($return);
        }
    }

    protected function createAdmin()
    {
        $admin = new Administrator();
        $admin->setEmail($this->data['email']);
        $admin->setName($this->data['name']);
        $admin->setRole($this->data['role']);
        $log = new Log();
        $admin->setLog(json_encode($log->properties()));
        $admin->setAddedBy($this->admin->getId());
        $admin->setBranchId($this->data['branch']);
        return $admin->register();
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

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @return  self
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get the value of editProduct
     */
    public function getEditProduct()
    {
        return $this->editProduct;
    }

    /**
     * Set the value of editProduct
     *
     * @return  self
     */
    public function setEditProduct($editProduct)
    {
        $this->editProduct = $editProduct;

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
}
