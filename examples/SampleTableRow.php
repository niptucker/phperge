<?php

namespace PHPerge\Examples;

use PHPerge\Annotations as PHPerge;

/**
 * @PHPerge\TableRow
 * @PHPerge\Description("Строка таблицы")
 */
class SampleTableRow {

    /**
     *
     * @var String
     * @PHPerge\TableColumn("cellval1")
     */
    protected $cellval1;

    /**
     *
     * @var String
     * @PHPerge\TableColumn("cellval2")
     */
    protected $cellval2;

    /**
     *
     * @var String
     * @PHPerge\TableColumn("cellval3")
     */
    protected $cellval3;

    /**
     *
     * @var String
     * @PHPerge\TableColumn("cellval4")
     */
    protected $cellval4;

    /**
     * Gets the value of cellval1.
     *
     * @return String
     */
    public function getCellval1()
    {
        return $this->cellval1;
    }

    /**
     * Sets the value of cellval1.
     *
     * @param String $cellval1 the cellval1
     *
     * @return self
     */
    public function setCellval1($cellval1)
    {
        $this->cellval1 = $cellval1;

        return $this;
    }

    /**
     * Gets the value of cellval2.
     *
     * @return String
     */
    public function getCellval2()
    {
        return $this->cellval2;
    }

    /**
     * Sets the value of cellval2.
     *
     * @param String $cellval2 the cellval2
     *
     * @return self
     */
    public function setCellval2($cellval2)
    {
        $this->cellval2 = $cellval2;

        return $this;
    }

    /**
     * Gets the value of cellval3.
     *
     * @return String
     */
    public function getCellval3()
    {
        return $this->cellval3;
    }

    /**
     * Sets the value of cellval3.
     *
     * @param String $cellval3 the cellval3
     *
     * @return self
     */
    public function setCellval3($cellval3)
    {
        $this->cellval3 = $cellval3;

        return $this;
    }

    /**
     * Gets the value of cellval4.
     *
     * @return String
     */
    public function getCellval4()
    {
        return $this->cellval4;
    }

    /**
     * Sets the value of cellval4.
     *
     * @param String $cellval4 the cellval4
     *
     * @return self
     */
    public function setCellval4($cellval4)
    {
        $this->cellval4 = $cellval4;

        return $this;
    }
}