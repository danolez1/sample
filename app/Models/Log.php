<?php

namespace Demae\Auth\Models\Shop;

use danolez\lib\Res\Server;

class Log
{
    private $url;
    private $escapeUrl;
    private $method;
    private $userAgent;
    private $ip;
    private $geoIp;
    private $timeStamp;

    public function __construct()
    {
        $this->setUrl(Server::get(Server::HTTP_HOST) . Server::get(Server::REQUEST_URI));
        $this->setEscapeUrl(htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8'));
        $this->setMethod(Server::get(Server::REQUEST_METHOD));
        $this->setUserAgent(Server::get(Server::HTTP_USER_AGENT));
        // $this->setIp(Server::getIP());
        // $this->setGeoIp(Server::geoIP());
        $this->setTimeStamp(time());
        return $this;
    }

    public function properties(): array
    {
        $return = array();
        return get_object_vars($this);
    }


    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of escapeUrl
     */
    public function getEscapeUrl()
    {
        return $this->escapeUrl;
    }

    /**
     * Set the value of escapeUrl
     *
     * @return  self
     */
    public function setEscapeUrl($escapeUrl)
    {
        $this->escapeUrl = $escapeUrl;

        return $this;
    }

    /**
     * Get the value of method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the value of method
     *
     * @return  self
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the value of userAgent
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set the value of userAgent
     *
     * @return  self
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get the value of ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the value of ip
     *
     * @return  self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get the value of geoIp
     */
    public function getGeoIp()
    {
        return $this->geoIp;
    }

    /**
     * Set the value of geoIp
     *
     * @return  self
     */
    public function setGeoIp($geoIp)
    {
        $this->geoIp = $geoIp;

        return $this;
    }

    /**
     * Get the value of timeStamp
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Set the value of timeStamp
     *
     * @return  self
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }
}
