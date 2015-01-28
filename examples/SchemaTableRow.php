<?php

namespace PHPerge\Examples;

/**
 * @PHPerge\TableRow
 * @PHPerge\Description("Строка таблицы")
 */
class SchemaTableRow {

    /**
     *
     * @var
     * @PHPerge\TableColumn("type")
     */
    protected $type;

    /**
     *
     * @var
     * @PHPerge\TableColumn("name")
     */
    protected $name;

    /**
     *
     * @var
     * @PHPerge\TableColumn("description")
     */
    protected $description;

    /**
     *
     * @var
     * @PHPerge\TableColumn("values")
     */
    protected $values;
}