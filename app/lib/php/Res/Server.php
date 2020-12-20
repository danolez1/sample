<?php

namespace danolez\lib\Res\Server;

use danolez\lib\Res\Curl\Curl;

class Server
{
    const MIBDIRS = "MIBDIRS";
    const MYSQL_HOME = "MYSQL_HOME";
    const OPENSSL_CONF = "OPENSSL_CONF";
    const PHP_PEAR_SYSCONF_DIR = "PHP_PEAR_SYSCONF_DIR";
    const PHPRC = "PHPRC";
    const TMP = "TMP";
    const HTTP_HOST = "HTTP_HOST";
    const HTTP_USER_AGENT = "HTTP_USER_AGENT";
    const HTTP_ACCEPT = "HTTP_ACCEPT";
    const HTTP_ACCEPT_LANGUAGE = "HTTP_ACCEPT_LANGUAGE";
    const HTTP_ACCEPT_ENCODING = "HTTP_ACCEPT_ENCODING";
    const HTTP_CONNECTION = "HTTP_CONNECTION";
    const HTTP_UPGRADE_INSECURE_REQUESTS = "HTTP_UPGRADE_INSECURE_REQUESTS";
    const HTTP_CACHE_CONTROL = "HTTP_CACHE_CONTROL";
    const PATH = "PATH";
    const SYSTEMROOT = "SystemRoot";
    const COMSPEC = "COMSPEC";
    const PATHEXT = "PATHEXT";
    const WINDIR = "WINDIR";
    const SERVER_SIGNATURE = "SERVER_SIGNATURE";
    const SERVER_SOFTWARE = "SERVER_SOFTWARE";
    const SERVER_NAME = "SERVER_NAME";
    const SERVER_ADDR = "SERVER_ADDR";
    const SERVER_PORT = "SERVER_PORT";
    const REMOTE_ADDR = "REMOTE_ADDR";
    const DOCUMENT_ROOT = "DOCUMENT_ROOT";
    const REQUEST_SCHEME = "REQUEST_SCHEME";
    const CONTEXT_PREFIX = "CONTEXT_PREFIX";
    const CONTEXT_DOCUMENT_ROOT = "CONTEXT_DOCUMENT_ROOT";
    const SERVER_ADMIN = "SERVER_ADMIN";
    const SCRIPT_FILENAME = "SCRIPT_FILENAME";
    const REMOTE_PORT = "REMOTE_PORT";
    const GATEWAY_INTERFACE = "GATEWAY_INTERFACE";
    const SERVER_PROTOCOL = "SERVER_PROTOCOL";
    const REQUEST_METHOD = "REQUEST_METHOD";
    const QUERY_STRING = "QUERY_STRING";
    const REQUEST_URI = "REQUEST_URI";
    const SCRIPT_NAME = "SCRIPT_NAME";
    const PHP_SELF = "PHP_SELF";
    const REQUEST_TIME_FLOAT = "REQUEST_TIME_FLOAT";
    const REQUEST_TIME = "REQUEST_TIME";

    const HTTP_CLIENT_IP = "HTTP_CLIENT_IP";
    const HTTP_X_FORWARDED_FOR = "HTTP_X_FORWARDED_FOR";

    const IP_CLIENT_1 = "https://extreme-ip-lookup.com/json/";
    const IP_CLIENT_2 = "http://ip-api.com/json//json/";


    public static function  get(string $key)
    {
        return $_SERVER[$key];
    }

    static public function getIP($url = "")
    {
        if (!empty(self::get(self::HTTP_CLIENT_IP))) {
            $ip = self::get(self::HTTP_CLIENT_IP);
        } elseif (!empty(self::get(self::HTTP_X_FORWARDED_FOR))) {
            $ip = self::get(self::HTTP_X_FORWARDED_FOR);
        } else {
            $ip = filter_var(self::get(self::REMOTE_ADDR), FILTER_VALIDATE_IP) ? self::get(self::REMOTE_ADDR) : gethostbyname($url);
        }
        return $ip;
    }

    static public function getHost()
    {
        return gethostbyaddr(self::get(self::REMOTE_ADDR));
    }

    /**
     * geoIp
     *require_onces to be written in TAC
     * @param  mixed $ip
     * @return void
     */
    public static function geoIp($ip = "")
    {
        $curl = new Curl(self::IP_CLIENT_1 . $ip);
        $f =  json_decode($curl->get());
        if ($f->{"status"} == "fail") {
            $curl->setUrl(self::IP_CLIENT_2 . $ip);
            $s =  json_decode($curl->get());
            if ($s->{"status"} == "fail")
                return $f["message"];
            else return json_encode($s, JSON_FORCE_OBJECT);
        } else return json_encode($f, JSON_FORCE_OBJECT);
    }
}
