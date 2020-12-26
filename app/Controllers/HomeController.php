<?php

namespace Demae\Controller\ShopController;

use Colors;
use danolez\lib\DB\Controller\Controller;
use danolez\lib\DB\Model\Model;
use danolez\lib\Res\Orientation\Orientation;
use danolez\lib\Res\Session\Session;
use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Contact\Contact;
use Demae\Auth\Models\Shop\Address\Address;
use Demae\Auth\Models\Shop\Branch\Branch;
use Demae\Auth\Models\Shop\Cart\CartItem;
use Demae\Auth\Models\Shop\Favourite\Favourite;
use Demae\Auth\Models\Shop\Log\Log;
use Demae\Auth\Models\Shop\Order\Order;
use Demae\Auth\Models\Shop\PaymentDetails\CreditCard;
use Demae\Auth\Models\Shop\PaymentDetails\PaymentDetails;
use Demae\Auth\Models\Shop\Product\Product;
use Demae\Auth\Models\Shop\Setting\Setting;
use Demae\Auth\Models\Shop\User\Administrator;
use Demae\Auth\Models\Shop\User\User;
use UserController;

class HomeController extends Controller
{
    private $page;
    private $session;
    private $user;
    private $addresses = array();
    private $payments = array();
    private $products;
    private $categories;
    private $branches;
    private $cart;
    private $orderData;

    const GUEST = "a0283fef1780f643a0639b0621eeeeeeee40ee40";
    const USER_ID = '942826bb3efa2237a02ad2e56b29f64c80b3ee8043d902d69cf96bf221eeeeeeee40ee40';
    const USER_EMAIL = '502826bb3efa2237a02ad2e56b29f64c80b3ee80434b0243d9d963d1a0939b28f17d1eeeee40ee40';
    const ORDER = 'a0f82a3ed980d2b39c939bf221eeeeeeee40ee40';
    const ORDER_TIME = 'aw0f82at3ed98i0d2b39mc939bf221eeeeeeeee40ee40';
    const KEY_ENCODE_ITERTATION = 1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct($query)
    {
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
            if ($pages[0] == "profile") {
                header('location:' . 'auth');
            }
        }
        if (isset($_COOKIE["order"])) {
            $cookie = json_decode($_COOKIE['order']);
            $orderKey = iterativeBase64Decode($cookie->id, 1);
            $orderData = iterativeBase64Decode($cookie->data, $orderKey);
            $this->session->set(self::ORDER, $orderData);
            $this->session->set(self::ORDER_TIME, time());
        } else {
            if (is_null($this->session->get(self::ORDER)) && ($pages[0] == 'checkout')) {
                echo "no session order, and page is checkout";
                header('location:' . 'home');
            }
        }
        switch ($pages[0]) {
            case 'profile':
                $this->page = "app/Views/profile/profile.php";
                break;
            case 'checkout':
                $this->orderData = json_decode($this->session->get(self::ORDER));
                $this->page = "app/Views/shop/checkout.php";
                break;
            case 'track':
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

    public function renderPage()
    {
        $userController = new UserController($_POST);
        $userController->setUser($this->user);
        $userController = $userController->profileManagement();
        $this->cart = new CartItem();
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
        if (!is_null($this->session->get(self::USER_ID))) {
            $favorites = [];
            $history = [];
            $this->payment = new PaymentDetails($this->user->getId());
            $this->payment = $this->payment->get();
            $this->addresses = new Address($this->user->getId());
            $this->addresses = $this->addresses->get();
            $this->cart = $this->cart->get($this->user->getId());
        } else {
            if (!is_null($this->session->get(self::GUEST))) {
                $this->cart = $this->cart->get($this->session->get(self::GUEST));
            } else {
                $log = new Log();
                $this->session->set(
                    self::GUEST,
                    Encoding::encode(json_encode($log->properties()), self::VALUE_ENCODE_ITERTATION)
                );
            }
        }


        $this->branches = new Branch();
        $this->branches = $this->branches->get();
        // var_dump($this->branches);


        $this->products = new Product();
        $this->products = $this->products->get();
        $available = !true;
        $this->categories = [];
        $settings = $this->getSettings();

        include 'app/Views/header.php';
        if (@include($this->page));
        include 'app/Views/footer.php';
    }

    public function getSettings()
    {
        $settings  =  new Setting();
        $settings->setMetaContent($settings->getLogo());
        if ($settings->getUseTitleAsLogo()) {
            $settings->setLogo('<h1 class="title">' . $settings->getStoreName() . '</h1>');
            $settings->setMobileLogo('<h1 class="title-m">' . $settings->getStoreName() . '</h1>');
        } else {
            $settings->setLogo('<img src="' . $settings->getLogo() . '" alt="" height="48" width="120"  class="img img-fluid">');
            $settings->setMobileLogo('<img src="' . $settings->getLogo() . '" alt="" height="48" width="120" class="img img-fluid">');
        } //'<i class="icofont-stripe"></i>',
        $payment = ((bool)$settings->getPaymentMethods()->card) ? array(
            '<i class="icofont-mastercard"></i>', '<i class="icofont-visa"></i>',
            '<i class="icofont-diners-club"></i>', '<i class="icofont-amazon-alt"></i>', '<i class="icofont-american-express"></i>'
        ) : array();
        // <!-- <img class="img-fluid" src="assets/images/shop/mastercard.svg" height="48"><img class="img-fluid ml-4" src="assets/images/shop/amex.svg" height="48"><br>
        // <img class="img-fluid mt-4" src="assets/images/shop/stripe.svg" height="32"><img class="img-fluid ml-4 mt-4" src="assets/images/shop/visa.svg" height="32"> -->

        $payment[] =  ((bool)$settings->getPaymentMethods()->cash) ? '<i class="icofont-cash-on-delivery-alt"></i>' : '';
        $settings->setPaymentMethods($payment);
        $settings->setScripts('<script> setCookie("currency","' . $settings->getCurrencyLocale() . '",20);</script>');


        //selected Branch
        //language determination
        //location determination for closet branch
        //location based distance restriction 
        //order condition display
        $settings->setDeliveryDistance('');
        $settings->setDeliveryTime(30);
        $settings->setOperationalTime('');
        // $settings->setColors();
        $settings->setAddress('4-9-15 Ebisu, Shibuya-ku, Tokyo HAGIWA Building 5 3F');
        $settings->setAddressName('Wagyu Creation 411 Hanare');
        $settings->setShippingFee(0);

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
