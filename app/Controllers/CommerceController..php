<?php

use danolez\lib\DB\Controller;
use danolez\lib\DB\Model;
use Demae\Auth\Models\Error;
use Demae\Auth\Models\Shop\Address;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Order;
use Demae\Auth\Models\Shop\CreditCard;
use Demae\Auth\Models\Shop\PaymentDetails;
use Demae\Auth\Models\Shop\Setting;
use Demae\Controller\ShopController\HomeController;

class CommerceController extends Controller
{
    private $user;
    private $order;
    private $orderData;
    private $opened;
    private $minOrder;
    private $session;

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function manage()
    {
        if (isset($this->data['place-order'])) {
            return json_encode($this->placeOrder());
        } else return null;
    }



    private function validate()
    {
        $return = array();
        $error = null;
        $order = new Order();
        $order->setDeliveryOption($this->data['delivery_option']);
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
        if (isset($this->data['checkout-address']) && !isEmpty($this->data['checkout-address']) && ($this->data['checkout-address']) != "on") {
            $address->setUserId($this->user->getId());
            $address = $address->get($this->data['checkout-address']);
            if (!is_array($address) || count($address) < 1) {
                $error = Error::NullAddress;
            } else {
                $address = $address[0];
            }
        }
        $order->setAddress($address);
        $error = (array)(json_decode($address->validate())->{Model::ERROR});
        $return[Model::ERROR] = $error;
        if ($error != null && count($error) > 0) return ($return);


        if (isset($this->data['payment_option']) && $this->data['payment_option'] == PaymentDetailsColumn::CARD) {
            $payment = new PaymentDetails();
            $creditCard = new CreditCard();
            $creditCard->cardName = $this->data['name'];
            $creditCard->cardNumber = removeSpace($this->data['number']);
            $creditCard->expiryDate = removeSpace($this->data['expiry']);
            $creditCard->cardType = get_card_brand($creditCard->cardNumber);
            $creditCard->cvv = $this->data['cvc'];
            $payment->setCreditCard($creditCard);

            if (isset($this->data['checkout-payment']) && !isEmpty($this->data['checkout-payment'])) {
                $payment->setUserId($this->user->getId());
                $creditCard = $payment->get($this->data['checkout-payment']);

                if (!is_array($creditCard) || count($creditCard) < 1) {
                    $error = Error::NullCard;
                } else {
                    $creditCard  = $creditCard[0];
                    $payment->setCreditCard($creditCard);
                }
            }
            $return[Model::ERROR] = $error;
            if ($error != null && count($error) > 0) return ($return);
            $error = (array)(json_decode($payment->validate())->{Model::ERROR});
            $return[Model::ERROR] = $error;
            if ($error != null && count($error) > 0) return ($return);
            $order->setPaymentDetails($payment);
        }

        $deliveryReservations  = (!isEmpty($this->data['delivery-date']) && !isEmpty($this->data['delivery-time']));
        if ($order->getDeliveryOption() == OrderColumn::HOME_DELIVERY) {
            $order->setScheduled(json_encode(array('date' => $this->data['delivery-date'], 'time' => $this->data['delivery-time'])));
            if (!isEmpty($this->data['delivery-date']) && isEmpty($this->data['delivery-time'])) {
                $error = Error::InvalidDeliveryTime;
                $return[Model::ERROR] = $error;
                return $return;
            } else if (isEmpty($this->data['delivery-date']) && !isEmpty($this->data['delivery-time'])) {
                $error = Error::InvalidDeliveryDate;
                $return[Model::ERROR] = $error;
                return $return;
            } else if (!$deliveryReservations  && !$this->opened) {
                $error = Error::Closed;
                $return[Model::ERROR] = $error;
                return $return;
            }


            if ($error != null && count($error) > 0) return ($return);
        } else if ($order->getDeliveryOption() == OrderColumn::TAKE_OUT) {
            if (isEmpty($this->data['takeout-time'])) {
                $error = Error::InvalidTakeoutTime;
            } elseif (isEmpty($this->data['takeout-date'])) {
                $error = Error::InvalidTakeoutDate;
            } else {
                $order->setScheduled(json_encode(array('date' => $this->data['takeout-date'], 'time' => $this->data['takeout-time'])));
            }

            $return[Model::ERROR] = $error;
            if ($error != null && count($error) > 0) return ($return);
            $error = (array)(json_decode($order->getAddress()->validate(true))->{Model::ERROR});
        } else {
            $error = Error::InvalidDeliveryMethod;
            $return[Model::ERROR] = $error;
            return $return;
        }

        if (intval($this->minOrder) > intval($this->getOrder()->getAmount())) {
            $error = Error::BelowMinOrder;
            $return[Model::ERROR] = $error;
            return $return;
        }

        $branch = new Branch();
        $branch = $branch->get(null, $this->order->getBranch());
        if (!isset($branch[0])) {
            $error = Error::InvalidBranch;
        }

        $return[Model::ERROR] = $error;
        $order->setDeliveryTime($this->data['deliveryTime']);
        $this->orderData = $order;
        return $return;
    }

    public function placeOrder()
    {
        $validation = $this->validate();
        if (is_array($validation) && isset($validation[Model::ERROR]) && count($validation[Model::ERROR]) < 1) {
            $order = $this->orderData;
            $shippingFee = (intval($this->getOrder()->getAmount()) >= intval(Setting::getInstance()->getFreeDeliveryPrice()) ? 0 : intval(Setting::getInstance()->getShippingFee()));
            $order->setCart($this->getOrder()->getCart());
            $order->setAmount($this->getOrder()->getAmount());
            $order->setUserDetails(is_null($this->user) ? $this->session->get(HomeController::GUEST) : $this->user->getId());
            $order->setStatus(OrderColumn::ORDER_RECEIVED);
            $order->setDeliveryFee($shippingFee);
            $cart = $order->getCart();
            $ncart = [];
            foreach ($cart as $item) {
                $item = $item->properties(true);
                $item = Model::unsetModelProperties($item);
                $ncart[] = $item;
            }
            $order->setCart(json_encode($ncart));

            $address = $order->getAddress();
            $address = $address->properties(true);
            $address = Model::unsetModelProperties($address);
            unset($address['id']);
            unset($address['userId']);
            unset($address['timeCreated']);
            unset($address['log']);
            $order->setAddress(json_encode($address));
            if (isset($this->data['payment_option'])) {
                $order->setPaymentMethod($this->data['payment_option']);

                if ($this->data['payment_option'] == PaymentDetailsColumn::CARD) {
                    $payment = $order->getPaymentDetails();
                    $payment = $payment->properties(true);
                    $payment = Model::unsetModelProperties($payment);
                    unset($payment['id']);
                    unset($payment['userId']);
                    unset($payment['timeCreated']);
                    unset($payment['log']);
                    unset($payment['cards']);
                    $order->setPaymentDetails($payment);
                } else {
                    $order->setPaymentDetails($this->data['payment_option']);
                }
            }
            $order->setBranch($this->order->getBranch());
            $order->setTimeCreated(time());
            return $order->request();
        } else {
            return ($validation);
        }
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
     * Get the value of order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of opened
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * Set the value of opened
     *
     * @return  self
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;

        return $this;
    }

    /**
     * Get the value of minOrder
     */
    public function getMinOrder()
    {
        return $this->minOrder;
    }

    /**
     * Set the value of minOrder
     *
     * @return  self
     */
    public function setMinOrder($minOrder)
    {
        $this->minOrder = $minOrder;

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
}
