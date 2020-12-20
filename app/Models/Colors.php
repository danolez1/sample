<?php
class  Colors
{
    private $mainColor, $colorAccent;


    /**
     * Get the value of mainColor
     */
    public function getMainColor()
    {
        return $this->mainColor;
    }

    /**
     * Set the value of mainColor
     *
     * @return  self
     */
    public function setMainColor($mainColor)
    {
        $this->mainColor = $mainColor;

        return $this;
    }

    /**
     * Get the value of colorAccent
     */
    public function getColorAccent()
    {
        return $this->colorAccent;
    }

    /**
     * Set the value of colorAccent
     *
     * @return  self
     */
    public function setColorAccent($colorAccent)
    {
        $this->colorAccent = $colorAccent;

        return $this;
    }
}
