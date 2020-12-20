<?php

namespace Demae\Auth\Models\Contact;

use ContactColumn;
use danolez\lib\DB\Credential\Credential;
use danolez\lib\DB\Model\Model;
use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Error\Error;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use ReflectionClass;
use ReflectionProperty;

class Contact extends Model
{
    private $sn;
    private $name;
    private $email;
    private $subject;
    private $message;
    private $timeStamp;
    private $log;  //location,useragent,url
    private $to;
    private $branchId;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;
    const ADMIN_MAIL = "danolez1fatuns@gmail.com";

    public function __construct()
    {
        parent::__construct();
    }

    protected function setTableName()
    {
        $this->tableName = Credential::CONTACTS_TBL;
    }

    public function send()
    {
        $return = array();
        $validate = json_decode($this->validate())->{parent::ERROR};
        if (is_null($validate)) {
            $obj = $this->object();
            $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
            $return[parent::RESULT] = (bool) $stmt->affected_rows;
        }
        $return[parent::ERROR] = $validate;
        return json_encode($return);
    }

    public  function mail()
    {
        $server = "smtp.gmail.com"; //"smtp-pulse.com"; // "smtp.sendgrid.net";
        $port = 465; //587
        $username = 'danolez1fatuns@gmail.com';
        $password = "God is good";
        //SEND TWO WAYS
        //ENCRYPT AUTH DATA
        try {
            $mail = new PHPMailer(TRUE);
            $mail->setFrom('danolez1fatuns@gmail.com', 'Darth Vader');
            $mail->addAddress($this->getEmail(), $this->getName());
            $mail->Subject = 'Force';
            $mail->isHTML(TRUE);
            $mail->Body = '<html>There is a great disturbance in the <strong>Force</strong>.</html>';
            $mail->AltBody = 'There is a great disturbance in the Force.';
            $mail->IsSMTP();
            $mail->Host = $server;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;

            /* Finally send the mail. */
            if (!$mail->send()) {
                /* PHPMailer error. */
                //echo $mail->ErrorInfo;
            } //else echo "O TI SEND";
        } catch (Exception $e) {
            /* PHPMailer exception. */
            echo $e->errorMessage();
        } catch (\Exception $e) {
            /* PHP exception (note the backslash to select the global namespace Exception class). */
            echo $e->getMessage();
        }
    }

    public function validate()
    {
        $error = null;
        if (is_null($this->name) || $this->name == "") {
            $error = Error::NullName;
        } else if (!validateEmail($this->email)) {
            $error = Error::InvalidEmail;
        } else if (is_null($this->subject) || $this->subject == "") {
            $error = Error::NullSubject;
        } else if (is_null($this->message) || $this->message == "") {
            $error = Error::NullMessage;
        }
        return json_encode(array(parent::ERROR => $error));
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
        if ($data == null) return new Contact();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new Contact();
        foreach (array_values($properties) as $key) {
            if ($key == ContactColumn::LOG) {
                $obj->{$key} = Encoding::decode($data->{$key}, self::VALUE_ENCODE_ITERTATION);;
            } else
                $obj->{$key} = $data->{$key};
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
                if ($key == ContactColumn::LOG) {
                    $assoc ? $temp[$key] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION) : $temp[] = Encoding::encode($value, self::VALUE_ENCODE_ITERTATION);
                } else {
                    $assoc ? $temp[$key] = ($value) : $temp[] = ($value);
                }
            }
            return $temp;
        } else {
            return Credential::encrypt($data); //,$key
        }
    }


    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }
    /**
     * Get the value of sn
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set the value of sn
     *
     * @return  self
     */
    public function setSn($sn)
    {
        $this->sn = $this->purify($sn);

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
     * Get the value of subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @return  self
     */
    public function setSubject($subject)
    {
        $this->subject = $this->purify($subject);

        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $this->purify($message);

        return $this;
    }

    /**
     * Get the value of timeStamp
     
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Set the value of timeStamp
     
     *
     * @return  self
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $this->purify($timeStamp);

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
        $this->log = $this->purify($log);

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
        $this->to = $this->purify($to);

        return $this;
    }
}
