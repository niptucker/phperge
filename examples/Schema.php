<?php

namespace PHPerge\Examples;

/**
 * Схема данных
 *
 * @PHPerge\Id("Schema")
 * @PHPerge\Description("Схема данных")
 */
class Schema implements \PHPerge\Template {

    /**
     * Название шаблона
     *
     * @var String
     *
     * @PHPerge\Description("Название шаблона")
     * @PHPerge\String("templateName")
     */
    protected $templateName;

    /**
     * Таблица полей шаблона
     *
     * @var SchemaTable
     *
     * @PHPerge\Table(id="Table", rowClass="SchemaTableRow")
     */
    protected $structure;

}