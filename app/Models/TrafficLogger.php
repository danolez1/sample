<?php

use danolez\lib\DB\Condition;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use danolez\lib\Security\Encoding;

class TrafficLogger extends Model
{
    private $sn;
    private $session;
    private $count;
    private $time;
    private $url;
    private $pagesViewed;
    private $log;

    const KEY_ENCODE_ITERTATION = -1;
    const VALUE_ENCODE_ITERTATION = 2;

    public function __construct()
    {
        parent::__construct();
    }


    protected function setTableName()
    {
        $this->tableName = Credential::TRAFFIC_TBL;
    }
    protected function setDBName()
    {
        $this->dbName = Credential::SHOP_DB;
    }

    public function log()
    {
        $return = array();
        $obj = $this->object();
        $stmt = $this->table->insert($obj[parent::PROPERTIES], $obj[parent::VALUES]);
        $return[parent::RESULT] = (bool) $stmt->affected_rows;
        return json_encode($return);
    }

    public function update()
    {
        $return = array();
        $log = $this->get($this->session);
        $log = count($log) > 0 ? $log[count($log) == 0 ? 0 : count($log) - 1] : null;
        if (is_null($log)) {
            return  $this->log();
        } else {
            $time = $log->getTime();
            $isToday =   date('Ymd') == date('Ymd', intval($time));
            if ($isToday) {
                $this->time = $time;
                $this->setCount(intval($log->getCount()) + 1);
                $this->sn = intval($log->getSn());
                $obj = $this->object();
                $stmt = $this->table->update($obj[parent::PROPERTIES], $obj[parent::VALUES], array(TrafficLoggerColumn::SN => $log->getSn()));
                $return[parent::RESULT] = (bool) $stmt->affected_rows;
            } else {
                $this->count = 1;
                $this->pagesViewed = null;
                return  $this->log();
            }
        }
        return json_encode($return);
    }

    public function get($session = null)
    {
        $traffics = [];
        if ($session == null)
            $query = (array) $this->table->get();
        else
            $query = (array) $this->table->get(null, Condition::WHERE, array(TrafficLoggerColumn::SESSION => $session));
        foreach ($query as $traffic) {
            $traffics[] = $this->setData($traffic);
        }
        return $traffics;
    }

    public function properties($display = false): array
    {
        $return = array();
        $object = get_object_vars($this);
        $return[parent::KEYS] = array_keys($object);
        $return[parent::VALUES] = array_values($object);
        if (!$display)
            return $return;
        else return $object;
    }

    protected function setData($data)
    {
        if ($data == null) return new TrafficLogger();
        $reflect = new ReflectionClass($this);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = json_decode(json_encode($data, JSON_FORCE_OBJECT));
        $obj = new TrafficLogger();
        foreach (array_values($properties) as $key) {
            $encKey = $key->name;
            $obj->{$encKey} =  ($data->{$encKey});
        }
        return $obj;
    }

    protected function object($upload = true) //: array
    {
        $return  = array();
        $reflect = new ReflectionClass($this);
        $object = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $return[parent::PROPERTIES] = $this->encode(array_values($object));
        $object = array();
        foreach ($return[parent::PROPERTIES] as $ppt => $enc) {
            $object[$enc] = $this->properties(true)[$ppt];
        }
        $return[parent::VALUES] = $this->encrypt($object);
        if ($upload) {
            $return[parent::PROPERTIES] = array_values($return[parent::PROPERTIES]);
            return $return;
        } else {
            return $this->encrypt($object, true);
        }
    }
    protected function encode($data)
    {
        if (is_array($data)) {
            $temp  = array();
            foreach ($data as $key) {
                $temp[$key->name] = $key->name;
            }
            return $temp;
        } else {
            return Encoding::encode($data, self::KEY_ENCODE_ITERTATION);
        }
    }
    protected function encrypt($data, $assoc = false)
    {

        if (is_array($data)) {
            $temp  = array();
            foreach ($data as $key => $value) {
                $assoc ? $temp[$key] = ($value) : $temp[] = ($value);
            }
            return $temp;
        } else {
            return Credential::encrypt($data); //,$key
        }
    }

    /**
     * Get the value of session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the value of session
     *
     * @return  self
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get the value of count
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the value of count
     *
     * @return  self
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get the value of time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
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
     * Get the value of pagesViewed
     */
    public function getPagesViewed()
    {
        return $this->pagesViewed;
    }

    /**
     * Set the value of pagesViewed
     *
     * @return  self
     */
    public function setPagesViewed($pagesViewed)
    {
        $this->pagesViewed = $pagesViewed;

        return $this;
    }

    /**
     * Get the value of log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set the value of log
     *
     * @return  self
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get the value of sn
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set the value of sn
     *
     * @return  self
     */
    public function setSn($sn)
    {
        $this->sn = $sn;

        return $this;
    }
}
