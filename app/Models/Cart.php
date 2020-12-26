<?php

namespace Demae\Auth\Models\Shop\Cart;

use CartColumn;
use danolez\lib\DB\Condition\Condition;
use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Error\Error;
use Demae\Auth\Models\Shop\Product\Product;
use Demae\Auth\Models\Shop\User\User;
use Demae\Controller\ShopController\HomeController;
use ReflectionClass;
use ReflectionProperty;
//getall
class CartItem extends Model
{
    private $id;
    private $amount;
    private $userId; //cookieId  
    private $quantity;
    private $productId;
    private $productOptions;
    private $additionalNote;
    private $timeCreated;
    private $productDetails;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::CARTS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function get($id)
    {
        $cart = [];
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                CartColumn::USERID => $id,
            )
        );
        foreach ($query as $item) {
            $cart[] = $this->setData($item);
        }

        return $cart;
    }

    public function add()
    {
        $return = array();
        $verify = $this->verifyItem();
        if ($verify instanceof CartItem) {
            $obj = $this->object(false);
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    CartColumn::PRODUCTDETAILS => $obj[CartColumn::PRODUCTDETAILS],
                    CartColumn::AMOUNT => $obj[CartColumn::AMOUNT],
                    CartColumn::PRODUCTOPTIONS => $obj[CartColumn::PRODUCTOPTIONS],
                ),
                array('AND', 'AND')
            );
            if (count($query) > 0) {
                foreach ($query as $item) {
                    $item = $this->setData($item);
                    // $db = Encoding::encode(json_encode(fromDbJson($item->getProductOptions())));
                    // $added = Encoding::encode($this->getProductOptions());
                    // // if (($db == $added)) {
                    $quantity = $item->getQuantity() + 1;
                    $stmt = $this->table->update(array(CartColumn::QUANTITY), array($quantity), array(CartColumn::ID => $item->getId()));
                    $return[parent::RESULT] = (bool) $stmt->affected_rows;
                    // } 
                }
            } else {
                $return[parent::RESULT] = $this->save();
            }
        } else {
            $return[parent::ERROR] = Error::CouldNotAddToCart;
        }




        return json_encode($return);
    }

    public function verifyItem()
    {
        try {
            $product = new Product();
            $product = $product->get($this->getProductId());
            $basePrice = $product->getPrice();
            $options = [];
            for ($i = 0; $i < count($product->getProductOptions()); $i++) {
                for ($j = 0; $j < count($this->getProductOptions()); $j++) {
                    if ($product->getProductOptions()[$i]->name == $this->getProductOptions()[$j]->name) {
                        if (intval($this->getProductOptions()[$j]->value) > 0) {
                            $product->getProductOptions()[$i]->amount = $this->getProductOptions()[$j]->value;
                            $options[] = $product->getProductOptions()[$i];
                        }
                    }
                }
            }
            $optionPrice = 0;
            foreach ($options as $option) {
                $optionPrice += intval($option->amount) * intval($option->price);
            }
            $this->setProductOptions(json_encode($options));
            $this->setAmount($basePrice + $optionPrice);
            $guest = json_decode($this->getUserId());

            if (count($guest) == 2) { //user
                // $user = new User();
                // $user->setEmail($guest[0]);
                // $user->setId($guest[1]);
                // $user = $user->get();
                $this->setUserId($guest[1]);
            } else {
                $this->setUserId(Encoding::encode(json_encode($guest), HomeController::VALUE_ENCODE_ITERTATION));
            }
            $this->setTimeCreated(time());
            $this->setQuantity(1);
            $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
            return $this;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function save()
    {
        $obj = $this->object();
        $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
        return (bool) $stmt->affected_rows;
    }

    public function delete()
    {
        // $stmt = $this->table->remove(
        //     array(
        //         ProductColumn::ID => $obj[ProductColumn::ID],
        //     )
        // );
    }

    public function update()
    {
        // $obj = $this->object();
        // $stmt = $this->table->update($obj[parent::PROPERTIES], $obj[parent::VALUES], array(ProductColumn::ID => $this->getId()));
        // $return[parent::RESULT] = (bool) $stmt->affected_rows;

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
        if ($data == null) return new CartItem();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new CartItem();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            //$encKey = Encoding::encode($key, self::KEY_ENCODE_ITERTATION);
            //  $obj->{$key} = $data->{$encKey};
            $obj->{$encKey} =  ($data->{$encKey});
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
                // if ($key == CartColumn::PASSWORD) { 
                //     // $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION): $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
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
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     *
     * @return  self
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get the value of productOptions
     */
    public function getProductOptions()
    {
        return $this->productOptions;
    }

    /**
     * Set the value of productOptions
     *
     * @return  self
     */
    public function setProductOptions($productOptions)
    {
        $this->productOptions = $productOptions;

        return $this;
    }

    /**
     * Get the value of additionalNote
     */
    public function getAdditionalNote()
    {
        return $this->additionalNote;
    }

    /**
     * Set the value of additionalNote
     *
     * @return  self
     */
    public function setAdditionalNote($additionalNote)
    {
        $this->additionalNote = $additionalNote;

        return $this;
    }

    /**
     * Get the value of timeCreated
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * Set the value of timeCreated
     *
     * @return  self
     */
    public function setTimeCreated($timeCreated)
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    /**
     * Get the value of productDetails
     */
    public function getProductDetails()
    {
        return $this->productDetails;
    }

    /**
     * Set the value of productDetails
     *
     * @return  self
     */
    public function setProductDetails($productDetails)
    {
        $this->productDetails = $productDetails;

        return $this;
    }
}
