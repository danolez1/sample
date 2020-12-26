<?php

namespace Demae\Auth\Models\Shop\Favourite;

use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use FavoriteColumn;
use ReflectionClass;
use ReflectionProperty;

class Favourite extends Model
{
    private $id;
    private $userId;
    private $productId;
    private $timeCreated;
    private $log;

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
        // $query = (array) $this->table->get(
        //     null,
        //     Condition::WHERE,
        //     array(
        //         ProductColumn::ID => $id,
        //     )
        // );
        // return $this->setData($query);
    }

    public function add()
    {
        // $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
        //         $obj = $this->object();
        //         $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
        //         $return[parent::RESULT] = (bool) $stmt->affected_rows;

    }

    public function delete()
    {
        // $stmt = $this->table->remove(
        //     array(
        //         ProductColumn::ID => $obj[ProductColumn::ID],
        //     )
        // );
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
                // if ($key == FavoriteColumn::PASSWORD) { 
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

    /**
     * Get the value of log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set the value of log
     *
     * @return  self
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }
}
