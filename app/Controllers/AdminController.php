<?php

namespace Demae\Controller\ShopController;

use danolez\lib\DB\Controller\Controller;
use danolez\lib\DB\Model\Model;
use danolez\lib\Res\Session\Session;
use danolez\lib\Security\Encoding\Encoding;
use DashboardController;
use Demae\Auth\Models\Error\Error;
use Demae\Auth\Models\Shop\Administrator\Administrator;
use Demae\Auth\Models\Shop\Branch\Branch;
use Demae\Auth\Models\Shop\Log\Log;
use Demae\Auth\Models\Shop\Product\Category;
use Demae\Auth\Models\Shop\Product\Product;
use Demae\Auth\Models\Shop\Setting\Setting;
use Demae\Auth\Models\Shop\User\User;
use UserController;

class AdminController extends Controller
{
    private $page;
    private $includesOnly = false;
    private $admin;
    private $settings;
    private $orders;
    private $products;
    private $customers;
    private $staff;
    private $editProduct;
    private $branches;
    private $ceoPages = ['settings', 'promotions'];
    private $managerPages = ['users', 'dashboard', 'branches', 'branch-setting', 'add-product', 'edit-product', 'products', 'staffs',];

    const ADMIN_ID = '942826bb3efa2237a02ad2e56b08cffa43282a01f128d237c50abbf221eeeeeeee40ee40';
    const ADMIN_USERNAME = '6c2826bb3efa2237a02ad2e56b08cffa43282a01f128d2f9d2b37080fad8cf0a4b630a3f43f9eef2ee40ee40';
    const EDIT_PRODUCT = '94282a1543fa26d6082afabcc543ef176b633f3517d8f22a9cf96bf221eeeeeeee40ee40';
    const KEY_ENCODE_ITERTATION = 1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct($query)
    {
        parent::__construct($query);
        $this->session = new Session(Session::ADMIN_SESSION);
        if (is_null($this->session->get(self::ADMIN_ID))) {
            if ($this->query != "admin-auth")
                header('location:' . 'admin-auth');
        } else {
            $this->admin = new Administrator();
            $this->admin->setId(Encoding::decode($this->session->get(self::ADMIN_ID), self::VALUE_ENCODE_ITERTATION));
            $this->admin->setUsername(Encoding::decode($this->session->get(self::ADMIN_USERNAME), self::VALUE_ENCODE_ITERTATION));
            $this->admin =  $this->admin->get();
        }
        // $this->admin->setRole(3);

        $ceoPage = (in_array($this->query, $this->ceoPages));
        $managerPage = (in_array($this->query, $this->managerPages));
        if (($managerPage && intval($this->admin->getRole()) > 2) || ($ceoPage && intval($this->admin->getRole()) > 1)) {
            header('location:' . 'orders');
        }
        if ($this->query == 'branches' && intval($this->admin->getRole()) == 2) {
            header('location:' . 'branch-setting');
        }

        if (!is_null($this->session->get(self::EDIT_PRODUCT)) && ($this->query != 'add-product' && $this->query != 'edit-product')) {
            unset($_SESSION[self::EDIT_PRODUCT]);
            unset($_SESSION['editProductId']);
        }

        switch ($this->query) {
            case 'admin-auth':
                $this->includesOnly = true;
                $this->page = "app/Views/admin/auth.php";
                break;
            case 'dashboard':
                $this->page = "app/Views/admin/home.php";
                break;
            case 'orders':
                $this->page = "app/Views/admin/pages/orders.php";
                break;
            case 'branches':
            case 'branch-setting':
                $this->page = "app/Views/admin/pages/branches.php";
                break;
            case 'products':
                $this->page = "app/Views/admin/pages/products.php";
                break;
            case 'add-product':
            case 'edit-product':
                if ((isset($_COOKIE['editProductId']) && !isEmpty($_COOKIE['editProductId']))
                    || !is_null($this->session->get(self::EDIT_PRODUCT))
                ) {
                    $this->editProduct = new Product();
                    $this->editProduct = $this->editProduct->get($_COOKIE['editProductId'] ?? $_SESSION[self::EDIT_PRODUCT]);
                    if ((isset($_COOKIE['editProductId']) && !isEmpty($_COOKIE['editProductId'])))
                        $this->session->set(self::EDIT_PRODUCT, $_COOKIE['editProductId']);
                    setcookie('editProductId', '', time() - 3600, '/');
                }
                $this->page = "app/Views/admin/pages/add_product.php";
                break;
            case 'staffs':
                $this->page = "app/Views/admin/pages/staff.php";
                break;
            case 'users':
                $this->page = "app/Views/admin/pages/customers.php";
                break;
            case 'promotions':
                $this->page = "app/Views/admin/pages/chartjs.php";
                break;
            case 'documentation':
                $this->page = "app/Views/admin/pages/documentation.php";
                break;
            case 'admin-faqs':
                $this->page = "app/Views/admin/pages/documentation.php";
                break;
            case 'settings':
                $this->page = "app/Views/admin/pages/settings.php";
                break;
            case 'admin-logout':
                $this->session->destroy();
                header('location:' . 'admin-auth');
                break;
            default:
                $this->page = "app/Views/admin/home.php";
        }
        $this->renderPage();
    }


    public function renderPage()
    {
        $userController = new UserController($_POST);
        $userController->setAdmin($this->admin);
        $userController = $userController->adminAuth();
        if ($userController != null) {
            $userController_error = (json_decode($userController)->{Model::ERROR});
            $userController_result = isset(json_decode($userController)->{Model::RESULT});
            if (isset(json_decode($userController)->{Model::DATA})) {
                $data = (json_decode($userController)->{Model::DATA});
                $this->session->set(
                    self::ADMIN_ID,
                    Encoding::encode($data->id, self::VALUE_ENCODE_ITERTATION)
                );
                $this->session->set(
                    self::ADMIN_USERNAME,
                    Encoding::encode($data->username, self::VALUE_ENCODE_ITERTATION)
                );
                header('location:' . 'dashboard');
            }
        }

        $dashboardController = new DashboardController($_POST);
        $dashboardController->setAdmin($this->admin);
        $dashboardController->setEditProduct($this->editProduct);

        if (!is_null($this->session->get(self::ADMIN_ID))) {
            if (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2) {
                $this->branches = new Branch();
                $this->branches = $this->branches->get($this->admin);
                $this->staff = new Administrator();
                $this->staff = $this->staff->getStaffs($this->admin);
                $this->customers = new User();
                $this->customers = $this->customers->getAllUser();
                $dashboardController->setBranch($this->branches);
                //branch Id to check which
                $dashboardController = $dashboardController->management();
                if ($dashboardController != null) {
                    $dashboardController_error = (json_decode($dashboardController)->{Model::ERROR});;
                    $dashboardController_result = isset(json_decode($dashboardController)->{Model::RESULT});;
                    $showDashboardController_result = true;
                }
            }
        }
        $this->products = new Product();
        $this->products = $this->products->get();
        $productCategories = new Category();
        $productCategories->setType(Category::TYPE_PRODUCT);
        $productCategories = $productCategories->get();

        $optionsCategories = new Category();
        $optionsCategories->setType(Category::TYPE_OPTION);
        $optionsCategories = $optionsCategories->get();

        $this->settings = new Setting();

        // $ds = new Branch();
        // $keys = $ds->properties()[Model::KEYS];
        // foreach ($keys as $k) {
        //     echo 'const ' . strtoupper($k) . ' = "' . ($k) . '";<br>';
        // }

        include 'app/Views/admin/header.php';
        if (@include($this->page));
        include 'app/Views/admin/footer.php';
    }

    public function getAnalytics()
    {
        # code...
    }

    public function settingsPost()
    {
        // if (isset($_POST['add-settings'])) {
        //     $addSettings = $this->addSettings();
        //     $addSettings_error = (json_decode($addStaff)->{Model::ERROR});
        //     $addSettings_result = isset(json_decode($addStaff)->{Model::RESULT});
        //     $settingsInfo = true;
        // }

        if (isset($_POST['settings-upload-banner'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-store-info'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-order-condition'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-payment'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-upload-logo'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-upload-banner'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-upload-banner'])) {
            $banner = $_POST['banner'];
        }
        if (isset($_POST['settings-upload-banner'])) {
            $banner = $_POST['banner'];
        }
    }

    public function addSettings()
    {
        # 7-14
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
