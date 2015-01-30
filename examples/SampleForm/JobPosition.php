<?php

namespace PHPerge\Examples\SampleForm;

use PHPerge\Annotations as PHPerge;

/**
 * @PHPerge\TableRow
 * @PHPerge\Description("Запись о предыдущем месте работы")
 */
class JobPosition {

    /**
     *
     * @var string
     * @PHPerge\TableColumn("when")
     */
    protected $when;

    /**
     *
     * @var string
     * @PHPerge\TableColumn("firm_name")
     */
    protected $firmName;

    /**
     *
     * @var string
     * @PHPerge\TableColumn("position")
     */
    protected $position;


    /**
     * Gets the value of when.
     *
     * @return string
     */
    public function getWhen()
    {
        return $this->when;
    }

    /**
     * Sets the value of when.
     *
     * @param string $when the when
     *
     * @return self
     */
    public function setWhen($when)
    {
        $this->when = $when;

        return $this;
    }

    /**
     * Gets the value of firmName.
     *
     * @return string
     */
    public function getFirmName()
    {
        return $this->firmName;
    }

    /**
     * Sets the value of firmName.
     *
     * @param string $firmName the firm name
     *
     * @return self
     */
    public function setFirmName($firmName)
    {
        $this->firmName = $firmName;

        return $this;
    }

    /**
     * Gets the value of position.
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the value of position.
     *
     * @param string $position the position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}