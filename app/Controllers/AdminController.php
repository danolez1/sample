<?php

namespace Demae\Controller\ShopController;

use danolez\lib\DB\Controller\Controller;
use danolez\lib\DB\Model\Model;
use danolez\lib\Res\Session\Session;
use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Error\Error;
use Demae\Auth\Models\Shop\Administrator\Administrator;
use Demae\Auth\Models\Shop\Branch\Branch;
use Demae\Auth\Models\Shop\Log\Log;
use Demae\Auth\Models\Shop\Product\Category;
use Demae\Auth\Models\Shop\Product\Product;
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
    private $branches;
    private $ceoPages = ['dashboard', 'branches', 'settings', 'promotions', 'users', 'staffs', 'add-product', 'products'];
    private $managerPages = ['users', 'add-product', 'products', 'branch-dashboard', 'branch-setting', 'staffs'];

    const ADMIN_ID = '942826bb3efa2237a02ad2e56b08cffa43282a01f128d237c50abbf221eeeeeeee40ee40';
    const ADMIN_USERNAME = '6c2826bb3efa2237a02ad2e56b08cffa43282a01f128d2f9d2b37080fad8cf0a4b630a3f43f9eef2ee40ee40';
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
        // $this->admin->setRole(2);

        $ceo = (in_array($this->query, $this->ceoPages));
        $manager = (in_array($this->query, $this->managerPages));
        $both = ($ceo && $manager) && (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2);

        if ($both) {
        } else  if ($ceo &&  intval($this->admin->getRole()) != 1) {
            header('location:' . 'orders');
        } else if ($manager && intval($this->admin->getRole()) != 2) {
            header('location:' . 'orders');
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
                $this->page = "app/Views/admin/pages/branches.php";
                break;
            case 'products':
                $this->page = "app/Views/admin/pages/products.php";
                break;
            case 'add-product':
                $this->page = "app/Views/admin/pages/add_product.php";
                break;
            case 'staffs':
                $this->page = "app/Views/admin/pages/staff.php";
                break;
            case 'branch-setting':
                // $this->page = ;
                break;
            case 'branch-dashboard':
                // $this->page = ;
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
                header('location:' . 'shop');
                break;
            default:
                $this->page = "app/Views/admin/home.php";
        }
        $this->renderPage();
    }


    public function renderPage()
    {
        $userController = new UserController($_POST);
        $userController = $userController->authentication();
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


        // if (isset($_POST['register'])) {
        //     $register = $this->createAdmin();
        //     $registration_error = (json_decode($register)->{Model::ERROR});
        //     $registration_result = isset(json_decode($register)->{Model::RESULT});
        // }
        // if (isset($_POST['auth'])) {
        //     $login = $this->authenticate();
        //     $authentication_error = (json_decode($login)->{Model::ERROR});
        //     $authentication_result = isset(json_decode($login)->{Model::RESULT});
        //     if (isset(json_decode($login)->{Model::DATA})) {
        //         $data = (json_decode($login)->{Model::DATA});
        //         $this->session->set(
        //             self::ADMIN_ID,
        //             Encoding::encode($data->id, self::VALUE_ENCODE_ITERTATION)
        //         );
        //         $this->session->set(
        //             self::ADMIN_USERNAME,
        //             Encoding::encode($data->username, self::VALUE_ENCODE_ITERTATION)
        //         );
        //         header('location:' . 'dashboard');
        //     }
        // }


        if (!is_null($this->session->get(self::ADMIN_ID))) {
            if (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2) {

                if (isset($_POST['add-branch'])) {
                    $addBranch = $this->createBranch();
                    $addBranch_error = (json_decode($addBranch)->{Model::ERROR});
                    $addBranch_result = isset(json_decode($addBranch)->{Model::RESULT});
                    $branchInfo = true;
                }
                if (isset($_POST['add-staff'])) {
                    $addStaff = $this->createAdmin();
                    $addStaff_error = (json_decode($addStaff)->{Model::ERROR});
                    $addStaff_result = isset(json_decode($addStaff)->{Model::RESULT});
                    $staffInfo = true;
                }

                if (isset($_POST['create-product'])) {
                    $newProduct = $this->createProduct();
                    $newProduct_error = (json_decode($newProduct)->{Model::ERROR});
                    $newProduct_result = isset(json_decode($newProduct)->{Model::RESULT});
                    $newProductInfo = true;
                }
                $this->branches = new Branch();
                $this->branches = $this->branches->get($this->admin);
                $this->staff = new Administrator();
                $this->staff = $this->staff->getStaffs($this->admin);
                $this->customers = new User();
                $this->customers = $this->customers->getAllUser();
            }
        }
        $productCategories = new Category();
        $productCategories->setType(Category::TYPE_PRODUCT);
        $productCategories = $productCategories->get();

        $optionsCategories = new Category();
        $optionsCategories->setType(Category::TYPE_OPTION);
        $optionsCategories = $optionsCategories->get();

        // $ds = new Category();
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


    public function createProduct()
    {
        $product = new Product();
        $product->setAvailability($_POST['product-availability']);
        $product->setPrice($_POST['product-price']);
        $product->setName($_POST['product-name']);
        $product->setDescription($_POST['product-description']);
        $product->setDisplayImage($_POST['product-img']);
        if (isset($_POST['product-category']))
            $product->setCategory($_POST['product-category']);
        $product->setProductOptions($_POST['options']);
        $product->setTimeCreated(time());
        $product->setAuthor(array($this->admin->getUsername(), $this->admin->getId()));
        if ($this->admin->getRole() == '1' && isset($_POST['product-branch'])) {
            $product->setBranchId($_POST['product-branch']);
        } else {
            $product->setBranchId($this->admin->getBranchId());
        }
        return $product->create();
    }

    public function sendMail()
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
        # code...
    }



    public function createBranch()
    {
        if ($this->admin->getRole() == 1) {
            $branch = new Branch();
            $branch->setName($_POST['name']);
            $branch->setLocation($_POST['location']);
            $branch->setStaffNo($_POST['staff-no'] ?? 0);
            $branch->setStatus($_POST['status'] ?? 1);
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

    public function createAdmin()
    {
        $admin = new Administrator();
        $admin->setEmail($_POST['email']);
        $admin->setName($_POST['name']);
        $admin->setRole($_POST['role']);
        $log = new Log();
        $admin->setLog(json_encode($log->properties()));
        $admin->setAddedBy($this->admin->getId());
        $admin->setBranchId($_POST['branch']);
        return $admin->register();
    }

    public function authenticate()
    {
        $admin = new Administrator();
        $admin->setUsername($_POST['username']);
        $admin->setPassword($_POST['password']);
        return ($admin->authenticate());
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
