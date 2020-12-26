<?php

namespace Demae\Route\ApiRoute;

use danolez\lib\DB\Route\Router;
use danolez\lib\Res\Curl\Curl;
use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Shop\Address\Address;
use Demae\Auth\Models\Shop\Administrator\Administrator;
use Demae\Auth\Models\Shop\Branch\Branch;
use Demae\Auth\Models\Shop\Cart\CartItem;
use Demae\Auth\Models\Shop\PaymentDetails\PaymentDetails;
use Demae\Auth\Models\Shop\Product\Category;
use Demae\Auth\Models\Shop\Product\Product;
use Demae\Controller\ShopController\HomeController;

class ApiRoute extends Router
{
    private $endPoint = [
        'get/postalGeoCode', 'post/deleteMOP', 'post/deleteAddress', 'post/addFavorite',
        'post/addToCart', 'post/deleteBranch', 'post/deleteStaff', 'post/addCategory', 'post/deleteProduct'
    ];

    const POSTAL_GEOCODE_URL = "https://dev.virtualearth.net/REST/v1/Locations?";
    const MICROSOFT_KEY = "AuObwcrNH47oHLfNor44iwwaVJ8pjYvleWNPC7BzODLLqQveElDZJea10G6jX6Fh";

    public function __construct($query)
    {
        // UserAuth
        parent::__construct($query);
        switch ($this->getPath()) {
            case $this->endPoint[0]:
                echo $this->postalGeoCode(($this->getParams()["zip"]));
                break;
            case $this->endPoint[1]:
                $data = json_decode(Encoding::decode($_POST['id']));
                echo $this->deleteMOP($data);
                break;
            case $this->endPoint[2]:
                $data = json_decode(Encoding::decode($_POST['id']));
                echo $this->deleteAddress($data);
                break;
            case $this->endPoint[3]:
                echo $this->addFavorite();
                break;
            case $this->endPoint[4]:
                $key = iterativeBase64Decode($_POST['id'], 1);
                $data = iterativeBase64Decode($_POST['data'], $key);
                echo $this->addToCart($data);
                break;
            case $this->endPoint[5]:
                $data = json_decode(Encoding::decode($_POST['id']));
                echo $this->deleteBranch($data);
                break;
            case $this->endPoint[6]:
                $data = json_decode(Encoding::decode($_POST['id']));
                echo $this->deleteStaff($data);
                break;
            case $this->endPoint[7]:
                $data = json_encode($_POST);
                echo $this->addCategory($data);
                break;
            case $this->endPoint[8]:
                $data = json_decode(Encoding::decode($_POST['id']));
                echo $this->deleteProduct($data);
                break;
            default:
                echo "Error 404: Page not found";
                include 'app/Views/404.php';
                break;
        }
    }

    private function addCategory($data)
    {
        $data = json_decode($data);
        $category = new Category();
        $category->setName($data->name);
        $category->setDescription($data->description);
        $category->setType($data->type);
        $category->setTimeCreated(time());
        $creator = json_decode(Encoding::decode($data->creatorId));
        $category->setCreator($creator);
        return $category->create();
    }

    private function addFavorite()
    {
        # code...
    }

    private function addToCart($data)
    {
        $data = (json_decode($data));
        $cart = new CartItem();
        $cart->setProductId($data->pId->id);
        $cart->setProductDetails($data->pId->name);
        $cart->setProductOptions($data->options);
        $cart->setUserId(Encoding::decode($data->sId, HomeController::VALUE_ENCODE_ITERTATION));
        $cart->setAmount($data->total);
        $cart->setAdditionalNote($data->note);
        return $cart->add();
    }
    private function deleteProduct($data)
    {
        $product = new Product();
        $product->setId($data[0]);
        $product->tempAuthor = array($data[2], $data[1]);
        return $product->delete();
    }
    private function deleteBranch($data)
    {
        $address = new Branch($data[0], $data[1]);
        return $address->delete();
    }
    private function deleteStaff($data)
    {
        $admin = new Administrator($data[0], $data[1]);
        return $admin->delete();
    }

    private function deleteAddress($id)
    {
        $info = new Address($id[0], $id[1]);
        return $info->delete();
    }

    private function deleteMOP($id)
    {
        $mop = new PaymentDetails($id[0], $id[1]);
        return $mop->delete();
    }

    private function postalGeoCode($zip)
    {
        // $curl = new Curl(self::POSTAL_GEOCODE_URL);
        // $curl->addParam("countryRegion", "JP");
        // $curl->addParam("postalCode", $zip);
        // $curl->addParam("culture", "ja");
        // $curl->addParam("key", self::MICROSOFT_KEY);
        // var_dump($curl->get());
        $resource = (file_get_contents(self::POSTAL_GEOCODE_URL . "countryRegion=JP&postalCode=$zip&culture=ja&key=" . self::MICROSOFT_KEY));
        return json_encode(json_decode($resource)->resourceSets[0]->resources[0]->address);
    }
}
