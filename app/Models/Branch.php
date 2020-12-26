<?php

namespace Demae\Auth\Models\Shop\Branch;

use BranchColumn;
use danolez\lib\DB\Condition\Condition;
use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use danolez\lib\Security\Encryption\Encryption;
use Demae\Auth\Models\Error\Error;
use ReflectionClass;
use ReflectionProperty;

class Branch extends Model
{
    private $id;
    private $name;
    private $location;
    private $staffNo;
    private $status; //1=open, 2=closed
    private $timeCreated;
    private $log;
    private $admin;
    private $minOrder;
    private $averageDeliveryTime;
    private $operationTime;
    private $shippingFee;
    private $deliveryTime;
    private $deliveryTimeRange;
    private $deliveryAreas;
    private $deliveryDistance;
    private $address;
    protected $details;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct($userId = null, $id = null)
    {
        if (!is_null($userId)) {
            $this->setAdmin($userId);
        }
        if ($id != null) {
            $this->setId($id);
        }
        parent::__construct();
    }

    protected function setTableName()
    {
        $this->tableName = Credential::BRANCHES_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function validate()
    {
        $error = null;
        if (is_null($this->getName()) || $this->getName() == "") {
            $error = Error::NullBranchName;
        } else if (is_null($this->getLocation()) || $this->getLocation() == "") {
            $error = Error::NullLocation;
        }
        return json_encode(array(parent::ERROR => $error));
    }

    public function add()
    {
        $return = array();
        $validate = json_decode($this->validate())->{parent::ERROR};
        if (is_null($validate)) {
            $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
            $obj = $this->object();
            $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
            if ($return[parent::RESULT]) {
                $this->sendNotificationMail();
            }
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function sendNotificationMail()
    {
        # code...
    }

    public function getStatusName($status = null)
    {
        switch ($status ?? intval($this->status)) {
            case 1:
                return array("Opened", "trn" => "opened", "color" => "#28A745", "other" => (2));
                break;
            case 2:
                return array("Closed", "trn" => "closed", "color" => "#000000", "other" => (1));
                break;
        }
    }

    public function delete()
    {
        $return = array();
        $obj = $this->object(false);
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                BranchColumn::ID => $obj[BranchColumn::ID],
                BranchColumn::ADMIN => $obj[BranchColumn::ADMIN],
            ),
            array("AND")
        );
        if (count($query) > 0) {
            $stmt = $this->table->remove(
                array(
                    BranchColumn::ID => $obj[BranchColumn::ID],
                    BranchColumn::ADMIN => $obj[BranchColumn::ADMIN],
                ),
                array("AND")
            );
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        } else {
            $return[parent::RESULT] = false;
        }
        return json_encode($return);
    }

    public function update()
    {
        $obj = $this->object();
        $stmt = $this->table->update($obj[parent::PROPERTIES], $obj[parent::VALUES], array(BranchColumn::ID => $this->getId()));
        if ((bool) $stmt->affected_rows) {
            $this->sendNotificationMail();
        }
        return (bool) $stmt->affected_rows;
    }


    public function get($admin = null, $id = null)
    {
        $branches = [];
        if (is_null($admin) && is_null($id)) {
            $query = (array) $this->table->get();
        } else {
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                $id == null ? array(
                    BranchColumn::ADMIN => $admin->getId(),
                    BranchColumn::ID => $admin->getBranchId(),
                ) : array(BranchColumn::ID => $id),
                array("OR")
            );
        }
        if (count($query) > 0) {
            foreach ($query as $branch) {
                $branches[] = $this->setData($branch);
            }
        }
        return $branches;
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
        if ($data == null) return new Branch();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Branch();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            if ($encKey == BranchColumn::LOG) {
                $obj->{$encKey} = Encoding::decode($data->{$encKey}, self::VALUE_ENCODE_ITERTATION);
            } else {
                $obj->{$encKey} = $data->{$encKey};
            }
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
                if ($key == BranchColumn::LOG) {
                    $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION)
                        : $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
                } else {
                    $assoc ? $temp[$key]  = ($value) : $temp[] = ($value);
                }
            }
            return $temp;
        } else {
            return Credential::encrypt($data); //,$key
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function  setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function  setName($name)
    {
        $this->name = $name;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function  setLocation($location)
    {
        $this->location = $location;
    }

    public function getStaffNo()
    {
        return $this->staffNo;
    }

    public function  setStaffNo($staffNo)
    {
        $this->staffNo = $staffNo;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function  setStatus($status)
    {
        $this->status = $status;
    }

    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    public function  setTimeCreated($timeCreated)
    {
        $this->timeCreated = $timeCreated;
    }

    public function getLog()
    {
        return $this->log;
    }

    public function  setLog($log)
    {
        $this->log = $log;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function  setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function getMinOrder()
    {
        return $this->minOrder;
    }

    public function  setMinOrder($minOrder)
    {
        $this->minOrder = $minOrder;
    }

    public function getAverageDeliveryTime()
    {
        return $this->averageDeliveryTime;
    }

    public function  setAverageDeliveryTime($averageDeliveryTime)
    {
        $this->averageDeliveryTime = $averageDeliveryTime;
    }

    /**
     * Get the value of operationTime
     */
    public function getOperationTime()
    {
        return $this->operationTime;
    }

    /**
     * Set the value of operationTime
     *
     * @return  self
     */
    public function setOperationTime($operationTime)
    {
        $this->operationTime = $operationTime;

        return $this;
    }

    /**
     * Get the value of shippingFee
     */
    public function getShippingFee()
    {
        return $this->shippingFee;
    }

    /**
     * Set the value of shippingFee
     *
     * @return  self
     */
    public function setShippingFee($shippingFee)
    {
        $this->shippingFee = $shippingFee;

        return $this;
    }

    /**
     * Get the value of deliveryTime
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * Set the value of deliveryTime
     *
     * @return  self
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    /**
     * Get the value of deliveryTimeRange
     */
    public function getDeliveryTimeRange()
    {
        return $this->deliveryTimeRange;
    }

    /**
     * Set the value of deliveryTimeRange
     *
     * @return  self
     */
    public function setDeliveryTimeRange($deliveryTimeRange)
    {
        $this->deliveryTimeRange = $deliveryTimeRange;

        return $this;
    }

    /**
     * Get the value of deliveryAreas
     */
    public function getDeliveryAreas()
    {
        return $this->deliveryAreas;
    }

    /**
     * Set the value of deliveryAreas
     *
     * @return  self
     */
    public function setDeliveryAreas($deliveryAreas)
    {
        $this->deliveryAreas = $deliveryAreas;

        return $this;
    }

    /**
     * Get the value of deliveryDistance
     */
    public function getDeliveryDistance()
    {
        return $this->deliveryDistance;
    }

    /**
     * Set the value of deliveryDistance
     *
     * @return  self
     */
    public function setDeliveryDistance($deliveryDistance)
    {
        $this->deliveryDistance = $deliveryDistance;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of details
     */
    public function getDetails()
    {
        $this->details = array('shipping-fee' => $this->shippingFee, 'min-order' => $this->minOrder, 'delivery-time' => $this->deliveryTime, 'time-range' => $this->deliveryTimeRange, 'address' => $this->address, 'delivery-area' => $this->deliveryAreas, 'delivery-distance' => $this->deliveryDistance,);
        return $this->details;
    }
}
