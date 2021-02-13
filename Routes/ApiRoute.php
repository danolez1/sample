<?php

namespace Demae\Route;

use AdministratorColumn;
use danolez\lib\DB\Model;
use danolez\lib\DB\Router;
use danolez\lib\Res\Curl;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Address;
use Demae\Auth\Models\Shop\Administrator;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Cart\CartItem;
use Demae\Auth\Models\Shop\Delivery;
use Demae\Auth\Models\Shop\Favourite;
use Demae\Auth\Models\Shop\Order;
use Demae\Auth\Models\Shop\PaymentDetails;
use Demae\Auth\Models\Shop\Product\Category;
use Demae\Auth\Models\Shop\Product;
use Demae\Auth\Models\Shop\Setting;
use Demae\Auth\Models\Shop\User;
use Demae\Controller\HomeController;
use Ratings;

class ApiRoute extends Router
{
    private $endPoint = [
        'get/postalGeoCode', 'post/deleteMOP', 'post/deleteAddress', 'post/addFavorite', 'post/addToCart', 'post/deleteBranch',
        'post/deleteStaff', 'post/addCategory', 'post/deleteProduct', 'post/updateCartQuantity', 'post/deleteCartItem', 'get/cartItems',
        'post/updateOrderStatus', 'post/updateProductStatus', 'post/updateBranchStatus', 'post/updateStaffLevel', 'post/removeFavorite',
        'post/updateDeliveryTime', 'post/addRatings', 'post/deleteOrder', 'post/updateDelivery', 'post/deleteSubscription', 'get/orderNotification',
    ];

    const POSTAL_GEOCODE_URL = "https://dev.virtualearth.net/REST/v1/Locations?";
    const MICROSOFT_KEY = "AuObwcrNH47oHLfNor44iwwaVJ8pjYvleWNPC7BzODLLqQveElDZJea10G6jX6Fh";

    public function __construct($query)
    {
        if (count(explode("/", $query)) > 1) {
            $query = explode("/", $query);
            unset($query[0]);
            $query = implode('/', $query);
        }
        parent::__construct($query);
        // Could be more flexible
        // check in_array() and change case factor
        if (isset($_POST['id'])) {
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
                    $data = json_decode(Encoding::decode($_POST['id']));
                    echo $this->addFavorite($data);
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
                case $this->endPoint[9]:
                    echo $this->updateCartItem($_POST);
                    break;
                case $this->endPoint[10]:
                    echo $this->deleteCartItem(json_decode(Encoding::decode($_POST['id'])));
                    break;
                case $this->endPoint[11]:
                    $userId = Encoding::decode($_POST['id']);
                    echo $this->getCartItems($userId);
                    break;
                case $this->endPoint[12]:
                    $orderId = json_decode(Encoding::decode($_POST['id']));
                    echo $this->updateOrderStatus($orderId, $_POST['status']);
                    break;
                case $this->endPoint[13]:
                    $orderId = json_decode(Encoding::decode($_POST['id']));
                    echo $this->updateProductStatus($orderId, $_POST['status']);
                    break;
                case $this->endPoint[14]:
                    $orderId = json_decode(Encoding::decode($_POST['id']));
                    echo $this->updateBranchStatus($orderId, $_POST['status']);
                    break;
                case $this->endPoint[15]:
                    $orderId = json_decode(Encoding::decode($_POST['id']));
                    echo $this->updateStaffLevel($orderId, $_POST['status']);
                    break;
                case $this->endPoint[16]:
                    $data = json_decode(Encoding::decode($_POST['id']));
                    echo $this->removeFavorite($data);
                    break;
                case $this->endPoint[17]:
                    $data = json_decode(Encoding::decode($_POST['id']));
                    echo $this->updateTimeDelivery($data, $_POST['time']);
                    break;
                case $this->endPoint[18]:
                    $data = json_decode(Encoding::decode($_POST['id']));
                    echo $this->addRatings($data, $_POST['ratings'] ?? null, $_POST['comment']);
                    break;
                case $this->endPoint[19]:
                    $data = json_decode(Encoding::decode($_POST['id']));
                    echo $this->deleteOrder($data);
                    break;
                case $this->endPoint[20]:
                    if (isset($_POST['id'])) {
                        $data = base64_decode($_POST['id']);
                        echo $this->updateDelivery($data);
                    }
                    break;
                case $this->endPoint[21]:
                    $data = json_decode(Encoding::decode($_POST['id']));
                    echo $this->deleteMOP($data);
                    break;
                case $this->endPoint[22]:
                    $data = json_decode(Encoding::decode($_POST['id']));
                    $branchId = $data[1];
                    $count = intval($data[0]);
                    $adminRole = $data[2];
                    echo $this->orderNotification($count, $branchId, $adminRole);
                    break;

                default:
                    echo "Error 404: Page not found";
                    include 'app/Views/404.php';
                    break;
            }
        }
    }


    public function orderNotification($count, $branchId, $adminRole)
    {
        $return = [];
        $order = new Order();
        //$adminRole == Administrator::OWNER ? null : 
        $order = $order->get(null, null, $branchId);
        $data = [];
        if (count($order) > $count) {
            for ($i = $count - 1; $i < count($order); $i++) {
                $nOrder = $order[$i];
                $nOrder = Model::unsetModelProperties($nOrder->properties(true));
                $data[] = stripslashes(stripslashes(stripslashes(html_entity_decode(htmlspecialchars_decode((json_encode($nOrder)))))));
            }
        }
        $return['count'] = count($order);
        $return[Model::RESULT] = (json_encode($data));
        return (json_encode($return));
    }

    private function updateDelivery($id)
    {
        $delivery = new Delivery();
        $delivery = $delivery->get(null, $id);
        if (!is_null($delivery)) {
            $delivery = $delivery->properties(true);
            $delivery  = Model::unsetModelProperties($delivery);
            return stripslashes(html_entity_decode(htmlspecialchars_decode(json_encode($delivery))));
        }
    }

    private function deleteOrder($data)
    {
        $order = new Order();
        $order->setId($data[0]);
        $order->setUserDetails($data[1]);
        return $order->hide();
    }


    private function addRatings($data, $rating, $comment)
    {
        $ratings = new Ratings();
        $ratings->setProductId($data[0]);
        $ratings->setOrderId($data[1]);
        $ratings->setUserId($data[2]);
        $ratings->setRating($rating);
        $ratings->setComment($comment);
        $ratings->setTime(time());
        return $ratings->rate();
    }

    private function addFavorite($data)
    {
        $user = new User();
        $user->setId($data[0]);
        $user->setEmail($data[1]);
        $user = $user->get();
        if (!is_null($user)) {
            $favorite = new Favourite();
            $favorite->setUserId($data[0]);
            $favorite->setProductId($data[2]);
            $favorite->setTimeCreated(time());
            return $favorite->add();
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    private function removeFavorite($data)
    {
        $user = new User();
        $user->setId($data[0]);
        $user->setEmail($data[1]);
        $user = $user->get();
        if (!is_null($user)) {
            $favorite = new Favourite();
            $favorite->setUserId($data[0]);
            $favorite->setProductId($data[2]);
            $favorite->setTimeCreated(time());
            return $favorite->delete();
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    private function  updateTimeDelivery($data, $time)
    {
        $admin = new Administrator();
        $admin->setUsername($data[1]);
        $admin->setId($data[0]);
        $admin = $admin->get();
        if (!is_null($admin)) {
            if (intval($admin->getRole()) == 1) {
                $settings = new Setting();
                $settings->setDeliveryTime($time);
                return  $settings->update();
            } else  if (intval($admin->getRole()) == 2) {
                $branch = new Branch();
                $branch = $branch->get($admin);
                if (isset($branch[0])) {
                    $branch = $branch[0];
                    $branch->setDeliveryTime($time);
                    return $branch->update();
                }
            } else  return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    private function updateStaffLevel($data, $status)
    {
        $admin = new Administrator();
        $admin->setUsername($data[1]);
        $admin->setId($data[0]);
        $admin = $admin->get();
        if (!is_null($admin)) {
            if (intval($admin->getRole()) == 1) {
                $admin = new Administrator();
                return $admin->updateLevel($data[2], $status);
            } else
                return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    private function updateBranchStatus($data, $status)
    {
        $admin = new Administrator();
        $admin->setUsername($data[1]);
        $admin->setId($data[0]);
        $admin = $admin->get();
        if (!is_null($admin)) {
            if (intval($admin->getRole()) == 1) {
                $branch = new Branch();
                return $branch->updateStatus($data[2], $status);
            } else
                return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    private function updateProductStatus($data, $status)
    {
        $admin = new Administrator();
        $admin->setUsername($data[1]);
        $admin->setId($data[0]);
        $admin = $admin->get();
        if (!is_null($admin)) {
            if (intval($admin->getRole()) == 1 || intval($admin->getRole()) == 2) {
                $product = new Product();
                return $product->updateStatus($data[2], $status);
            } else
                return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    private function updateOrderStatus($data, $status)
    {
        $admin = new Administrator();
        $admin->setUsername($data[1]);
        $admin->setId($data[0]);
        $admin = $admin->get();
        if (!is_null($admin)) {
            $order = new Order();
            // LOCATION
            return $order->updateStatus($data[2], $status, $admin);
        } else
            return json_encode(array(Model::ERROR => Error::Unauthorised, Model::RESULT => false));
    }

    public function getCartItems($uId)
    {
        $return = array();
        $cartItem = new CartItem();
        $cart = [];
        foreach ($cartItem->get($uId) as $item) {
            $item->setProductOptions(fromDbJson($item->getProductOptions()));
            $item = $item->properties(true);
            unset($item['table']);
            unset($item['dataBase']);
            unset($item['tableName']);
            unset($item['dbName']);
            unset($item['file']);
            $item['datid'] = Encoding::encode(json_encode(array($item['id'], $uId)));
            $cart[] = $item;
        }
        $return[Model::DATA] = json_encode($cart);
        $return[Model::RESULT] = true;
        return json_encode($return);
    }

    private function updateCartItem($data)
    {
        $cartId = json_decode(Encoding::decode($data['id']))[0];
        $userId = json_decode(Encoding::decode($data['id']))[1];
        $val = $data['val'];
        $cartItem = new CartItem();
        $cartItem->setId($cartId);
        $cartItem->setUserId($userId);
        $cartItem->setQuantity($val);
        return $cartItem->update();
    }

    private function deleteCartItem($data)
    {
        $cartId = $data[0];
        $userId = $data[1];
        $cartItem = new CartItem();
        $cartItem->setId($cartId);
        $cartItem->setUserId($userId);
        return  $cartItem->delete();
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

    private function addToCart($data)
    {
        $data = (json_decode($data));
        $cart = new CartItem();
        $cart->setProductId($data->pId->id);
        $cart->setProductDetails($data->pId->name);
        $cart->setProductOptions($data->options);
        $cart->setUserId($data->sId);
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
