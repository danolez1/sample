<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Security\Encoding;
use FavoriteColumn;
use ReflectionClass;
use ReflectionProperty;

class Favourite extends Model
{
    private $id;
    private $userId;
    private $productId;
    private $timeCreated;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setTableName()
    {
        $this->tableName = Credential::FAVORITES_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function get()
    {
        $favorites = [];
        $obj = $this->object(false);
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                FavoriteColumn::USERID => $obj[FavoriteColumn::USERID],
            )
        );
        if (count($query) > 0) {
            foreach ($query as $favorite) {
                $favorites[] =  $this->setData($favorite);
            }
        }
        return $favorites;
    }

    public function add()
    {
        $return = array();
        $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
        $obj = $this->object();
        $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        return json_encode($return);
    }

    public function delete()
    {
        $return = array();
        $obj = $this->object(false);
        $stmt = $this->table->remove(
            array(
                FavoriteColumn::USERID => $obj[FavoriteColumn::USERID],
                FavoriteColumn::PRODUCTID => $obj[FavoriteColumn::PRODUCTID]
            ),
            array("AND")
        );
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        return json_encode($return);
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
        $obj = new Favourite();
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
}
