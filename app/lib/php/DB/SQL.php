<?php

namespace danolez\lib\DB;

use danolez\lib\DB\Action;
use danolez\lib\DB\Attribute;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Database ;
use danolez\lib\DB\Table;
use Exception;

class SQL
{
    private $DB;
    protected $table;
    protected $params = array();
    protected $return = array();
    protected $sql;
    public $count;
    public $errorCode;

    /**
     * __construct
     *
     * @param  mixed $DB
     * @return void
     */
    public function __construct(Database $DB = null)
    {
        if ($DB == null) {
            $this->DB = new Database(Credential::SHOP_DB);
        } else {
            $this->DB = $DB;
        }
    }

    /**
     * getInstance
     *
     * @return void
     */
    public static function getInstance()
    {
        return new SQL();
    }

    /**
     * setTable
     *
     * @param  mixed $name
     * @param  mixed $DB
     * @return void
     */
    public function setTable(String $name, $DB)
    {
        $this->table = new Table($name, $DB);
    }

    /**
     * getTable
     *
     * @return void
     */
    public function getTable()
    {
        return $this->table;
    }
    /**
     * setDB
     *
     * @param  mixed $name
     * @return void
     */
    public function setDB(String $name)
    {
        $this->DBNAME = $name;
        $this->DB = new DB\Database($this->DBNAME);
    }
    /**
     * getDB
     *
     * @return void
     */
    public function getDB()
    {
        return $this->DB;
    }

    /**
     * query
     *
     * @param  mixed $sql
     * @param  mixed $params
     * @param bool $fetch 
     * @return void
     */
    public function query(string $sql = null, array &$params = null, $fectch = false)
    {
        if ($sql == null)
            $sql = $this->sql;
        if ($params == null)
            $params = $this->params;

        $params = $this->purify($params);
        $sql .= ";";

        $test = strtolower($sql);
        $delTable = (strpos($test, "drop table") !== false);
        $delDatabase = (strpos($test, "drop database") !== false);

        if ($delTable || $delDatabase) {
            throw new Exception("Unauthorized Action");
        } else {
            try {
                $stmt = $this->DB->DB()->prepare($sql);
                if (count($params) > 0)
                    $stmt->bind_param($this->getParamsDataType($params), ...$params); //call_user_func_array(array($stmt,"bind_param"),$this->param);
                $stmt->execute();
                if (!$fectch)
                    $stmt->store_result();
                return $stmt;
                //return $this->DB->DB()->query($sql);
            } catch (Exception $e) {
                throw new Exception($this->DB->DB()->error);
                // var_dump($this->DB->DB()->error);
            }
        }
    }

    /**
     * fetch
     *
     * @param  mixed $sql
     * @param  mixed $params
     * @return void
     */
    public function fetch(string $sql = null, array &$params = null)
    {
        $stmt = $this->query($sql, $params, true);
        $result = $stmt->get_result();
        $response = $json = array();
        if ($result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $response[$key] = $value;
                }
                array_push($json, $response);
            }
            return json_encode(array(Attribute::RESPONSE => $json));
        } else {
            return json_encode(array(Attribute::RESPONSE => null));
        }
    }

    public function count(string $sql = null, array $params = null)
    {
        return (int)  $this->query($sql, $params)->num_rows;
    }

    /**
     * purify
     *
     * @param  mixed $params
     * @return array
     */
    protected function purify(array $params)
    {
        $return = array();
        foreach ($params as $p) {
            if (!is_array($p)) {
                $p = trim($p);
                // $p = str_replace("\\", "", $p);
                // $p = str_replace("'", " ", $p);
                // $p = stripslashes($p);
                // $p = stripcslashes($p);
                $p = strip_tags($p);
                $p = htmlentities($p);
                $p = $this->DB->DB()->real_escape_string($p);
            } else {
                $this->purify($p);
            }
            $return[] = $p;
        }
        return $return;
    }

    /**
     * getParamsDataType
     *
     * @param  mixed $params
     * @return void
     */
    protected function getParamsDataType($params)
    {
        $types = "";
        foreach ($params as $key) {
            if (is_int($key)) $types .= "i";
            elseif (is_string($key)) $types .= "s";
            elseif (is_float($key)) $types .= "f";
            else $types .= "b";
        }
        return $types;
    }

    /** 
     * var 1 Action::
     * var 2 Location::
     * var 3 $name
     */
    public static function compile(...$variable)
    {
        $sql = "";
        foreach ($variable as $var) {
            $sql .= $var . " ";
        }
        return $sql;
    }

    /**
     * sql
     *
     * @param  mixed $sql
     * @return void
     */
    public function sql(string $sql)
    {
        $this->sql = $sql;
    }

    /**
     * params
     *
     * @param  mixed $params
     * @return void
     */
    public function params($params)
    {
        $this->params = $params;
    }

    /**
     * Close Database connection
     */
    public function __destruct()
    {
        // $this->DB->DB()->close();
    }
}
