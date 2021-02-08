<?php

namespace danolez\lib\DB;

use danolez\lib\DB\Credential;
use danolez\lib\DB\Table;
use Exception;
use mysqli;

/**
 *
 * @property Table $table
 * @property DBBackup $backup*/

class Database
{
    protected  $connect;
    private $name;

    /**
     * Connect to Database
     * @param string Database Name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $SERVER_NAME = Credential::decrypt(Credential::SERVER_NAME3);
        $SERVER_PASSWORD = Credential::decrypt(Credential::SERVER_PASSWORD3);
        $SERVER_USERNAME = Credential::decrypt(Credential::SERVER_USERNAME3);
        $this->connect = new mysqli($SERVER_NAME, $SERVER_USERNAME, $SERVER_PASSWORD);

        if ($this->connect->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->connect->connect_error;
            exit();
        } else {
            if (!$this->connect->select_db($name)) {
                //throw new Exception("Database doesn't exist.");
                $sql = "CREATE DATABASE IF NOT EXISTS " . $name . ";";
                $this->connect->query($sql);
                $this->connect->select_db($name);
            }
            $increase = "show global variables like '%connections%'";
            // var_dump($this->connect->query("SET GLOBAL max_user_connections=1000000;"));
        }
        return $this->connect;
    }

    /**
     * returns DB connection link  
     */
    public function DB()
    {
        return $this->connect;
    }

    /**
     * Create instance of Table in initialized database 
     * @param string name of table 
     */

    public function Table(string $table)
    {
        return new Table($table, $this);
    }

    /**
     * returns the name of initialized database  
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * A differential back up only backs up 
     * the parts of the database that have changed since 
     * the last full database backup. 
     * @param string path
     * @param boolean differential = false(default)  
     */
    public function backUp(string $path, bool $differential = false)
    {
        //   $sql = "BACKUP DATABASE ".$this->name;
        //   $sql .= " TO DISK = '".$path.".bak' ";
        //   if($differential)
        //   $sql .= "WITH DIFFERENTIAL;";
        //  return $sql;//this->DB()->query($sql);
    }

    public function restore()
    {
        # code...
    }

    /**
     * Close Database connection
     */
    public function __destruct()
    {
        if (!is_null($this->connect))
            if (!is_null($this->DB()->connect_error))
                $this->DB()->close();
    }
}
