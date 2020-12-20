<?php

namespace Demae\Auth\Models\Shop\Product;

use danolez\lib\DB\Condition\Condition;
use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Error\Error;
use Demae\Auth\Models\Shop\Administrator\Administrator;
use ProductColumn;
use ReflectionClass;
use ReflectionProperty;

class ProductOption
{
    public $name;
    public $category;
    public $price;
    public $limit;
    public $amount;
    public $availability;
}

class Product extends Model
{

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;
    const TAX = .08;

    private $id;
    private $quantity;
    private $availability; //0-available,1-sold out
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
        switch ($this->availability) {
            case '1':
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
            $admin->setUsername($this->getAuthor()[0]);
            $admin->setId($this->getAuthor()[1]);
            $admin = $admin->get();
            // var_dump($admin);
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
        # code...
    }

    public function delete()
    {
        # code...
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
                $products[] = $this->setData($product);
            }
            return $products;
        }
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


            //  $obj->{$key} = $data->{$encKey};
            $obj->{$key} =  Credential::decrypt($data->{$encKey}); //,$key
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
}
