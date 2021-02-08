<?php

namespace Demae\Auth\Models\Shop;

use AddressColumn;
use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Res\Email;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Error;
use ReflectionClass;
use ReflectionProperty;

class Address extends Model
{
    private $id;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $email;
    private $zip;
    private $city;
    private $state;
    private $building;
    private $street;
    private $address;
    private $userId;
    private $timeCreated;
    private $log;


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
        $this->tableName = Credential::ADDRESSES_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function validate($info = false)
    {
        $error = null;
        if (isEmpty($this->getFirstName())) {
            $error = Error::NullFirstName;
        } 
        else if (!validatePhone($this->getPhoneNumber())) {
            $error = Error::NullPhone;
        } else if (!validateEmail($this->getEmail())) {
            $error = Error::InvalidEmail;
        } else if ($info == false) {
            if (isEmpty($this->getZip()) || strlen($this->getZip()) < 7) {
                $error = Error::NullZip;
            } else if (isEmpty($this->getCity()) ||  isEmpty($this->getAddress())) {
                $error = Error::NullAddress;
            } else if (isEmpty($this->getStreet())) {
                $error = Error::NullStreet;
            }
        }
        // else if (is_null($this->getBuilding() || $this->getBuilding() == "")) {
        //     $error = Error::NullBuilding;
        // }
        return json_encode(array(parent::ERROR => $error));
    }


    public function sendNotificationMail()
    {
        $mail = new Email();
        // // $mail->setTo($this->getEmail(), $this->getName());
        // //Generate Subject for customer and leave for admin
        // $mail->setSubject("Demae System - お問い合わせ");
        // $message['en'] = "Thank you for your contacting us. We will get back to you shortly. This is an autoreply to indicate we got your message, so you don't have to reply.";
        // $message['jp'] = "お問い合わせいただきありがとうございます。間もなくご連絡いたします。これは、メッセージを受け取ったことを示す自動返信なので、返信する必要はありません。";
        // $body = file_get_contents('app/Views/email/contact.php');
        // // $body = str_replace("{name}",  $this->getName() . '様', $body);
        // $body = str_replace("{message['en']}", $message["en"], $body);
        // $body = str_replace("{message['jp']}", $message["jp"], $body);
        // $mail->setBody($message['en'] . "\r\n \r\n" . $message['jp']);
        // $mail->setHtml($body);
        // // $mail->sendWithGoogleSTMP(); //sendWithHostSTMP();
        // $mail->sendWithHostSTMP();
    }



    public function get($id = null)
    {
        $cards = [];
        $obj = $this->object(false);
        if ($id == null) {
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AddressColumn::USERID => $obj[AddressColumn::USERID],
                )
            );
        } else {
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AddressColumn::USERID => $obj[AddressColumn::USERID],
                    AddressColumn::ID => $id,
                ),
                array("AND")
            );
        }
        if (count($query) > 0) {
            foreach ($query as $card) {
                $cards[] =  $this->setData($card);
            }
        }
        return $cards;
    }

    public function save()
    {
        $return = array();
        $validate = json_decode($this->validate())->{parent::ERROR};
        if (is_null($validate)) {
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AddressColumn::USERID => $obj[AddressColumn::USERID],
                    AddressColumn::ADDRESS => $obj[AddressColumn::ADDRESS],
                    AddressColumn::BUILDING => $obj[AddressColumn::BUILDING],
                    AddressColumn::STREET => $obj[AddressColumn::STREET],
                ),
                array("AND", "AND", "AND")
            )[0];
            $req = (array) $query;
            if (count($req) < 1) {
                $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
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

    public function delete()
    {
        $return = array();
        $obj = $this->object(false);
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                AddressColumn::ID => $obj[AddressColumn::ID],
                AddressColumn::USERID => $obj[AddressColumn::USERID],
            ),
            array("AND")
        );
        if (count($query) > 0) {
            $stmt = $this->table->remove(
                array(
                    AddressColumn::ID => $obj[AddressColumn::ID],
                    AddressColumn::USERID => $obj[AddressColumn::USERID],
                ),
                array("AND")
            );
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        } else {
            $return[parent::RESULT] = false;
        }
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
        if ($data == null) return new Address();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Address();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            if ($encKey == AddressColumn::LOG) {
                $obj->{$encKey} = Encoding::decode($data->{$encKey}, self::VALUE_ENCODE_ITERTATION);
            } else {
                $obj->{$encKey} =  ($data->{$encKey});
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
                if ($key == AddressColumn::LOG) {
                    $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION) : $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
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
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set the value of zip
     *
     * @return  self
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */
    public function setState($state)
    {
        $this->state = $state;

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

    /**
     * Get the value of building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set the value of building
     *
     * @return  self
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get the value of street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of street
     *
     * @return  self
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }
}
