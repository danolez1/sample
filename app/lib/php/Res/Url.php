<?php

namespace danolez\lib\Res;

class Url
{
    private $host;
    private $path;
    private $query;
    private $user;
    private $password;
    private $hashTag;
    private $protocol;
    private $port;
    private $url;

    //const ERR_NOT_URL

    public function __construct(string $url)
    {
        $this->setUrl($url);
        $this->read();
        return $this;
    }

    private function read()
    {
        $this->setHost(parse_url($this->getUrl(), PHP_URL_HOST));
        $this->setUser(parse_url($this->getUrl(), PHP_URL_USER));
        $this->setPassword(parse_url($this->getUrl(), PHP_URL_PASS));
        $this->setHashTag(parse_url($this->getUrl(), PHP_URL_FRAGMENT));
        $this->setProtocol(parse_url($this->getUrl(), PHP_URL_SCHEME));
        $this->setPort(parse_url($this->getUrl(), PHP_URL_PORT));
        $this->setPath(parse_url($this->getUrl(), PHP_URL_PATH));
        $this->setQuery(parse_url($this->getUrl(), PHP_URL_QUERY));
    }

    public function isUrl(string $url)
    {
        $url = $this->purify($url);
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url))
            return false;
        else return true;
    }


    /**
     * purify
     * 
     * @param  mixed $params
     * @return string
     */
    protected function purify(string $p = null)
    {
        $p = trim($p);
        $p = stripslashes($p);
        $p = stripcslashes($p);
        $p = strip_tags($p);
        $p = htmlentities($p);
        return $p;
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
        $this->read();
        return $this;
    }

    /**
     * Get the value of query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the value of query
     *
     * @return  self
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the value of host
     *
     * @return  self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the value of port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the value of port
     *
     * @return  self
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get the value of protocol
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Set the value of protocol
     *
     * @return  self
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of hashTag
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set the value of hashTag
     *
     * @return  self
     */
    public function setHashTag($hashTag)
    {
        $this->hashTag = $hashTag;

        return $this;
    }
}
