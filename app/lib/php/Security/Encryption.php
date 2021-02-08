<?php

namespace danolez\lib\Security;

use danolez\lib\DB\DataType;
use danolez\lib\Security\Credential;
use danolez\lib\Security\Encoding;
use danolez\lib\Security\Delimiter;
use Exception;

class Encryption
{

    private $data;
    private $key;
    private $encode;
    private $decode;
    private $dataType;
    private $fileKey;
    private $newLocation;
    private $block;

    /**
     * Initialize Encryption Class
     * @param string DataType to encrypt
     * @param string Data or Location of file to encrypt 
     * @param string new Location  of file to encrypt
     */
    public function __construct(string $key = null)
    {
        $this->block = Credential::ENC_BLOCK_SIZE;
        if ($key != null) {
            $this->key =  Encoding::decode($key);
            $this->fileKey = Encoding::decode($key);
        } else {
            $this->key =  Encoding::decode(Credential::SODA);
            $this->fileKey = Encoding::decode(Credential::COKE);
        }
    }

    private function inputHandler(string $dataType, $data, string $newLocation = null)
    {
        if ($data == null && $data != "")
            throw new Exception("Cannot Encrypt NULL");
        $this->dataType = $dataType;
        $this->data = $data;
        $this->newLocation = $newLocation;
    }
    /**
     * hash
     *
     * @param  mixed $password
     * @return string
     */
    public static function hash($password)
    {
        if (!is_null($password)) {
            $hash = sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
            return sodium_bin2hex($hash);
        } else
            return "";
    }

    /**
     * verify
     *
     * @param  mixed $password
     * @param  mixed $storedPassword
     * @return bool
     */
    public static function verify(string $storedPassword, string $password): bool
    {
        //$verify = password_verify($password, $hash);
        return sodium_crypto_pwhash_str_verify(sodium_hex2bin($storedPassword, ""), $password);
    }

    public function sEncrypt($data)
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $pad = sodium_pad($data, $this->block);
        $cipher = sodium_crypto_secretbox($pad, $nonce, $this->key);
        $encode = json_encode(array((sodium_bin2hex($nonce)),  (sodium_bin2hex($cipher))));
        return Encoding::encode($encode);
    }

    public function sDecrypt($data)
    {
        $returnValue = "";
        $data = json_decode(Encoding::decode($data));

        $nonce = sodium_hex2bin(($data[0]), "");
        $cipher = sodium_hex2bin(($data[1]), "");

        $decipher = sodium_crypto_secretbox_open($cipher, $nonce, $this->key);
        $returnValue = sodium_unpad($decipher, $this->block);

        return $returnValue;
    }

    /**
     * encrypt
     *
     * @return void
     */
    public function encrypt(string $dataType, $data, string $newLocation = null)
    {
        $this->inputHandler($dataType, $data, $newLocation);
        if ($this->dataType == DataType::FILE) {
            $this->decode = $this->fileEncryption();
        } else {
            $this->encode = $this->stringEncryption();
        }
        return $this->encode;
    }

    /**
     * decrypt
     *
     * @return void
     */
    public function decrypt(string $dataType, $data, string $newLocation = null)
    {
        $this->inputHandler($dataType, $data, $newLocation);
        if ($this->dataType == DataType::FILE) {
            $this->decode = $this->fileDecryption();
        } else {
            $this->decode = $this->stringDecryption();
        }
        return $this->decode;
    }

    /**
     * stringDecryption
     *
     * @return void
     */
    private function stringDecryption()
    {
        $returnValue = "";
        if ($this->encode != null)
            $toDecode = $this->encode;
        else
            $toDecode = $this->data;

        $toDecode = base64_decode($toDecode);

        foreach (Delimiter::$list as $delimit) {
            $delimit = sodium_bin2hex($delimit);
            if (strpos($toDecode, $delimit) !== false) {
                $decode = explode($delimit, $toDecode);

                $nonce = sodium_hex2bin(base64_decode($decode[0]), "");
                $cipher = sodium_hex2bin(base64_decode($decode[1]), "");

                $decipher = sodium_crypto_secretbox_open($cipher, $nonce, $this->key);
                $returnValue = sodium_unpad($decipher, $this->block);
            }
        }
        return $returnValue;
    }

    /**
     * stringEncryption
     *
     * @return void
     */
    private function stringEncryption()
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $pad = sodium_pad($this->data, $this->block);
        $cipher = sodium_crypto_secretbox($pad, $nonce, $this->key);
        $delimiter = Delimiter::$list[rand(0, count(Delimiter::$list) - 1)];
        $encode =  base64_encode(base64_encode(sodium_bin2hex($nonce)) . sodium_bin2hex($delimiter) . base64_encode(sodium_bin2hex($cipher)));
        return $encode;
    }


    /**
     * fileDecryption
     *
     * @return void
     */
    private function fileDecryption()
    {
        $decrypted_file = $this->newLocation;

        $fd_in = fopen($this->data, 'rb');
        $fd_out = fopen($decrypted_file, 'wb');

        $header = fread($fd_in, SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_HEADERBYTES);

        $stream = sodium_crypto_secretstream_xchacha20poly1305_init_pull($header, $this->fileKey);
        do {
            $chunk = fread($fd_in, CHUNK_SIZE + SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_ABYTES);
            list($decrypted_chunk, $tag) = sodium_crypto_secretstream_xchacha20poly1305_pull($stream, $chunk);
            fwrite($fd_out, $decrypted_chunk);
        } while (!feof($fd_in) && $tag !== SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_FINAL);
        $ok = feof($fd_in);

        fclose($fd_out);
        fclose($fd_in);

        if (!$ok) {
            die('Invalid/corrupted input');
        }
        return $decrypted_file;
    }

    /**
     * fileEncryption
     *
     * @return void
     */
    private function fileEncryption()
    {
        $input_file = $this->data;
        $encrypted_file = $this->newLocation;
        $chunk_size = CHUNK_SIZE;

        $fd_in = fopen($input_file, 'rb');
        $fd_out = fopen($encrypted_file, 'wb');

        list($stream, $header) = sodium_crypto_secretstream_xchacha20poly1305_init_push($this->fileKey);
        fwrite($fd_out, $header);

        $tag = SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_MESSAGE;
        do {
            $chunk = fread($fd_in, $chunk_size);
            if (feof($fd_in)) {
                $tag = SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_FINAL;
            }
            $encrypted_chunk = sodium_crypto_secretstream_xchacha20poly1305_push($stream, $chunk, '', $tag);
            fwrite($fd_out, $encrypted_chunk);
        } while ($tag !== SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_FINAL);

        fclose($fd_out);
        fclose($fd_in);
        return $encrypted_file;
    }

    /**
     * getEncoded
     *
     * @return void
     */
    public function getEncrypted()
    {
        if ($this->dataType == DataType::FILE)
            return $this->newLocation;
        else
            return $this->encode;
    }

    /**
     * getDecoded
     *
     * @return void
     */
    public function getDecrypted()
    {
        if ($this->dataType == DataType::FILE)
            return $this->newLocation;
        else
            return $this->decode;
    }
}
