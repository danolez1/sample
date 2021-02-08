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
use PaymentDetailsColumn;
use ReflectionClass;
use ReflectionProperty;

class CreditCard
{
    public $cvv, $cardName, $cardNumber, $expiryDate, $cardType;
    private $ntNumber, $id;

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
    public $email, $name;

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
            $error = Error::NullCreditCardName;
        } else if (get_card_brand($this->creditCard->cardNumber) == "" || strlen($this->creditCard->cardNumber) < 12) {
            $error = Error::InvalidCardNumber;
        } else if (is_null($this->creditCard->cvv) || $this->creditCard->cvv == "" || strlen($this->creditCard->cvv) < 3) {
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
        $mail = new Email();
        $mail->setTo($this->email, $this->name);
        $EN = $_COOKIE['lingo'] == 'en';
        $name = Setting::getInstance()->getStoreName();
        $mail->setSubject($EN ? "【 $name 】- Notification" : "【 $name 】- お知らせ");
        $message['en'] = "Thank you for using $name. You just added a payment method to your profile. This is an automatic message to indicate changes made on your profile, so you don't have to reply.";
        $message['jp'] = "$name ご利用いただきありがとうございます。お客様のクレジットカードを追加しました。　これは、メッセージを受け取ったことを示す自動返信なので、返信する必要はありません。";
        $body = file_get_contents('app/Views/email/contact.php');
        $body = str_replace("{name}", $EN ? "Dear " . $this->name . "," : $this->name . '様,', $body);
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


    public function get($id = null)
    {
        $cards = [];
        $obj = $this->object(false);
        if ($id == null)
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
                )
            );
        else {
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
                    PaymentDetailsColumn::ID => $id,
                ),
                array("AND")
            );
        }
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
            $query = (array) $this->table->get(
                null,
                Condition::WHERE,
                array(
                    PaymentDetailsColumn::USERID => $obj[PaymentDetailsColumn::USERID],
                    PaymentDetailsColumn::ID => $obj[PaymentDetailsColumn::ID],
                ),
                array("AND")
            );
            $req = !empty($query) ? $query[0] : [];
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
