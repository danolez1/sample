<?php

namespace danolez\lib\Res\Session;

use danolez\lib\Res\Ini\Ini;
use danolez\lib\Res\Server\Server;
use danolez\lib\Security\Encoding\Encoding;


class Session
{
    const USER_SESSION = "demae_user";
    const ADMIN_SESSION = "demae_admin";

    // Encoding::encode(const,1);
    const EXPIRES = "9c282a26f908f24bc59350bcfa284b6cf17d1eeeee40ee40";
    const CREATED = "9c283f061780d243a0635001fa934b28f17d1eeeee40ee40";
    const COOKIE = "a0283f9b3f082243f1f8a0d602eeeeeeee40ee40";
    const USER_ID = "a0282a4bd90802dac5f870d6eeeeeeeeee40ee40";

    public function __construct(string $name)
    {
        // start session
        //check variables
        //if absent
        //destroy session and
        $this->start((Encoding::encode($name)));
        // session_id(sodium_bin2hex(random_bytes(SODIUM_CRYPTO_BOX_KEYPAIRBYTES))); 
    }

    public function get(string $key)
    {
        return  isset($_SESSION[$key]) ?   $_SESSION[$key] : null;
    }


    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    function start($name)
    {
        ini_set("session.use_strict_mode", true);
        ini_set("session.use_cookies", 1);
        ini_set("session.use_trans_sid", 1);
        $domain =  Server::get(Server::SERVER_NAME) . '/' . $name . '/';
        $path = '/' . (Encoding::encode($name));
        $limit = 60 * 60 * 24;
        // session_set_cookie_params($limit, $path, $domain, true, true);
        session_name($name);
        if (!isset($_COOKIE[$name])) {
            $_COOKIE[$name] = session_create_id();
        }
        session_id($_COOKIE[$name]);
        session_start();
        session_regenerate_id(true);
        $_COOKIE[$name] = session_id();
        $this->set(self::EXPIRES, time() + $limit);
    }


    public function refresh()
    {
        // session_regenerate_id();
        session_id(sodium_bin2hex(random_bytes(SODIUM_CRYPTO_BOX_KEYPAIRBYTES)));
        $_SESSION[self::EXPIRES] = time() + (3600 * 24);
        session_commit();
        // session_start();
    }

    public function destroy()
    {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    // private function secure()
    // {
    //     if (!isset($_SESSION[self::IP]) || !isset($_SESSION[self::USERAGENT]))
    //         return false;

    //     if ($this->get(self::IP) != Server::getIP("")->query)
    //         return false;

    //     if ($this->get(self::USERAGENT) != Server::get(Server::HTTP_USER_AGENT))
    //         return false;

    //     return true;
    // }

}
