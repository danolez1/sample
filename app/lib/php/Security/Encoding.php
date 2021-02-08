<?php

namespace danolez\lib\Security;

abstract class Encoding
{

    public static function encode($data, $iterate = 1): string
    {
        if (is_null($data) || $data == "")
            return "";
        else {
            $data = str_rot13($data);
            for ($i = 0; $i < $iterate; $i++) {
                $data = base64_encode($data);
            }

            for ($i = 0; $i < $iterate; $i++) {
                $data = gzdeflate($data);
            }

            for ($i = 0; $i < $iterate; $i++) {
                $data = convert_uuencode($data);
            }

            for ($i = 0, $key = 27, $c = 48; $i <= 255; $i++) {
                $c = 255 & ($key ^ ($c << 1));
                $table[$key] = $c;
                $key = 255 & ($key + 1);
            }
            $len = strlen($data);
            for ($i = 0; $i < $len; $i++) {
                $data[$i] = chr($table[ord($data[$i])]);
            }
            return sodium_bin2hex($data);
        }
    }


    public static function decode($data, $iterate = 1)
    {
        if (is_null($data) || $data == "")
            return "";
        else {
            $data = sodium_hex2bin($data, "");
            for ($i = 0, $key = 27, $c = 48; $i <= 255; $i++) {
                $c = 255 & ($key ^ ($c << 1));
                $table[$c] = $key;
                $key = 255 & ($key + 1);
            }
            $len = strlen($data);
            for ($i = 0; $i < $len; $i++) {
                $data[$i] = chr($table[ord($data[$i])]);
            }

            for ($i = 0; $i < $iterate; $i++) {
                $data = convert_uudecode($data);
            }

            for ($i = 0; $i < $iterate; $i++) {
                $data = gzinflate($data);
            }
            for ($i = 0; $i < $iterate; $i++) {
                $data = base64_decode($data);
            }
            $data = str_rot13($data);
            return $data;
        }
    }
    public function base36tobase10($alpha)
    {
        # code...
    }

    public function base36tobase2($alpha,$bit)
    {
        # code...
    }
}
