<?php

namespace danolez\lib\DB\Model;

use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Database\Database;

abstract class Model
{
    protected $table;
    protected $dataBase;
    protected $tableName;
    protected $dbName;
    const KEYS = "keys";
    const VALUES = "values";
    const DATA = "data";
    const PROPERTIES = "properties";
    const ERROR = "error";
    const RESULT = "result";
    const COMMENT = "comment";

    public function __construct()
    {
        $this->setDBName();
        $this->setTableName();
        $this->dataBase = new Database($this->dbName);
        $this->table =  $this->dataBase->Table($this->tableName);
        return $this;
    }

    public function unset($key)
    {
        unset($this->{$key});
    }

    abstract protected function setTableName();
    abstract protected function setDBName();
    abstract protected function object();
    abstract protected function properties();
    abstract protected function setData($data);
    abstract protected function encrypt($data);
    abstract protected function encode($data);

    /**
     * purify
     * 
     * @param  mixed $params
     * @return string
     */
    protected function purify(string $p = null)
    {
        $p = trim($p);
        $p = stripslashes($p);
        $p = stripcslashes($p);
        $p = strip_tags($p);
        $p = htmlentities($p);
        $p = $this->dataBase->DB()->real_escape_string($p);
        return $p;
    }
}

/**
 * 
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
        if ($data == null) return new Model();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Mode();
        foreach (array_values($properties) as $key) {
            //$encKey = $key->name;
            $encKey = Encoding::encode($key, self::KEY_ENCODE_ITERTATION);
            // Specific case decryption
            // if($encKey == AccountColumn::PASSWORD){            
            // }

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
                //$temp[$key->name] = $key->name;
                $temp[$key->name] = Encoding::encode($key->name, self::KEY_ENCODE_ITERTATION);
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
                 // if ($key == ModelColumn::PASSWORD) { 
                //     // $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION): $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
                // } else {
                $assoc ? $temp[$key]  = ($value): $temp[] = ($value);
                //  }
            }
            return $temp;
        } else {
            return Credential::encrypt($data); //,$key
        }
    }
 */
