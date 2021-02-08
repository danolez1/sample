<?php

namespace PrintNode;

/**
 * Printer
 *
 * Object representing a Printer in PrintNode API
 *
 * @property-read int $id
 * @property-read Computer $computer
 * @property-read string $name
 * @property-read string $description
 * @property-read object $capabilities
 * @property-read boolean $default
 * @property-read DateTime $createTimestamp
 * @property-read string $state
 */
class Printer extends Entity
{
    protected $id;
    protected $computer;
    protected $name;
    protected $description;
    protected $capabilities;
    protected $default;
    protected $createTimestamp;
    protected $state;

    public function foreignKeyEntityMap()
    {
        return array(
            'computer' => 'PrintNode\Computer'
        );
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of computer
     */ 
    public function getComputer()
    {
        return $this->computer;
    }

    /**
     * Set the value of computer
     *
     * @return  self
     */ 
    public function setComputer($computer)
    {
        $this->computer = $computer;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of capabilities
     */ 
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * Set the value of capabilities
     *
     * @return  self
     */ 
    public function setCapabilities($capabilities)
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    /**
     * Get the value of default
     */ 
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set the value of default
     *
     * @return  self
     */ 
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get the value of createTimestamp
     */ 
    public function getCreateTimestamp()
    {
        return $this->createTimestamp;
    }

    /**
     * Set the value of createTimestamp
     *
     * @return  self
     */ 
    public function setCreateTimestamp($createTimestamp)
    {
        $this->createTimestamp = $createTimestamp;

        return $this;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }
}
