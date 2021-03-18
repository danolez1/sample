<?php

namespace danolez\lib\Res\Payment;

use danolez\lib\DB\Model;
use Demae\Auth\Models\Shop\CreditCard;
use Exception;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

require_once('app/lib/php/Res/stripe/init.php');
class StripeApi
{
    const CHARGE_URL = 'https://api.stripe.com/v1/charges';
    const SECRET_KEY = "sk_test_51I3efdBTDlmC6SL422IENFLTqwo83qewTPurf6kB8u07Aqr10xoac6Ww10sgh8TgkFN13kl2QI5xNeu0iGok8trN00iGPPDXbr";
    // Actions
    const CHARGE  = "charge";
    const SUBSCRIPTIONS = "subscription";
    const REFUND = "refund";
    const CANCEL_SUBSCRIPTION = "cancel_sub";

    private $stripe;
    private $price;
    private $currency;
    private $description;
    private $creditCard;
    private $email;

    public function __construct($action = self::CHARGE)
    {
        $this->stripe = new StripeClient(self::SECRET_KEY);
    }

    public function charge()
    {
        $return = array();
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $this->price,
                'currency' => $this->currency,
                'source'   => $this->generateToken()['id'],
                'description' => $this->description,
                'receipt_email' => $this->email
            ]);

            $return[Model::RESULT] = ($charge->amount_captured == intval($this->price));
            $return[Model::DATA] = $charge;
            $return[Model::COMMENT] = $charge->status;
        } catch (Exception $e) {
            $return[Model::RESULT] = false;
            $return[Model::COMMENT] = $e->getMessage();
        }
        return json_encode($return);
    }


    public function refund($chargeId)
    {
        $return = array();
        $refund = $this->stripe->refunds->create([
            'charge' => $chargeId,
        ]);
        $return[Model::RESULT]($refund->amount == intval($this->price));
        $return[Model::DATA] = $refund;
        $return[Model::COMMENT] = $refund->status;
        return json_encode($return);
    }

    private function generateToken()
    {
        $expiry = explode('/', $this->creditCard->expiryDate);
        if (strlen($expiry[1]) == 2) {
            $expiry[1] = $expiry[1] + 2000;
        }
        return $this->stripe->tokens->create([
            'card' => [
                'number'    => $this->creditCard->getNtNumber() ?? $this->creditCard->cardNumber,
                'exp_month' => $expiry[0],
                'exp_year'  => $expiry[1],
                'cvc'       => $this->creditCard->cvv,
            ],
        ]);

        // $this->stripe->tokens->retrieve(
        //     'tok_1I3enxBTDlmC6SL4UtO58hac',
        //     []
        //   );
    }

    public function createCustomer()
    {
        $newCustomer =  $this->stripe->customers->create([
            'description' => 'My First Test Customer (created for API docs)',
        ]);

        // $customer =  $this->stripe->customers->retrieve(
        //     'cus_If0lwrW3OX4J6O',
        //     []
        //   );
    }

    public function subscribe()
    {

        $this->stripe->prices->create([
            'unit_amount' => 2000,
            'currency' => 'jpy',
            'recurring' => ['interval' => 'month'],
            'product' => 'prod_HKLOUVloFKQALy',
        ]);

        //   $this->stripe->prices->retrieve(
        //     'price_1I3gkBF5IfL0eXz9cXP1XpAI',
        //     []
        //   );

        $this->stripe->prices->all(['limit' => 3]);

        $subscribe = $this->stripe->subscriptions->create([
            'customer' => 'cus_If0lwrW3OX4J6O',
            'items' => [
                ['price' => 'price_1I3gkBF5IfL0eXz9cXP1XpAI'],
            ],
        ]);

        //   $this->stripe->subscriptions->retrieve(
        //     'sub_If0ldgT59KuUyo',
        //     []
        //   );
    }


    public function cancel()
    {
        $this->stripe->subscriptions->retrieve(
            'sub_If0ldgT59KuUyo',
            []
        );
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
}
