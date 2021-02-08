<?php

namespace danolez\lib\Res;

use danolez\lib\Res\Ini;
use danolez\lib\Res\Server;

class Curl
{
    private $url;
    private $_curl;
    private $params = array();
    private $header;
    private $ssl;

    const ERROR = "error";
    const ERRNO = "errno";
    const Encoding = "gzip";
    const Header = array(
        'Accept: text/plain; q=0.5, text/html, text/json, text/x-dvi; q=0.8, text/x-c',
        'Connection: Keep-Alive',
        'Accept-Encoding: compress, gzip',
        'Allow: GET, POST',
        'Cache-control: no-cache',
        'Content-type: application/x-www-form-urlencoded;charset=UTF-8'
    );

    public function __construct($url = null)
    {
        $this->header = self::Header;
        if ($this->isUrl($url))
            $this->setUrl($url);
    }

    public function addParam($key, $value)
    {
        $params[$key] = $value;
    }


    public function useFile()
    {
        Ini::file();
        $url = $this->url;
        if (count($this->params) > 0)
            $url .= $this->processGetParam();

        return file_get_contents($url);
    }

    public function get($timeout = 14)
    {
        $url = $this->url;
        if (count($this->params) > 0)
            $url .= $this->processGetParam();

        curl_setopt_array($this->_curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_AUTOREFERER => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => $this->header,
            CURLOPT_ENCODING => self::Encoding,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_SSLVERSION => 3,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_USERAGENT => Server::get(Server::HTTP_USER_AGENT)

        ]);

        // if ($ssl) {
        //     //support https
        //     $options[CURLOPT_SSL_VERIFYHOST] = false;
        //     $options[CURLOPT_SSL_VERIFYPEER] = false;
        // curl_setopt($tuCurl, CURLOPT_SSLVERSION, 3);
        // }

        $result = curl_exec($this->_curl);
        if (!$result) {
            $result[self::ERROR]  = curl_error($this->_curl);
            $result[self::ERRNO] = curl_errno($this->_curl);
            $result = json_encode($result);
        }

        return $result;
    }

    public function post($timeout = 14)
    {
        curl_setopt_array($this->_curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_AUTOREFERER => 0,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => $this->header,
            CURLOPT_ENCODING => self::Encoding,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_USERAGENT => Server::get(Server::HTTP_USER_AGENT),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->params
        ]);
        $result = curl_exec($this->_curl);
        if (!$result) {
            $result[self::ERROR]  = curl_error($this->_curl);
            $result[self::ERRNO] = curl_errno($this->_curl);
            $result = json_encode($result);
        }

        return $result;
    }

    public function processGetParam()
    {
        $result  = "?";
        foreach ($this->params as $key => $value) {
            $result .= $key . "=" . $value . "&";
        }
        return $result;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->_curl = curl_init();
        $this->ssl = stripos($url, 'https://') === 0 ? true : false;
        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function isUrl(string $url)
    {
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url))
            return false;
        else return true;
    }

    /**
     * Get the value of header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set the value of header
     *
     * @return  self
     */
    public function setHeader(array $header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get the value of params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set the value of params
     *
     * @return  self
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }
}
