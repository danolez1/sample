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
        if (isset($_POST["sign-up"])) {
            $register = $this->register();
            $registration_error = (json_decode($register)->{Model::ERROR});
            $registration_result = isset(json_decode($register)->{Model::RESULT});
            //login after
        }
        if (isset($_POST["login"])) {
            $login = $this->auth();
            $authentication_error = (json_decode($login)->{Model::ERROR});
            $authentication_result = isset(json_decode($login)->{Model::RESULT});
            if (isset(json_decode($login)->{Model::DATA})) {
                $data = (json_decode($login)->{Model::DATA});
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
        if (isset($_POST["save-card"])) {
            $saveCard = $this->savePayment();
            $saveCard_error = (json_decode($saveCard)->{Model::ERROR});
            $saveCard_result = isset(json_decode($saveCard)->{Model::RESULT});
            $showAddCard = true;
        }
        if (isset($_POST['save-address'])) {
            $saveAddress = $this->saveAddress();
            $saveAddress_error = (json_decode($saveAddress)->{Model::ERROR});
            $saveAddress_result = isset(json_decode($saveAddress)->{Model::RESULT});
            $showAddAddress = true;
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

    public function savePayment()
    {
        $creditCard = new CreditCard();
        $creditCard->cardName = $_POST['name'];
        $creditCard->cardNumber = removeSpace($_POST['number']);
        $creditCard->expiryDate = removeSpace($_POST['expiry']);
        $creditCard->cardType = get_card_brand($creditCard->cardNumber);
        $creditCard->cvv = $_POST['cvc'];
        $paymentDetails = new PaymentDetails();
        $paymentDetails->setTimeCreated(time());
        $paymentDetails->setUserId($this->user->getId());
        $log = new Log();
        $paymentDetails->setLog(json_encode($log->properties()));
        $paymentDetails->setCreditCard($creditCard);
        return ($paymentDetails->saveCard());
    }

    public function saveAddress()
    {
        $address = new Address();
        $address->setFirstName($_POST['fname']);
        $address->setLastName($_POST['lname']);
        $address->setPhoneNumber($_POST['phone']);
        $address->setEmail($_POST['email']);
        $address->setZip($_POST['zip']);
        $address->setCity($_POST['city']);
        $address->setState($_POST['state']);
        $address->setAddress($_POST['address']);
        $address->setStreet($_POST['street']);
        $address->setBuilding($_POST['building']);
        $address->setUserId($this->user->getId());
        $address->setTimeCreated(time());
        $log = new Log();
        $address->setLog(json_encode($log->properties()));
        return $address->save();
    }

    public function auth()
    {
        $user = new User();
        $user->setEmail($_POST['lemail']);
        $user->setPassword($_POST['lpassword']);
        return ($user->authenticate());
    }

    public function register()
    {
        $user = new User();
        $user->setName($_POST['name']);
        $user->setEmail($_POST['remail']);
        $user->setPhoneNumber($_POST['phone']);
        $user->setPassword($_POST['rpassword']);
        $log = new Log();
        $user->setLog(json_encode($log->properties()));
        $user->setTimeCreated(time());
        return $user->register();
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
        $settings->setDisplayRating(false);
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
        $settings->setMenuDisplayOrientation(Orientation::VERTICAL);
        $settings->setInfoDisplayOrientation(Orientation::HORIZONTAL);
        $settings->setProductDisplayOrientation(Orientation::LIST);
        $settings->setSliderType(2);
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
