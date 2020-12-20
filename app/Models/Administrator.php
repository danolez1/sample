<?php

namespace Demae\Auth\Models\Shop\Administrator;

use AdministratorColumn;
use danolez\lib\DB\Condition\Condition;
use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use danolez\lib\Security\Encryption\Encryption;
use Demae\Auth\Models\Error\Error;
use ReflectionClass;
use ReflectionProperty;


class Administrator extends Model
{
    private $id;
    private $branchId;
    private $email;
    private $phoneNumber;
    private $dateJoined;
    private $addedBy;
    private $username;
    private $password;
    private $name;
    private $info;
    private $role;
    private $log;


    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;
    const REGISTRATION = 0;
    const AUTHENTICATION = 1;
    const DEFAULT_BRANCH = "a0d83e3f43288e43c52a9b1e21eeeeeeee40ee40";

    const OWNER = 1;
    const TENCHO  = 2;
    const MANAGER = 3;
    const REJI = 4;
    const DRIVER = 5;
    const STAFF = 6;

    public function __construct($adminId = null, $id = null)
    {
        parent::__construct();
        if (!is_null($adminId)) {
            $this->setAddedBy($adminId);
        }
        if ($id != null) {
            $this->setId($id);
        }
    }

    protected function setTableName()
    {
        $this->tableName = Credential::ADMINISTRATORS_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function sendRegistrationMail()
    {
    }

    public function update()
    {
        # code...
    }

    public function validate($type)
    {
        $error = null;
        if ($type == self::REGISTRATION) {
            if (is_null($this->getName()) || $this->getName() == "") {
                $error = Error::NullName;
            } else if (!validateEmail($this->getEmail())) {
                $error = Error::InvalidEmail;
            } else if (is_null($this->getRole()) || $this->getRole() == "") {
                $error = Error::InvalidRole;
            } else if (is_null($this->branchId) || $this->branchId == "") {
                $error = Error::InvalidBranch;
            } else if (is_null($this->addedBy) || $this->addedBy == "") {
                $error = Error::InvalidMaster;
            }
        } else if ($type == self::AUTHENTICATION) {
            if ((is_null($this->username) || $this->username == "")) {
                $error = Error::InvalidEmail;
            } else if (is_null($this->getPassword()) || $this->getPassword() == "" ||  strlen($this->password) < 4) {
                $error = Error::InvalidPassword;
            }
        }
        return json_encode(array(parent::ERROR => $error));
    }

    public function authenticate()
    {
        $return = array();
        $validate = json_decode($this->validate(self::AUTHENTICATION))->{parent::ERROR};
        if (is_null($validate)) {
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AdministratorColumn::EMAIL => $obj[AdministratorColumn::EMAIL],
                    AdministratorColumn::USERNAME => $obj[AdministratorColumn::USERNAME],
                ),
                array("OR")
            )[0];
            $req = (array) $query;
            $auth = isset($req[AdministratorColumn::PASSWORD]) ?
                Encryption::verify($req[AdministratorColumn::PASSWORD], $this->getPassword()) : false;
            if (!$auth) {
                $validate = Error::WrongDetails;
            } else {
                $return[parent::RESULT] = $auth;
                $return[parent::DATA] = $req;
            }
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function register()
    {
        $return = array();
        $validate = json_decode($this->validate(self::REGISTRATION))->{parent::ERROR};
        if (is_null($validate)) {
            $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
            $this->setUserName(explode('@', $this->email)[0]);
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AdministratorColumn::EMAIL => $obj[AdministratorColumn::EMAIL],
                    AdministratorColumn::USERNAME => $obj[AdministratorColumn::USERNAME],
                ),
                array("OR")
            );
            $req = (array) $query;
            if (count($req) < 1) {
                $this->setId(Encoding::encode(($this->table->getLastSN() + 1), self::VALUE_ENCODE_ITERTATION));
                $password = substr(Encoding::encode($this->username), 0, rand(6, 8));
                $this->setPassword($password);
                $this->setDateJoined(time());
                $obj = $this->object();
                $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
                if ($return[parent::RESULT]) {
                    $this->sendRegistrationMail();
                    echo $password;
                }
            } else {
                $validate =  (Error::AdministratorExist);
            }
        }

        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function get()
    {
        if ((!is_null($this->username) && $this->username != "") && (!is_null($this->id) && $this->id != "")) {
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AdministratorColumn::USERNAME => $obj[AdministratorColumn::USERNAME],
                    AdministratorColumn::ID => $obj[AdministratorColumn::ID],
                ),
                array("AND")
            )[0];
            return $this->setData($query);
        } else return null;
    }

    public function getStaffs(Administrator $admin): array
    {
        $staffs = [];
        $query = (array) $this->table->get();
        if (count($query) > 0) {
            foreach ($query as $staff) {
                $staff = $this->setData($staff);
                if ($admin->getId() != $staff->getId()) {
                    if ($admin->getRole() == 2 && $staff->getBranchId() == $admin->getBranchId()) {
                        $staffs[] = $staff;
                    } else {
                        $staffs[] = $staff;
                    }
                }
            }
        }
        return $staffs;
    }

    public function delete()
    {
        $return = array();
        $obj = $this->object(false);
        $query = (array) $this->table->get(
            null,
            Condition::WHERE,
            array(
                AdministratorColumn::ADDEDBY => $obj[AdministratorColumn::ADDEDBY],
                AdministratorColumn::ID => $obj[AdministratorColumn::ID],
            ),
            array("AND")
        );
        if (count($query) > 0) {
            $stmt = $this->table->remove(
                array(
                    AdministratorColumn::ADDEDBY => $obj[AdministratorColumn::ADDEDBY],
                    AdministratorColumn::ID => $obj[AdministratorColumn::ID],
                ),
                array("AND")
            );
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        } else {
            $return[parent::RESULT] = false;
        }
        return json_encode($return);
    }

    public function getRoleName()
    {
        switch (intval($this->role)) {
            case 1:
                return array("CEO", "trn" => "ceo");
                break;
            case 2:
                return array("Manager", "trn" => "manager");
                break;
            case 3:
                return array("Cashier", "trn" => "cashier");
                break;
            case 4:
                return array("Driver", "trn" => "driver");
                break;
            case 5:
                return array("Staff", "trn" => "staff");
                break;
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
        if ($data == null) return new Administrator();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Administrator();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            if ($encKey == AdministratorColumn::LOG) {
                $obj->{$encKey} = Encoding::decode($data->{$encKey}, self::VALUE_ENCODE_ITERTATION);
            }
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
                if ($key == AdministratorColumn::PASSWORD) {
                    $assoc ? $temp[$key] =  Encryption::hash($value) : $temp[] =  Encryption::hash($value);
                } else if ($key == AdministratorColumn::LOG) {
                    $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION)
                        : $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
                } else {
                    $assoc ? $temp[$key] = ($value) : $temp[] = ($value);
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
        $this->email = $this->purify($email);

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
        $this->phoneNumber = $this->purify($phoneNumber);

        return $this;
    }

    /**
     * Get the value of dateJoined
     */
    public function getDateJoined()
    {
        return $this->dateJoined;
    }

    /**
     * Set the value of dateJoined
     *
     * @return  self
     */
    public function setDateJoined($dateJoined)
    {
        $this->dateJoined = $dateJoined;

        return $this;
    }

    /**
     * Get the value of addedBy
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * Set the value of addedBy
     *
     * @return  self
     */
    public function setAddedBy($addedBy)
    {
        $this->addedBy = $this->purify($addedBy);

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $this->purify($username);

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $this->purify($password);

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
        $this->name = $this->purify($name);

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

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
     * Get the value of info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set the value of info
     *
     * @return  self
     */
    public function setInfo($info)
    {
        $this->info = $this->purify($info);

        return $this;
    }
}
