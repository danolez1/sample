<?php

namespace danolez\lib\Res;

class Cookie
{

    public function __construct()
    {
        if (!count($_COOKIE) > 0) {
            $_COOKIE = array();
        }
    }

    public function get(string $key)
    {
        return $_COOKIE[$key];
    }


    public function set(string $key, $value, $time = 0, $dir = "/")
    {
        $_COOKIE[$key] = $value;
        if ($time > 0) {
            setcookie($key, $value, time() + $time, $dir);
        }
    }

    public function delete($key)
    {
        setcookie($key, "", time() - 3600);
    }
}
