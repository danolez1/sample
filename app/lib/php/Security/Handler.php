<?php

namespace danolez\lib\Security\Handler;

class Handler{
    private $data;
    private $key;
    private $nonce;

public function __construct()
{
  
}


    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of key
     */ 
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @return  self
     */ 
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the value of nonce
     */ 
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * Set the value of nonce
     *
     * @return  self
     */ 
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }
}