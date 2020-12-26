<?php

namespace Demae\Auth\Models\Shop\Order;

use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use OrderColumn;
use ReflectionClass;
use ReflectionProperty;

class Order extends Model
{
    private $id;
    private $displayId;
    private $orderType; //home, scheduled, reservation
    private $scheduled;
    private $cart; //array of cartItem
    private $amount;
    private $userDetails;
    private $paymentDetails;
    private $visibility;
    private $status;
    private $deliveryDetails;
    private $timeCreated;
    private $log;
    private $tax;


    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::ORDERS_TBL;
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

    public function hide()
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
        if ($data == null) return new Order();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Order();
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
                // if ($key == OrderColumn::PASSWORD) { 
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
     * Get the value of displayId
     */
    public function getDisplayId()
    {
        return $this->displayId;
    }

    /**
     * Set the value of displayId
     *
     * @return  self
     */
    public function setDisplayId($displayId)
    {
        $this->displayId = $displayId;

        return $this;
    }

    /**
     * Get the value of orderType
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * Set the value of orderType
     *
     * @return  self
     */
    public function setOrderType($orderType)
    {
        $this->orderType = $orderType;

        return $this;
    }

    /**
     * Get the value of scheduled
     */
    public function getScheduled()
    {
        return $this->scheduled;
    }

    /**
     * Set the value of scheduled
     *
     * @return  self
     */
    public function setScheduled($scheduled)
    {
        $this->scheduled = $scheduled;

        return $this;
    }

    /**
     * Get the value of cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set the value of cart
     *
     * @return  self
     */
    public function setCart($cart)
    {
        $this->cart = $cart;

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
     * Get the value of userDetails
     */
    public function getUserDetails()
    {
        return $this->userDetails;
    }

    /**
     * Set the value of userDetails
     *
     * @return  self
     */
    public function setUserDetails($userDetails)
    {
        $this->userDetails = $userDetails;

        return $this;
    }

    /**
     * Get the value of paymentDetails
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * Set the value of paymentDetails
     *
     * @return  self
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;

        return $this;
    }

    /**
     * Get the value of visibility
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the value of visibility
     *
     * @return  self
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

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
     * Get the value of deliveryDetails
     */
    public function getDeliveryDetails()
    {
        return $this->deliveryDetails;
    }

    /**
     * Set the value of deliveryDetails
     *
     * @return  self
     */
    public function setDeliveryDetails($deliveryDetails)
    {
        $this->deliveryDetails = $deliveryDetails;

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
