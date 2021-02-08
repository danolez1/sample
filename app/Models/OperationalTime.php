<?php

use danolez\lib\DB\Model;

class OperationalTime
{
    private $day;
    private $open;
    private $close;
    private $breakStart;
    private $breakEnd;

    public function __construct()
    {
        # code...
    }

    public function properties($display = false): array
    {
        $return = array();
        $object = get_object_vars($this);
        $return[Model::KEYS] = array_keys($object);
        $return[Model::VALUES] = array_values($object);
        if (!$display)
            return $return;
        else return $object;
    }
    /**
     * Get the value of day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set the value of day
     *
     * @return  self
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get the value of open
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set the value of open
     *
     * @return  self
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get the value of close
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * Set the value of close
     *
     * @return  self
     */
    public function setClose($close)
    {
        $this->close = $close;

        return $this;
    }

    /**
     * Get the value of breakStart
     */
    public function getBreakStart()
    {
        return $this->breakStart;
    }

    /**
     * Set the value of breakStart
     *
     * @return  self
     */
    public function setBreakStart($breakStart)
    {
        $this->breakStart = $breakStart;

        return $this;
    }

    /**
     * Get the value of breakEnd
     */
    public function getBreakEnd()
    {
        return $this->breakEnd;
    }

    /**
     * Set the value of breakEnd
     *
     * @return  self
     */
    public function setBreakEnd($breakEnd)
    {
        $this->breakEnd = $breakEnd;

        return $this;
    }
}
