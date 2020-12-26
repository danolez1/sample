<?php

use Demae\Auth\Models\Shop\PaymentDetails\CreditCard;

class Subscription
{
    private $plan, $time, $created, $amount, $creditCard;

    public function __construct($obj)
    {
        foreach ($obj as $property => $value) {
            if ($property == 'creditCard') {
                $this->creditCard = new CreditCard($value);
            } else
                $this->$property = $value;
        }
    }
}
