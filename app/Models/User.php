<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Res\Email;
use danolez\lib\Res\Server;
use danolez\lib\Security\Encoding;
use danolez\lib\Security\Encryption;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Setting;
use Demae\Controller\ShopController\HomeController;
use ReflectionClass;
use ReflectionProperty;
use UserColumn;

class User extends Model
{
    private $id;
    private $name;
    private $email;
    private $phoneNumber;
    private $password;
    private $googleToken;
    private $facebookToken;
    private $timeCreated;
    private $session;
    private $cookie;
    private $log;


    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;
    const REGISTRATION = 0;
    const AUTHENTICATION = 1;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setTableName()
    {
        $this->tableName = Credential::USERS_TBL;
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
            } else if (!validateEmail($this->email)) {
                $error = Error::InvalidEmail;
            } else if (!validatePhone($this->getPhoneNumber())) {
                $error = Error::NullPhone;
            } else if (is_null($this->getPassword()) || $this->getPassword() == "" ||  strlen($this->password) < 4) {
                $error = Error::InvalidPassword;
            }
        } else if ($type == self::AUTHENTICATION) {
            if (!validateEmail($this->email)) {
                $error = Error::InvalidEmail;
            } else if (is_null($this->getPassword()) || $this->getPassword() == "" ||  strlen($this->password) < 4) {
                $error = Error::InvalidPassword;
            }
        }
        return json_encode(array(parent::ERROR => $error));
    }

    public function sendRegistrationMail()
    {
        $mail = new Email();
        $mail->setTo($this->email, $this->name);
        $EN = $_COOKIE['lingo'] == 'en';
        $name = Setting::getInstance()->getStoreName();
        $mail->setSubject($EN ? "【 $name 】- Registration" : "【 $name 】- 会員登録の手続きについて");
        $link = "";
        $message['en'] = 'Thank you very much for using ' . $name . '!<br>We have received your membership registration application!<br>▼Please confirm your email address by clicking the link below<br><a href="' . $link . '" >"' . $link . '"</a>';
        $message['jp'] = $name . ' をご利用頂きましてありがとうございます。会員登録の申込みを受付けました。<br>下記よりお手続きをお願い致します。<br>▼以下のURLよりご登録を完了してください。<br><a href="' . $link . '" >"' . $link . '"</a>※URL有効期限：メール受信から24時間。有効期限を過ぎると無効となります。<br>※本メールは自動送信です。このメールに返信頂いてもお答えできません。ご了承ください。<br>';
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
    }

    public function update()
    {
        # code...
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
                    UserColumn::EMAIL => $obj[UserColumn::EMAIL],
                )
            );
            $req = count($query) > 0 ? $query[0] : [];
            $auth = isset($req->{UserColumn::PASSWORD}) ?
                Encryption::verify($req->{UserColumn::PASSWORD}, $this->getPassword()) : false;
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
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    UserColumn::EMAIL => $obj[UserColumn::EMAIL],
                    UserColumn::PHONENUMBER => $obj[UserColumn::PHONENUMBER],
                ),
                array("OR")
            );
            $req = (array) $query;
            if (count($req) < 1) {
                $obj = $this->object();
                $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
                if ($return[parent::RESULT])
                    $this->sendRegistrationMail();
            } else {
                $validate =  (Error::UserExist);
            }
        }

        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public function get()
    {
        if ((!is_null($this->email) && $this->email != "") && (!is_null($this->id) && $this->id != "")) {
            $obj = $this->object(false);
            $query = $this->table->get(
                null,
                Condition::WHERE,
                array(
                    UserColumn::EMAIL => $obj[UserColumn::EMAIL],
                    UserColumn::ID => $obj[UserColumn::ID],
                ),
                array("AND")
            )[0];
            return $this->setData($query);
        } else return null;
    }

    public function getAllUser()
    {
        $users = [];
        $query = $this->table->get() ?? array();
        if (count($query) > 0) {
            foreach ($query as $user) {
                $users[] = $this->setData($user);
            }
        }
        return $users;
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
        if ($data == null) return new User();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new User();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            if ($encKey == UserColumn::LOG) {
                $obj->{$encKey} = Encoding::decode($data->{$encKey}, self::VALUE_ENCODE_ITERTATION);
            }
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
                if ($key == UserColumn::PASSWORD) {
                    $assoc ? $temp[$key] =  Encryption::hash($value) : $temp[] =  Encryption::hash($value);
                } else if ($key == UserColumn::LOG) {
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
        $this->id = $this->purify($id);

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
     * Get the value of googleToken
     */
    public function getGoogleToken()
    {
        return $this->googleToken;
    }

    /**
     * Set the value of googleToken
     *
     * @return  self
     */
    public function setGoogleToken($googleToken)
    {
        $this->googleToken = $googleToken;

        return $this;
    }

    /**
     * Get the value of facebookToken
     */
    public function getFacebookToken()
    {
        return $this->facebookToken;
    }

    /**
     * Set the value of facebookToken
     *
     * @return  self
     */
    public function setFacebookToken($facebookToken)
    {
        $this->facebookToken = $facebookToken;

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
     * Get the value of session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the value of session
     *
     * @return  self
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get the value of cookie
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * Set the value of cookie
     *
     * @return  self
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;

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
