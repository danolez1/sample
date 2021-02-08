<?php

namespace danolez\lib\DB;

abstract class Router
{

    protected $result;
    protected $params;
    protected $path;
    protected $query;

    const TABLE = "table";
    const DB = "dataBase";
    const TB_NAME = "tableName";
    const API = "api";
    const SUCCESS = "success";

    public function __construct($query)
    {
        $this->setQuery($query);
        $url_components = parse_url($query);
        $this->setPath($url_components['path']);
        if (isset($url_components['query']))
            parse_str(($url_components['query']), $this->params);
    }

    protected function getMethod($query)
    {
    }

    protected function header()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }


    protected function footer($code)
    {
        http_response_code($code);
        return json_encode($this->result, JSON_FORCE_OBJECT, JSON_PRETTY_PRINT);
    }


    /**
     * Get the value of api
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * Get the value of api
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setParams($params)
    {
        $this->data = $params;
        return $this;
    }
    /**
     * Get the value of data
     */
    public function getParams()
    {
        return $this->params;
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
}
