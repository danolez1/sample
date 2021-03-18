<?php

namespace Demae\Auth\Models\Shop;

use AdministratorColumn;
use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Res\Email;
use danolez\lib\Res\Mail;
use danolez\lib\Res\Server;
use danolez\lib\Security\Encoding;
use danolez\lib\Security\Encryption;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Setting;
use Demae\Controller\HomeController;
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
    const MANAGER = 2;
    const REJI = 3;
    const DRIVER = 4;
    const STAFF = 5;

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
            } else if (isEmpty($this->getPassword()) ||  strlen($this->password) < 4) {
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
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AdministratorColumn::EMAIL => $obj[AdministratorColumn::EMAIL],
                    AdministratorColumn::USERNAME => $obj[AdministratorColumn::USERNAME],
                ),
                array("OR")
            );
            $req = count($query) > 0 ?  $query[0] : [];
            $auth = isset($req->{AdministratorColumn::PASSWORD}) ?
                Encryption::verify($req->{AdministratorColumn::PASSWORD}, $this->getPassword()) : false;
            if (!$auth) {
                $validate = Error::WrongDetails;
            } else {
                $return[parent::RESULT] = $auth;
                $return[parent::DATA] = (array)$req;
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
                $password = $this->generatePassword(rand(6, 9));
                $this->setPassword($password);
                $this->setDateJoined(time());
                $obj = $this->object();
                $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
                if ($return[parent::RESULT]) {
                    $this->sendRegistrationMail($this->username, $password);
                    // echo $password;
                }
            } else {
                $validate =  (Error::AdministratorExist);
            }
        }

        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function generatePassword($length)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a st
    }

    public function sendResetMail($username, $password)
    {
        $mail = new Email();
        $mail->setTo($this->email, $this->name);
        $EN = $_COOKIE['lingo'] == 'en';
        $settings = Setting::getInstance();
        $name = $settings->getStoreName();
        $mail->setSubject($EN ? "【 $name 】- Notification" : "【 $name 】- お知らせ");
        $link = Server::get(Server::HTTP_HOST) . Server::get(Server::REQUEST_URI);
        $message['en'] = "You requested for a password change <br> Here is your new login details at $link.<br>Username: $username <br>Password: $password <br> Protect your login details as a personal information.";
        $message['jp'] = "$this->name さんは　パスワードの変更をリクエストしました。<br>　$name での新しいログインの詳細は次のとおりです。<br>ユーザー名： $username <br>パスワード：$password <br>ログイン情報を個人情報として保護します。";
        $body = file_get_contents('app/Views/email/contact.php');
        $body = str_replace("{name}", $EN ? "Dear  $this->name ," : $this->name . '様,', $body);
        $body = str_replace("{message['en']}", $message["en"], $body);
        $body = str_replace("{message['jp']}", $message["jp"], $body);
        $body = str_replace("{{SOCIALS}}", "", $body);
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.facebook.com/" target="_blank"><img alt="Facebook" height="32" src="images/facebook2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Facebook" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://twitter.com/" target="_blank"><img alt="Twitter" height="32" src="images/twitter2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Twitter" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="images/instagram2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Instagram" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.linkedin.com/" target="_blank"><img alt="LinkedIn" height="32" src="images/linkedin2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="LinkedIn" width="32" /></a></td>
        $settings = HomeController::getSettings();
        if (!$settings->getUseTitleAsLogo()) {
            $mail->setAttachment($settings->getMetaContent());
            $mail->setAttachmentName("logo-img");
        }
        $logo = '<img align="center" border="0" class="center autowidth" src="cid:logo-img" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 140px; display: block;"  width="140" />';
        $body = str_replace("{{LOGO}}", $settings->getUseTitleAsLogo() ? $settings->getLogo() : $logo, $body);
        $mail->setBody($message['en'] . "\r\n \r\n" . $message['jp']);
        $mail->setHtml($body);
        $mail->sendWithHostSTMP();
        $mail->setTo(Email::DEFAULT_FROM_EMAIL, Email::DEFAULT_FROM);
        $mail->sendWithHostSTMP();
    }


    public function sendRegistrationMail($username, $password)
    {
        $mail = new Email();
        $mail->setTo($this->email, $this->name);
        $EN = $_COOKIE['lingo'] == 'en';
        $name = Setting::getInstance()->getStoreName();
        $mail->setSubject($EN ? "【 $name 】- Notification" : "【 $name 】- お知らせ");
        $link = "";
        $message['en'] = "You have just been added as a staff to $name.<br> Here is your login details at $link.<br>Username: $username <br>Password: $password <br> Protect your login details as a personal information.";
        $message['jp'] = "$this->name さんは　$name にスタッフとして追加されました。<br>　$name でのログインの詳細は次のとおりです。<br>ユーザー名： $username <br>パスワード：$password <br>ログイン情報を個人情報として保護します。";
        $body = file_get_contents('app/Views/email/contact.php');
        $body = str_replace("{name}", $EN ? "Dear  $this->name ," : $this->name . '様,', $body);
        $body = str_replace("{message['en']}", $message["en"], $body);
        $body = str_replace("{message['jp']}", $message["jp"], $body);
        $body = str_replace("{{SOCIALS}}", "", $body);
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.facebook.com/" target="_blank"><img alt="Facebook" height="32" src="images/facebook2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Facebook" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://twitter.com/" target="_blank"><img alt="Twitter" height="32" src="images/twitter2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Twitter" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="images/instagram2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="Instagram" width="32" /></a></td>
        // // <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.linkedin.com/" target="_blank"><img alt="LinkedIn" height="32" src="images/linkedin2x.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;" title="LinkedIn" width="32" /></a></td>
        $settings = HomeController::getSettings();
        if (!$settings->getUseTitleAsLogo()) {
            $mail->setAttachment($settings->getMetaContent());
            $mail->setAttachmentName("logo-img");
        }
        $logo = '<img align="center" border="0" class="center autowidth" src="cid:logo-img" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 140px; display: block;"  width="140" />';
        $body = str_replace("{{LOGO}}", $settings->getUseTitleAsLogo() ? $settings->getLogo() : $logo, $body);
        $mail->setBody($message['en'] . "\r\n \r\n" . $message['jp']);
        $mail->setHtml($body);
        $mail->sendWithHostSTMP();
        $mail->setTo(Email::DEFAULT_FROM_EMAIL, Email::DEFAULT_FROM);
        $mail->sendWithHostSTMP();
    }

    public function get($branchId = null)
    {
        if (!isEmpty($this->username) || !isEmpty($this->id)) {
            $obj = $this->object(false);
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AdministratorColumn::USERNAME => $obj[AdministratorColumn::USERNAME],
                    AdministratorColumn::ID => $obj[AdministratorColumn::ID],
                ),
                array("OR")
            );
            if (!empty($query)) {
                return $this->setData($query[0]);
            }
            return null;
        }
        if ($branchId) {
            $query = (array)  $this->table->get(
                null,
                Condition::WHERE,
                array(
                    AdministratorColumn::BRANCHID => $branchId,
                )
            );
            if (!empty($query)) {
                $admins = [];
                foreach ($query as $data)
                    $admins[] =  $this->setData($data);
                return $admins;
            }
            return null;
        } else  return null;
    }


    public function updateLevel($id, $status)
    {
        $return = array();
        $stmt = $this->table->update(array(AdministratorColumn::ROLE), array(), array(AdministratorColumn::ID => $id));
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        return json_encode($return);
    }

    public function resetPassword()
    {
        $return = array();
        $password = $this->generatePassword(rand(6, 9));
        $this->setPassword($password);
        $obj = $this->object(false);
        $stmt = $this->table->update(array(AdministratorColumn::PASSWORD), array($obj[AdministratorColumn::PASSWORD]), array(AdministratorColumn::ID => $this->id));
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        if ($return[parent::RESULT]) {
            $this->sendResetMail($this->username, $password);
        }
        $return[parent::ERROR] = null;
        return json_encode($return);
    }

    public function getStaffs(Administrator $admin): array
    {
        $staffs = [];
        $query = (array) $this->table->get();
        if (count($query) > 0) {
            foreach ($query as $staff) {
                $staff = $this->setData($staff);
                if ($admin->getId() != $staff->getId()) {
                    if ($admin->getRole() == 2 && $staff->getBranchId() == $admin->getBranchId() && intval($admin->getRole() < intval($staff->getRole()))) {
                        $staffs[] = $staff;
                    }
                    if ($admin->getRole() == 1) {
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
        $ceo = array('CEO', 'color' => '#BEC5FF', 'data' => self::OWNER, 'trn' => 'ceo');
        $manager = array('Manager', 'color' => '#AEFFAC', 'data' => self::MANAGER, 'trn' => 'manager');
        $cashier = array('Cashier', 'color' => '#FFCEA0', 'data' => self::REJI, 'trn' => 'cashier');
        $driver = array('Driver', 'color' => '#FEB9B9', 'data' => self::DRIVER, 'trn' => 'driver');
        $staff = array('Staff', 'color' => '#28A745', 'data' => self::STAFF, 'trn' => 'staff');

        switch (intval($this->role)) {
            case self::OWNER:
                return array($ceo, $manager, $cashier, $driver, $staff);
            case self::MANAGER:
                return array($manager, $cashier, $driver, $staff, $ceo);
            case self::REJI:
                return array($cashier, $driver, $staff, $ceo, $manager);
            case self::DRIVER:
                return array($driver, $staff, $ceo, $manager, $cashier,);
            case self::STAFF:
                return array($staff, $ceo, $manager, $cashier, $driver,);
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
