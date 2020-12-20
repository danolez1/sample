<?php

namespace danolez\lib\Security\KeyFactory;

class KeyFactory
{
    const INTERACTIVE = 0;
    const MODERATE = 1;
    const SENSITIVE = 2;
    const INTENSE = 3;


    public static function genCoke()
    {
        return sodium_crypto_secretstream_xchacha20poly1305_keygen();
    }

    public static function genSoda()
    {
        return sodium_crypto_secretbox_keygen();
    }

    public static function randomBytes(int $type)
    {
        switch ($type) {
            case self::INTERACTIVE:
                return sha1(mt_rand());
            case self::MODERATE:
                return sodium_bin2hex(openssl_random_pseudo_bytes(32));
            case self::SENSITIVE:
                return sodium_bin2hex(random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES)); //32
            case self::INTENSE:
                return sodium_bin2hex(random_bytes(SODIUM_CRYPTO_BOX_KEYPAIRBYTES)); //64s
        }
    }
}

//sha1(mt_rand()
//bin2hex(openssl_random_pseudo_bytes(32))
// base64_encode(random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES));//32
//base64_encode(random_bytes(SODIUM_CRYPTO_BOX_KEYPAIRBYTES));//64