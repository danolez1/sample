<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Security\Encoding;
use DeliveryColumn;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Order;
use OrderColumn;
use ReflectionClass;
use ReflectionProperty;

class DeliveryStatus
{
    public $time, $action;
}

class Delivery extends Model
{

    private $id;
    private $orderId;
    private $status;
    private $courierId;
    private $location;
    private $from;
    private $to;
    private $time;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = "", $orderId = "")
    {

        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                DeliveryColumn::ID => $id, DeliveryColumn::ORDERID => $orderId
            ),
            ["OR"]
        );
        if (count($query) > 0)
            return $this->setData($query[0]);
        else return null;
    }

    public function validate()
    {
        $error = null;
        $order = new Order();
        $order = $order->get($this->orderId);
        $this->to = $order->getAddress();
        $branch = new Branch();
        $branch = $branch->get(null, $order->getBranch());
        $branch = count($branch) > 0 ? $branch[0] : null;
        if ($branch != null) {
            $this->setFrom($branch->getLocation());
            $this->setLocation($branch->getLocation()); //
        }
        if (isEmpty(fromDbJson($this->to))) {
            $error = Error::InvalidOrder;
        } else if (isEmpty($this->courierId)) {
            $error = Error::InvalidDetails;
        } else if (isEmpty($this->from)) {
            $error = Error::InvalidDetails;
        } else if (isEmpty($this->location)) {
            $error = Error::InvalidDetails;
        } else if (isEmpty($this->status)) {
            $error = Error::InvalidDetails;
        }
        return json_encode(array(parent::ERROR => $error));
    }

    public function start()
    {
        $return = array();
        $error = json_decode($this->validate())->{parent::ERROR};
        $return[Model::ERROR] = $error;
        $return[parent::RESULT] = false;
        if (is_null($error)) {
            $id = $this->table->getLastSN() + 1;
            $this->setId(Encoding::encode(($id . rand(0, 99999)), self::VALUE_ENCODE_ITERTATION));
            $this->setTime(time());
            $obj = $this->object();
            $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        }
        return json_encode($return);
    }

    public function showDeliveryInfo($id)
    {
        switch (intval($id)) {
            case OrderColumn::ORDER_DELIVERED:
                return array("Your order has been delivered", 'trn' => 'order-delivered');
            case OrderColumn::ORDER_RECEIVED:
                return array("Your order has been received", 'trn' => 'order-received');
            case OrderColumn::ORDER_SHIPPED:
                return array("Order has been shipped", 'trn' => 'order-shipped');
            case OrderColumn::ORDER_ONWAY:
                return array("Your order is on the way", 'trn' => 'order-onway');
            case OrderColumn::ORDER_READY:
                return array("Order is ready", 'trn' => 'order-ready');
        }
    }

    public function update()
    {
        $return = array();
        $error = json_decode($this->validate())->{parent::ERROR};
        $return[Model::ERROR] = $error;
        $return[parent::RESULT] = false;

        if (is_null($error)) {
            if (isEmpty($this->get(null, $this->orderId)))
                $this->start();
            $obj = $this->object(false);
            $stmt = $this->table->update(
                array(DeliveryColumn::STATUS, DeliveryColumn::COURIERID, DeliveryColumn::LOCATION),
                array($obj[DeliveryColumn::STATUS], $obj[DeliveryColumn::COURIERID], $obj[DeliveryColumn::LOCATION]),
                array(DeliveryColumn::ORDERID => $obj[DeliveryColumn::ORDERID])
            );
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        }
        return json_encode($return);
    }


    protected function setTableName()
    {
        $this->tableName = Credential::DELIVERY_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
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
        if ($data == null) return new Delivery();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Delivery();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            //$encKey = Encoding::encode($key, self::KEY_ENCODE_ITERTATION);
            //  $obj->{$key} = $data->{$encKey};
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
                // if ($key == DeliveryColumn::PASSWORD) { 
                //     // $assoc ? $temp[$key]  = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION): $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
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

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of courierId
     */
    public function getCourierId()
    {
        return $this->courierId;
    }

    /**
     * Set the value of courierId
     *
     * @return  self
     */
    public function setCourierId($courierId)
    {
        $this->courierId = $courierId;

        return $this;
    }

    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of from
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set the value of from
     *
     * @return  self
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get the value of to
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set the value of to
     *
     * @return  self
     */
    public function setTo($to)
    {
        $this->to = $to;

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
}
