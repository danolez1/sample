<?php

namespace danolez\lib\DB;

use danolez\lib\DBAction;
use danolez\lib\DB\Attribute;
use danolez\lib\DB\Condition;
use danolez\lib\DB\Database;
use danolez\lib\DB\Location;
use danolez\lib\DB\SQL;
use Exception;

class Table
{
    protected $db;
    protected $name;
    protected $rows, $columns;
    private $existence;
    private $sql;
    private $nColumn = array();
    private $dColumn = array();
    private $mColumn = array();

    const INSUFFICIENT_CONDITION = "Condition array must have lenght of Parameter array -1";


    /**
     * Initialize Table Class
     * @param string Table Name
     * @param Database instance
     */
    public function __construct(string $name, Database $db)
    {
        $this->name = $name;
        $this->db = $db;
        $this->sql = new SQL($db);
        // $this->isExist();
        return $this;
    }

    public function alter()
    {
        $temp = $this->sql::compile(Action::ALTER, Location::TABLE,  $this->name);
        $return = null;

        if (count($this->nColumn) > 0) {
            foreach ($this->nColumn as $column) {
                $sql = $this->sql::compile($temp, Action::ADD, Location::COLUMN,  $column);
                $return =  $this->sql->query($sql);
            }
            $this->nColumn = array();
        }

        if (count($this->dColumn) > 0) {
            foreach ($this->dColumn as $column) {
                $sql = $this->sql::compile($temp, Action::DROP, Location::COLUMN,  $column);
                $return =  $this->sql->query($sql);
            }
            $this->dColumn = array();
        }

        if (count($this->mColumn) > 0) {
            foreach ($this->mColumn as $column) {
                $sql = $this->sql::compile($temp, Action::MODIFY, Location::COLUMN,  $column);
                $return = $this->sql->query($sql);
            }
            $this->mColumn = array();
        }
        return $return;
    }



    /**
     * create
     * @return void
     */
    public function create()
    {
        $sql = $this->sql::compile(Action::CREATE, Location::TABLE,  $this->name, "(", implode(", ", $this->nColumn), ")");
        $this->nColumn = array();
        return $this->sql->query($sql); // or $this->sql->sql($sql);$this->sql->query();
    }

    /**
     * Insert into table
     * @param array column names
     * @param array values
     * If @param 2  is empty then it inserts into table according to the column 
     */

    public function insert(array $column, array $param = null)
    {
        $sql = $this->sql::compile(Action::INSERT, Location::INTO, $this->name);
        if ($param ==  null) {
            $param  = $column;
        } else {
            $sql .= "(`" . implode("`, `", $column) . "`)";
        }
        $sql .=  " VALUES (";
        $qm = str_repeat("?", count($column));
        $qm = str_split($qm, 1);
        $sql .= implode(", ", $qm) . ")";
        return $this->sql->query($sql, $param);
    }

    /**
     * Update table
     * @param array column names
     * @param array values
     * @param array condition paramaters (assoc array)
     */
    public function update(array $column, array $param, array $condition)
    {
        $keys = array_keys($condition);
        $sql = $this->sql::compile(
            Action::UPDATE,
            $this->name,
            Attribute::SET,
            "`" . implode("` = ?, `", $column) . "` = ?",
            Condition::WHERE,
            "`" . implode("` = ?, `", $keys) . "` = ?"
        );

        foreach ($keys as $k) {
            array_push($param, $condition[$k]);
        }
        return $this->sql->query($sql, $param);
    }

    public function addColumn(string $name, ...$dataType)
    {
        $str = "`" . $name . "` ";
        foreach ($dataType as $var) {
            $str .= $var . " ";
        }
        $this->nColumn[] = $str;
        return $this;
    }

    public function dropColumn(string $name)
    {
        $this->dColumn[] = $name;
        return $this;
    }

    public function modifyColumn(string $name, ...$dataType)
    {
        $str = "`" . $name . "` ";
        foreach ($dataType as $var) {
            $str .= $var . " ";
        }
        $this->mColumn[] = $str;
        return $this;
    }

    /**
     * @param $column array(columns to select)
     * @param $statement //WHERE/WHERE NOT
     * @param $param array()
     * @param $adhesive
     * @param $order /ORDER BY columnName =/LIKE %?% OR/AND
     * @param $limits
     */
    public function get(array $column = null, string $statement = "", array $param = null, array $adhesive = array(), $order = "", $offset = null, $limit = null)
    {
        if ($column == null) {
            $coln = "*";
        } else {
            $coln = "`" . implode("`, `", $column) . "`";
        }

        $keys = "";
        if ($param != null) {
            if (count($param) - 1 > count($adhesive)) {
                throw new Exception(self::INSUFFICIENT_CONDITION);
            }
            $tmpkey = array_keys($param);
            for ($i = 0; $i < count($param); $i++) {
                if ($i == count($param) - 1)
                    $keys .= "`" . $tmpkey[$i] . "`=? ";
                else
                    $keys .= "`" . $tmpkey[$i] . "`=? " . $adhesive[$i] . " ";
            }
        }

        $lim = (!is_null($offset) && !is_null($limit)) ? $offset . "," . $limit : "";
        $lim = (!is_null($offset) && is_null($limit)) ? $offset : $lim;
        $lim = (is_null($offset) && !is_null($limit)) ? $limit : $lim;
        $lim = ($lim !== "") ? Condition::LIMIT . " " . $lim : "";

        $oparenthesis = count($adhesive) > 1 ? "(" : "";
        $cparenthesis = count($adhesive) > 1 ? ")" : "";

        $sql = $this->sql::compile(
            Action::SELECT,
            $coln,
            Condition::FROM,
            $this->name,
            $statement,
            $oparenthesis . $keys . $cparenthesis,
            $order,
            $lim
        );

        if ($param == null) {
            return json_decode($this->sql->fetch($sql))->response;
        } else {
            $paramRef = array_values($param);
            return json_decode($this->sql->fetch($sql, $paramRef))->response;
        }
    }

    public function remove(array $param, array $adhesive = array())
    {
        $keys = "";
        if (count($param) - 1 > count($adhesive)) {
            throw new Exception(self::INSUFFICIENT_CONDITION);
        }
        $tmpkey = array_keys($param);
        for ($i = 0; $i < count($param); $i++) {
            if ($i == count($param) - 1)
                $keys .= "`" . $tmpkey[$i] . "`=? ";
            else
                $keys .= "`" . $tmpkey[$i] . "`=? " . $adhesive[$i] . " ";
        }
        $paramRef = array_values($param);
        $sql = $this->sql::compile(Action::DELETE, Condition::FROM, $this->name, Condition::WHERE, $keys);
        return $this->sql->query($sql, $paramRef);
    }

    public function delete()
    {
        $sql = $this->sql::compile(Action::DROP,  Location::TABLE,  $this->name);
        return $this->sql->query($sql);
    }

    public function getName()
    {
        return $this->name;
    }

    public function isExist()
    {
        $sql = $this->sql::compile(Action::SHOW, Attribute::TABLES, Condition::FROM, $this->db->getName(), Condition::LIKE, $this->name);
        $this->existence =  ($this->sql->query($sql));
        if (!$this->existence) {
            throw new Exception("Table doesn't exist. Call create(array \$var) method to create table");
        }
        return $this->existence;
    }

    public function getLastSN(): int
    {
        $sql = $this->sql::compile(
            Action::SELECT,
            Attribute::AUTO_INCREMENT,
            Condition::AS,
            Attribute::TOTAL,
            Condition::FROM,
            Attribute::set('INFORMATION_SCHEMA.TABLES'),
            Condition::WHERE,
            Attribute::set('TABLE_SCHEMA = ? AND'),
            Attribute::set('TABLE_NAME = ? ')
        );
        $param = array($this->db->getName(), $this->name);
        return  is_null(json_decode($this->sql->fetch($sql, $param))->response) ?
            0 : json_decode($this->sql->fetch($sql, $param))->response[0]->TOTAL;
    }

    public function getRowCount(): int
    {
        $sql = $this->sql::compile(Action::SELECT, Action::count("*"), Condition::AS, Attribute::TOTAL, Condition::FROM, $this->name);
        return json_decode($this->sql->fetch($sql))->response[0]->TOTAL;
    }

    /**
     * Close Database connection
     */
    public function __destruct()
    {
        try {
            if (!is_null($this->db))
                if (!is_null($this->db->DB()->connect_error))
                    $this->db->DB()->close();
        } catch (\Exception $e) {
        }
    }
}
