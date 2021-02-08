<?php

namespace danolez\lib\DB;

use danolez\lib\DB\DataType;
use danolez\lib\Security\Encryption;

abstract class Credential
{
    const SERVER_NAME = ("localhost");
    const SERVER_USERNAME = ("root");
    const SERVER_PASSWORD = ("");

    const SHOP_DB = "demae_shop_db";
    const ACCOUNTS_TBL = "account_tb";
    const PAYMENT_METHODS_TBL = "mop_tb";
    const SETTINGS_TBL = "settings_tb";
    const PRODUCTS_TBL = "products_tb";
    const DELIVERY_TBL = "deliveries_tb";
    const ADDRESSES_TBL = "address_tb";
    const ADMINISTRATORS_TBL = "admin_tb";
    const BRANCHES_TBL = "branches_tb";
    const CARTS_TBL = "carts_tb";
    const FAVORITES_TBL = "favourites_tb";
    const CATEGORY_TBL = "category_tb";
    const LOGS_TBL = "logs_tb";
    const ORDERS_TBL = "orders_tb";
    const PROMOTIONS_TBL = "promotions_tb";
    const USERS_TBL = "users_tb";
    const CONTACTS_TBL = "contacts_tb";
    const MESSAGING_TBL = "messaging_tb";
    const NOTIFICATIONS_TBL = "notifications_tb";
    const TRAFFIC_TBL = "traffic_tb";
    const RATINGS_TBL = "ratings_tb";

    const SERVER_NAME3 = "T0daak9ERTFOekZsTkRBME56Y3dOVGRsT1daaFlqSmhOR0ZqTVRBNE9XUTRaRFU0T0RNM1ptRTFPRFU1TnpZejQ4ZWZiZmJkZWZiZmJkZWZiZmJkMzU0Y2VmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZDA1MDZlZmJmYmQyMDQ2Mzk3NGVmYmZiZGVmYmZiZGVmYmZiZDEzMmFlZmJmYmRlZmJmYmQyZWVmYmZiZDNmM2UyMDFkZDY4MGVmYmZiZDU2MTRlZmJmYmRkOGIwZWZiZmJkYzk4OTJjNWQzNmVmYmZiZDZiZWZiZmJkM2UyMGVmYmZiZGVmYmZiZDUyM2I0MTdjZWZiZmJkNTQxZDU1ZWZiZmJkMjhaR0ZpTWpobVpqQmxNMlZoWWpFek16Um1ZekprWldFNU1ETmxZVFU0WTJSbU0yWmtPV1pqWkdZelltUXhZemt4TkRVMllURXdNRFppTnpReU9HWmpNUT09";
    const SERVER_USERNAME3 = "WTJJMk1ESTFPRGt6TjJNNE4yUXdPV1ZqTm1JMFpXUTNZbU5oTnpSa1ltSTVPRGczWWpjM05qa3hNelJtWXpFejBiNjM3OGVmYmZiZDBlNTJlZmJmYmRlZmJmYmQ0ZGVmYmZiZDU5NTRlZmJmYmRlZmJmYmRjYWIzZWZiZmJkMTZlZmJmYmRlZmJmYmQzMTJiNTkzN2VmYmZiZDVmMDYyNGVmYmZiZGVmYmZiZGVmYmZiZDA0NmVlZmJmYmQ3M2VmYmZiZDY0NDZlZmJmYmQzNTRhZWZiZmJkZWZiZmJkMzJjZDkyZWZiZmJkNTBlZmJmYmRlZmJmYmQwNzNmM2RlZmJmYmRlZmJmYmRlZmJmYmRjM2FhNTRlZmJmYmRlZmJmYmQ3OWVmYmZiZE1qUXhOV014T0RRNE56SXhPRFU1Tmpjd01qUXlNMlF6WlRjMFlUY3paRGRtT1dKa1kyRmxZbU16TW1OaE56VTJNR1JoTldFd1pUSTVNRFppWlRJNFlnPT0=";
    const SERVER_PASSWORD3 = "T0dSaE5XRXpNamRsTWpJd1lUZzJZV1kzTkRjM1ltTmxOVGN4Tm1NNU4yRTNPVGM1TlRJM1pqRmxaVGcyWmpsazQ4ZWZiZmJkZWZiZmJkZWZiZmJkMzU0Y2VmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZDA1MDZlZmJmYmQyMDQ2Mzk3NGVmYmZiZGVmYmZiZGVmYmZiZDEzMmFlZmJmYmRlZmJmYmQyZWVmYmZiZDNmM2UyMDFkZDY4MGVmYmZiZDU2MTRlZmJmYmRkOGIwZWZiZmJkYzk4OTJjNWQzNmVmYmZiZDZiZWZiZmJkM2UyMGVmYmZiZGVmYmZiZDUyM2I0MTdjZWZiZmJkNTQxZDU1ZWZiZmJkMjhORE5sTW1KbU5qRTRaR014WldabVltWTFaV1JpTldRM1pHTTBZMkpsTmpSalpqQXdaRGM1T0RFeU1qbGlNalpsT0RBek5HTmxNekZpTkdVd1pEZ3dZZz09";

    /**
     * encrypt
     *
     *
     * @param  mixed $s
     * @param  mixed $key
     * @return string
     */
    public static function encrypt($s, $key = null)
    {
        if ($s == null || $s == "") return null;
        else {
            $enc = new Encryption($key);
            return $enc->encrypt(DataType::STRING, $s);
        }
    }
    /**
     * decrypt
     *
     * @param  mixed $s
     * @param  mixed $key
     * @return string
     */
    public static function decrypt($s, $key = null)
    {
        if ($s == null) return null;
        else {
            $enc = new Encryption($key);
            return $enc->decrypt(DataType::STRING, $s);
        }
    }

    /**
     * sEncrypt
     *
     * @param  mixed $s
     * @param  mixed $key
     * @return void
     */
    public static function sEncrypt($s, $key = null)
    {
        if ($s == null || $s == "") return null;
        else {
            $enc = new Encryption($key);
            return $enc->sEncrypt($s);
        }
    }
    /**
     * sDecrypt
     *
     * @param  mixed $s
     * @param  mixed $key
     * @return void
     */
    public static function sDecrypt($s, $key = null)
    {
        if ($s == null || $s == "") return null;
        else {
            $enc = new Encryption($key);
            return $enc->sDecrypt($s);
        }
    }

    /**
     * sEncrypt
     *
     * @param  mixed $s
     * @param  mixed $key
     * @return void
     */
    public static function hash($s)
    {
        if ($s == null || $s == "") return null;
        else {
            return Encryption::hash($s);
        }
    }
    /**
     * sDecrypt
     *
     * @param  mixed $s
     * @param  mixed $key
     * @return void
     */
    public static function verify(string $storedPassword, string $password)
    {
        return Encryption::verify($storedPassword, $password);
    }
}
