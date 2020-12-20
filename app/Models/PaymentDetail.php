<?php

namespace Demae\Auth\Models\Shop\PaymentDetails;

use danolez\lib\DB\Condition\Condition;
use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use danolez\lib\Security\Encryption\Encryption;
use Demae\Auth\Models\Error\Error;
use PaymentDetailsColumn;
use ReflectionClass;
use ReflectionProperty;

class CreditCard
{
    public function __construct($object = null)
    {
        if ($object != null)
            foreach ($object as $property => $value) {
                if ($property == 'cardNumber') {
                    $this->$property = $this->mask($value);
                    $this->setNtNumber($value);
                } else {
                    $this->$property = $value;
                }
            }
    }
    public $cvv, $cardName, $cardNumber, $expiryDate, $cardType;
    private $ntNumber, $id;

    public function mask($string)
    {
        if (!$string) {
            return NULL;
        }
        $length = strlen($string);
        $visibleCount = (int) round($length / 4);
        $hiddenCount = $length - ($visibleCount * 2);
        return substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
    }

    public function setNtNumber($ntNumber)
    {
        $this->ntNumber = $ntNumber;

        return $this;
    }

    public function getNtNumber()
    {
        return $this->ntNumber;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}



class PaymentDetails extends Model
{
    private $id;
    private $userId;
    private $creditCard;
    private $timeCreated;
    private $log;
    public $cards;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct($userId = null, $id = null)
    {
        if (!is_null($userId)) {
            $this->setUserId($userId);
        }
        if ($id != null) {
            $this->setId($id);
        }
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::PAYMENT_METHODS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function validate()
    {
        $error = null;
        if (is_null($this->creditCard->cardName) || $this->creditCard->cardName == "") {
            $error = Error::NullName;
        } else if (get_card_brand($this->creditCard->cardNumber) == "") {
            $error = Error::InvalidCardNumber;
        } else if (is_null($this->creditCard->cvv) || $this->creditCard->cvv == "") {
            $error = Error::InvalidCVV;
        } else {
            $expiryDate = explode("/", $this->creditCard->expiryDate);
            if (count($expiryDate) == 2) {
                $month = $expiryDate[0];
                $year = $expiryDate[1];
                $currentMonth = date('m');
                $currentYear = date('Y');
                if (strlen($year) == 2) $year = 2000 + $year;
                if ($currentMonth == "" || $currentYear == "") {
                    $error =  Error::InvalidExpiryDate;
                } else if (($currentYear > $year) || ($currentYear == $year && $currentMonth > $month)) {
                    $error =  Error::ExpiredCard;
                }
            } else {
                $error =  Error::InvalidExpiryDate;
            }
        }

        return json_encode(array(parent::ERROR => $error));
    }

    public function sendNotificationMail()
    {
        # code...
    }

    public function delete()
    {
        $return = array();
        $obj = $this->object(false);
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                PaymentDetailsColumn::ID => $obj[PaymentDetailsColumn::ID],
                PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
            ),
            array("AND")
        );
        if (count($query) > 0) {
            $stmt = $this->table->remove(
                array(
                    PaymentDetailsColumn::ID => $obj[PaymentDetailsColumn::ID],
                    PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
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
        # code...
    }


    public function get()
    {
        $cards = [];
        $obj = $this->object(false);
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
            )
        );
        if (count($query) > 0) {
            foreach ($query as $card) {
                $d =  $this->setData($card);
                $card = new CreditCard($d->creditCard);
                $card->setId($d->id);
                $cards[] = $card;
            }
        }
        return $cards;
    }

    public function saveCard()
    {
        $return = array();
        $validate = json_decode($this->validate())->{parent::ERROR};
        if (is_null($validate)) {
            $this->generateId();
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
                    PaymentDetailsColumn::ID => $obj[PaymentDetailsColumn::ID],
                ),
                array("AND")
            )[0];
            $req = (array) $query;
            if (count($req) < 1) {
                $obj = $this->object();
                $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
                if ($return[parent::RESULT])
                    $this->sendNotificationMail();
            } else {
                $return[parent::RESULT] = true;
            }
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function generateId()
    {
        $this->setId(Encoding::encode($this->getCreditCard()->cardNumber, self::VALUE_ENCODE_ITERTATION));
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
        $obj = new PaymentDetails();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            if ($encKey == PaymentDetailsColumn::CREDITCARD) {
                $obj->{$encKey} =  json_decode(Credential::decrypt($data->{$encKey}));
            } else if ($encKey == PaymentDetailsColumn::LOG) {
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
                if ($key == PaymentDetailsColumn::CREDITCARD) {
                    $assoc ? $temp[$key] = Credential::encrypt(json_encode($value)) : $temp[] = Credential::encrypt(json_encode($value));
                } else if ($key == PaymentDetailsColumn::LOG) {
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
     * Get the value of creditCard
     */
    public function getCreditCard(): CreditCard
    {
        return $this->creditCard;
    }

    /**
     * Set the value of creditCard
     *
     * @return  self
     */
    public function setCreditCard(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;

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
