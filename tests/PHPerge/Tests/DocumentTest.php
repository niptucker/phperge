<?php

namespace PHPerge\Tests;

use PHPerge\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase {

    protected $fixture;
    protected $templateId;
    protected $connectionOptions;

    protected function setUp() {
        $this->templateId = "schema";
        $this->connectionOptions = array("url" => "http://example.com");

        $this->fixture = new Document($this->templateId, $this->connectionOptions);
    }

    public function testConstructor(){

        $this->assertEquals($this->templateId, $this->fixture->getTemplateId());
        $this->assertEquals($this->connectionOptions, $this->fixture->getConnectionOptions());

    }

    public function testBeans() {
        $newTemplateId = "template";
        $newConnectionOptions = array();

        $this->assertEquals($this->fixture->setTemplateId($newTemplateId)->getTemplateId(), $newTemplateId);
        $this->assertEquals($this->fixture->setConnectionOptions($newConnectionOptions)->getConnectionOptions(), $newConnectionOptions);

        $this->assertEquals($this->fixture->getPriority(), Document::PRIORITY_NORMAL);
        $this->assertEquals($this->fixture->setPriority(Document::PRIORITY_LOW)->getPriority(), Document::PRIORITY_LOW);
    }

    public function testFields() {

        $fields = array(
            "fieldInt"          => 10,
            "fieldFloat"        => 1.4e-2,
            "fieldString"       => "String",
            "fieldStringUtf"    => "Русская строка",
        );

        foreach ($fields as $fieldName => $fieldValue) {
            $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
        }

        $this->assertEquals($this->fixture->getFields(), $fields);

    }

    public function testTable() {
        $tableName = "STRUCTURE";
        $tableContent = array(
            array("TYPE"        => "Тип 1"
                , "NAME"        => "Имя 1"
                , "DESCRIPTION" => "Описание 1"
                , "VALUES"      => "Значения 1"),
            array("TYPE"        => "Тип два"
                , "NAME"        => "Имя два"
                , "DESCRIPTION" => "Описание два"
                , "VALUES"      => "Значения два"),
            array("TYPE"        => "Тип 3"
                , "NAME"        => "Имя 3"
                , "DESCRIPTION" => "Описание 3"
                , "VALUES"      => "Значения 3"),
        );

        $this->assertEquals($this->fixture->setTable($tableName, $tableContent)->getTable($tableName), $tableContent);
    }

}