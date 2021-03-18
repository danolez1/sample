<?php

use danolez\lib\DB\Controller;
use danolez\lib\DB\Model;
use danolez\lib\Security\Encryption;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Address;
use Demae\Auth\Models\Shop\Administrator;
use Demae\Auth\Models\Shop\Log;
use Demae\Auth\Models\Shop\CreditCard;
use Demae\Auth\Models\Shop\PaymentDetails;
use Demae\Auth\Models\Shop\User;

class UserController extends Controller
{
    private $user;
    private $admin;

    const USER_COOKIE = '28283f281780d63ea0da0808174317f208280acf43f9eef2ee40ee40';

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function profileManagement()
    {
        if (isset($this->data['login'])) {
            return $this->userAuth();
        } else if (isset($this->data['sign-up'])) {
            return $this->createUser();
        } else if (isset($this->data["save-card"])) {
            return $this->savePayment();
        } else if (isset($this->data['save-address'])) {
            return  $this->saveAddress();
        } else if (isset($this->data['reset'])) {
            return  $this->resetPassword();
        } else return null;
    }

    protected function userAuth()
    {
        $user = new User();
        $user->setEmail($this->data['lemail']);
        $user->setPassword($this->data['lpassword']);
        return ($user->authenticate());
    }

    protected function createUser()
    {
        $user = new User();
        $user->setName($this->data['name']);
        $user->setEmail($this->data['remail']);
        $user->setPhoneNumber($this->data['phone']);
        $user->setPassword($this->data['rpassword']);
        $log = new Log();
        $user->setLog(json_encode($log->properties()));
        $user->setTimeCreated(time());
        $register = $user->register();
        $validate = json_decode($register)->{Model::ERROR};
        if (is_null($validate)) {
            $user = new User();
            $user->setEmail($this->data['remail']);
            $user->setPassword($this->data['rpassword']);
            return ($user->authenticate());
        } else
            return $register;
    }


    public function resetPassword()
    {
        if (isset($this->data['reset-password']) && isset($this->data['creset-password'])) {
            if ($this->data['reset-password'] != $this->data['creset-password']) {
                return json_encode(array(Model::ERROR => Error::PasswordMismatch));
            }
            $user = new User();
            $user->setId($_COOKIE[self::USER_COOKIE]);
            $user = $user->get();
            if (is_null($user)) {
                return json_encode(array(Model::ERROR => Error::UserNoExist));
            } else {
                $code = $this->data['reset-code'];
                if (Encryption::verify($user->getPassword(), $code)) {
                    $user->setPassword($this->data['reset-password']);
                    setcookie(self::USER_COOKIE, null, time() - 3000, "/");
                    return $user->resetPassword(true);
                } else {
                    return json_encode(array(Model::ERROR => Error::InvalidRecoveryCode));
                }
            }
        } else {
            $user = new User();
            $user->setEmail($this->data['femail']);
            $user = $user->get();
            if (is_null($user)) {
                return json_encode(array(Model::ERROR => Error::UserNoExist));
            } else {
                setcookie(self::USER_COOKIE, $user->getId(), time() + 3000, "/");
                return $user->resetPassword();
            }
        }
    }

    public function adminAuth()
    {
        if (isset($this->data['auth'])) {
            $admin = new Administrator();
            $admin->setUsername($this->data['username']);
            $admin->setPassword($this->data['password']);
            return ($admin->authenticate());
        } else if (isset($this->data['reset'])) {
            $admin = new Administrator();
            $admin->setUsername($this->data['username']);
            $admin = $admin->get();
            if (is_null($admin)) {
                return json_encode(array(Model::ERROR => Error::UserNoExist));
            } else {
                return $admin->resetPassword();
            }
        } else return null;
    }

    protected function savePayment()
    {
        $creditCard = new CreditCard();
        $creditCard->cardName = $this->data['name'];
        $creditCard->cardNumber = removeSpace($this->data['number']);
        $creditCard->expiryDate = removeSpace($this->data['expiry']);
        $creditCard->cardType = get_card_brand($creditCard->cardNumber);
        $creditCard->cvv = $this->data['cvc'];
        $paymentDetails = new PaymentDetails();
        $paymentDetails->setTimeCreated(time());
        $paymentDetails->email = $this->user->getEmail();
        $paymentDetails->name = $this->user->getName();
        $paymentDetails->setUserId($this->user->getId());
        $log = new Log();
        $paymentDetails->setLog(json_encode($log->properties()));
        $paymentDetails->setCreditCard($creditCard);
        return ($paymentDetails->saveCard());
    }

    protected function saveAddress()
    {
        $address = new Address();
        $address->setFirstName($this->data['fname']);
        $address->setLastName($this->data['lname']);
        $address->setPhoneNumber($this->data['phone']);
        $address->setEmail($this->data['email']);
        $address->setZip($this->data['zip']);
        $address->setCity($this->data['city']);
        $address->setState($this->data['state']);
        $address->setAddress($this->data['address']);
        $address->setStreet($this->data['street']);
        $address->setBuilding($this->data['building']);
        $address->setUserId($this->user->getId());
        $address->setTimeCreated(time());
        $log = new Log();
        $address->setLog(json_encode($log->properties()));
        return $address->save();
    }

    protected function decode()
    {
    }
    public function setApi($api)
    {
    }
    protected function setProperties()
    {
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @return  self
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }
}
