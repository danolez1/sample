<?php

namespace Demae\Route;

use danolez\lib\DB\Router;
use Demae\Controller\ShopController\AdminController;
use Demae\Controller\ShopController\HomeController;
use Demae\Route\ApiRoute;

class AppRoute extends Router
{
    private $home = ["", 'home', 'shop', 'profile', 'track', 'checkout', 'cart', 'auth', 'logout'];
    private $admin = ['admin', 'admin-auth', 'add-product', 'edit-product', 'branch-setting', 'admin-faqs', 'admin-logout', 'admin-profile', 'dashboard', 'orders', 'branches', 'products', 'staffs', 'users', 'promotions', 'documentation', 'settings'];
    private $apiMethod = ['get', 'post'];
    public function __construct($query)
    {
        parent::__construct($query);
        if (count(explode("/".basename(dirname(__DIR__))."/", $query)) > 1) {
            $query = explode("/".basename(dirname(__DIR__))."/", $query)[1];
        } else {
            $query = explode("/", $query)[1];
        }
        $pages = explode("/", $query);
        if (in_array($query, $this->home) || in_array($pages[0], $this->home)) {
            new HomeController($query);
        } else if (in_array($query, $this->admin) ||  in_array($pages[0], $this->admin)) {
            new AdminController($query);
        } else if (in_array($query, $this->apiMethod) || in_array($pages[0], $this->apiMethod)) {
            new ApiRoute($query);
        } else {
            include 'app/Views/404.php';
        }
    }
}
