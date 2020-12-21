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

    const USER_ID = '942826bb3efa2237a02ad2e56b29f64c80b3ee8043d902d69cf96bf221eeeeeeee40ee40';
    const USER_EMAIL = '502826bb3efa2237a02ad2e56b29f64c80b3ee80434b0243d9d963d1a0939b28f17d1eeeee40ee40';
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

        switch ($pages[0]) {
            case 'profile':
                $this->page = "app/Views/profile/profile.php";
                break;
            case 'checkout':
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
            $cart = [];
        }

        $this->products = [];
        $available = !true;
        $this->categories = [];
        $this->branches = [];
        $settings = $this->getSettings();

        include 'app/Views/header.php';
        if (@include($this->page));
        include 'app/Views/footer.php';
    }

    public function getSettings()
    {
        $settings  =  new Setting();
        // $class_methods = get_class_methods($settings);

        // foreach ($class_methods as $method_name) {
        //     echo '$settings->' . "$method_name();<br>";
        // }
        $settings->setLogo('<h1 class="title">IOTA</h1>'); // <img src="assets/images/home/logo.svg" alt="" height="48" width="120">
        $settings->setMobileLogo('<h1 class="title-m">IOTA</h1>'); // <img src="assets/images/home/logo.svg" alt="" height="48" width="120">
        $settings->setTitle('OITA');
        $settings->setMetaContent('something');
        $settings->setBannerImage('assets/images/shop/sushi1.png'); //../images/shop/meatball.png   ../images/shop/sushi.png
        $settings->setDisplayRating(true);
        $settings->setScripts('');
        $settings->setWebsiteUrl('https://');
        $settings->setStoreName('IOTA');
        $settings->setDisplayOrderCount(true);
        $settings->setBannerTitle('The best meat balls in town');
        //The <b>Best Sushi</b><br> in Sapporo</h1> 
        //The <b>Best Turkey</b> Resturant in town
        $settings->setBannerText('Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.');
        //Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.
        $settings->setTheme('');
        $settings->setMenuDisplayOrientation(Orientation::HORIZONTAL);
        $settings->setInfoDisplayOrientation(Orientation::HORIZONTAL);
        $settings->setProductDisplayOrientation(Orientation::GRID);
        $settings->setSliderType(3);
        $settings->setFooterType(0);
        $settings->setDeliveryDistance('');
        $settings->setMinOrder(1400);
        $settings->setDeliveryTime(30); //array("branchId"=>30);
        $settings->setOperationalTime('');
        $settings->setCurrency('¥');
        $colors = new Colors();
        $colors->setMainColor('');
        $settings->setColors($colors);
        $settings->setAddress('4-9-15 Ebisu, Shibuya-ku, Tokyo HAGIWA Building 5 3F');
        $settings->setAddressName('Wagyu Creation 411 Hanare');
        $settings->setPhoneNumber('07063809604');
        $settings->setShippingFee(0);
        $settings->setPaymentMethods(array(
            '<i class="icofont-cash-on-delivery-alt"></i>', '<i class="icofont-mastercard"></i>', '<i class="icofont-visa"></i>',
            '<i class="icofont-diners-club"></i>', '<i class="icofont-stripe"></i>', '<i class="icofont-amazon-alt"></i>', '<i class="icofont-american-express"></i>',
        ));
        $settings->setSocials(array('facebook' => '', 'twitter' => '', 'instagram' => '',));
        $settings->setDeliveryAreas(array("Kasuga Elementary School", "Nishidai Elementary School", "Omichi Elementary School", " Kanaike Elementary School", "Nagahama Elementary School", "Sumiyoshi Elementary School"));
        // $settings->getDeliveryTime();
        // $settings->getOperationalTime();
        // $settings->getTheme();
        // $settings->getDeliveryDistance();
        // $settings->getBranches();
        // $settings->setBranches('');
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
