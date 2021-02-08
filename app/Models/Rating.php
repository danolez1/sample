<?php

use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Error;

class Ratings extends Model
{
    private $id;
    private $userId;
    private $productId;
    private $orderId;
    private $rating;
    private $comment;
    private $time;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::RATINGS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function rate()
    {
        $return = array();
        $rating =  $this->get($this->productId, $this->orderId, $this->userId)[0] ?? null;
        if ($rating == null) {
            $obj = $this->object();
            $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        } else {
            $return[parent::ERROR] = Error::AlreadyRated;
        }
        return json_encode($return);
    }

    public function delete()
    {
        # code...
    }

    public function get($productId = null, $orderId = null, $userId = null)
    {
        $ratings = [];
        if ($productId == null)
            $query = (array) $this->table->get();
        else {
            if ($orderId == null && $userId == null) {
                $query = (array) $this->table->get(
                    null,
                    Condition::WHERE,
                    array(RatingsColumn::PRODUCTID => $productId)
                );
            } else {
                $query = (array) $this->table->get(
                    null,
                    Condition::WHERE,
                    array(RatingsColumn::ORDERID => $orderId, RatingsColumn::USERID => $userId),
                    array('AND')
                );
            }
        }
        foreach ($query as $rating) {
            $rating = $this->setData($rating);
            if ($rating->getOrderId() == $orderId && $rating->getProductId() == $productId && $rating->getUserId() == $userId)
                $ratings[] = $rating;
        }
        return $ratings;
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
        if ($data == null) return new Ratings();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Ratings();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            $obj->{$encKey} =  ($data->{$encKey});
        }
        return $obj;
    }

    protected function object($upload = true) //: array
    {
        $return  = array();
        $reflect = new ReflectionClass($this);
        $object = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $return[parent::PROPERTIES] = $this->encode(array_values($object));
        $object = array();
        foreach ($return[parent::PROPERTIES] as $ppt => $enc) {
            $object[$enc] = $this->properties(true)[$ppt];
        }
        $return[parent::VALUES] = $this->encrypt($object);
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
                $assoc ? $temp[$key] = ($value) : $temp[] = ($value);
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
     * Get the value of rating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set the value of rating
     *
     * @return  self
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId
     *
     * @return  self
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }
}
