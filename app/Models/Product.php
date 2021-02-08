<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Administrator;
use ProductColumn;
use Ratings;
use ReflectionClass;
use ReflectionProperty;

class ProductOption
{
    const SINGLE_ITEM = 'single';
    const MULTIPLE_ITEM = 'multiple';
    public $name;
    public $category;
    public $price;
    public $type;
    public $available;
    public $amount;

    public function __construct($object = null)
    {
        if ($object != null)
            foreach ($object as $property => $value) {
                $this->$property = $value;
            }
    }
}

class Product extends Model
{
    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 3;
    const TAX = .08;

    const AVAILABLE = 1;
    const SOLD_OUT = 2;
    public $tempAuthor;
    private $id;
    private $quantity;
    private $availability;
    private $ratings;
    private $price;
    private $name;
    private $description;
    private $images;
    private $displayImage;
    private $category;
    private $productOptions;
    private $timeCreated;
    private $author; //array(username,id);
    private $tax;
    private $branchId;
    protected $orderCount;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setTableName()
    {
        $this->tableName = Credential::PRODUCTS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function availabilityText()
    {
        if (intval($this->availability) != 1) {
            return '<span trn="sold-out">Sold Out</span>';
        }
    }

    public function validate()
    {
        $error = null;
        if (is_null($this->getName()) || $this->getName() == "") {
            $error = Error::NullProductName;
        } else if (is_null($this->getPrice()) || $this->getPrice() == "") {
            $error = Error::NullPrice;
        }
        return json_encode(array(parent::ERROR => $error));
    }



    public function create()
    {
        $return = array();
        $validate = json_decode($this->validate())->{parent::ERROR};
        if (is_null($validate)) {
            $admin = new Administrator();
            $admin->setUsername($this->tempAuthor[0]);
            $admin->setId($this->tempAuthor[1]);
            $admin = $admin->get();
            if ($admin->getRole() == '1' || $admin->getRole() == '2') {
                $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
                $obj = $this->object();
                $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
            } else {
                $validate = Error::Unauthorised;
            }
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function update()
    {
        $return = array();
        $validate = json_decode($this->validate())->{parent::ERROR};
        if (is_null($validate)) {
            $admin = new Administrator();
            $admin->setUsername($this->tempAuthor[0]);
            $admin->setId($this->tempAuthor[1]);
            $admin = $admin->get();
            if ($admin->getRole() == '1' || $admin->getRole() == '2') {
                $obj = $this->object();
                $stmt = $this->table->update($obj[parent::PROPERTIES], $obj[parent::VALUES], array(ProductColumn::ID => $this->getId()));
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
            } else {
                $validate = Error::Unauthorised;
            }
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function delete()
    {
        $return = array();
        $validate = '';
        $admin = new Administrator();
        $admin->setUsername($this->tempAuthor[0]);
        $admin->setId($this->tempAuthor[1]);
        $admin = $admin->get();
        if ($admin->getRole() == '1' || $admin->getRole() == '2') {
            $obj = $this->object(false);
            $stmt = $this->table->remove(
                array(
                    ProductColumn::ID => $obj[ProductColumn::ID],
                )
            );
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        } else {
            $validate = Error::Unauthorised;
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function get($id = null)
    {
        if ($id != null) {
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    ProductColumn::ID => $id,
                )
            )[0];
            return $this->setData($query);
        } else {
            $products = [];
            $query = (array) $this->table->get();
            foreach ($query as $product) {
                $product = $this->setData($product);
                $ratings = new Ratings();
                $ratings->setProductId($product->getId());
                $ratings  = $ratings->get($product->getId());
                $rate = 0;
                foreach ($ratings as $key => $rating) {
                    $rate = $rate + intval($rating->getRating());
                }
                if (count($ratings) > 0)
                    $product->setRatings($rate / count($ratings));
                $products[] = $product;
            }
            return $products;
        }
    }

    public function getStatusInfo()
    {
        $available = array('Available', 'color' => '#28A745', 'data' => ProductColumn::AVAILABLE, 'trn' => 'product-available');
        $unavailable = array('Unavailable', 'color' => '#EFF3F3', 'data' => ProductColumn::UNAVAILABLE, 'trn' => 'product-unavailable');

        switch ($this->availability) {
            case ProductColumn::AVAILABLE:
                return array($available, $unavailable);
            case ProductColumn::UNAVAILABLE:
                return array($unavailable, $available);
        }
    }


    public function updateStatus($id, $status)
    {
        $return = array();
        $stmt = $this->table->update(array(ProductColumn::AVAILABILITY), array($status), array(ProductColumn::ID => $id));
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        return json_encode($return);
    }


    public function getDetails()
    {
        $ppt = $this->object(false);
        unset($ppt['quantity']);
        unset($ppt['availability']);
        unset($ppt['images']);
        unset($ppt['timeCreated']);
        unset($ppt['author']);
        unset($ppt['tax']);
        unset($ppt['category']);
        unset($ppt['branchId']);
        $ppt['orderCount'] =  $this->orderCount;
        return json_encode($ppt);
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
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Product();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            //$encKey = Encoding::encode($key, self::KEY_ENCODE_ITERTATION);

            if ($encKey == ProductColumn::PRODUCTOPTIONS) {
                $options =  fromDbJson($data->{$encKey});
                $this->productOptions = array();
                if ($options != null && count($options) > 0) {
                    foreach ($options as $option) {
                        $obj->productOptions[] =  new ProductOption($option);
                    }
                }
            } else
                $obj->{$encKey} =  ($data->{$encKey}); //,$key
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

                // if ($key == ProductColumn::PASSWORD) { 
                //     // $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION)
                //: $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
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
     * Get the value of availability
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set the value of availability
     *
     * @return  self
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get the value of ratings
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Set the value of ratings
     *
     * @return  self
     */
    public function setRatings($ratings)
    {
        $this->ratings = $ratings;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @return  self
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get the value of displayImage
     */
    public function getDisplayImage()
    {
        return $this->displayImage;
    }

    /**
     * Set the value of displayImage
     *
     * @return  self
     */
    public function setDisplayImage($displayImage)
    {
        $this->displayImage = $displayImage;

        return $this;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */
    public function setCategory($category)
    {
        $this->category = $category;

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
     * Get the value of author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set the value of tax
     *
     * @return  self
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get the value of branchId
     */
    public function getBranchId()
    {
        return $this->branchId;
    }

    /**
     * Set the value of branchId
     *
     * @return  self
     */
    public function setBranchId($branchId)
    {
        $this->branchId = $branchId;

        return $this;
    }

    /**
     * Get the value of orderCount
     */
    public function getOrderCount()
    {
        return $this->orderCount;
    }

    /**
     * Set the value of orderCount
     *
     * @return  self
     */
    public function setOrderCount($orderCount)
    {
        $this->orderCount = $orderCount;

        return $this;
    }
}
