<?php

namespace PHPerge\Tests;

use PHPerge\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase {

    protected $fixture;
    protected $templateId;
    protected $connectionOptions;

    protected function setUp() {
        $this->templateId = "schema";
        $this->templateDescription = "Document schema description";
        $this->connectionOptions = array("url" => "http://example.com");

        $this->fixture = new Document($this->templateId, $this->connectionOptions);
    }

    public function testConstructor(){

        $this->assertEquals($this->templateId, $this->fixture->getTemplateId());
        $this->assertEquals($this->connectionOptions, $this->fixture->getConnectionOptions());

    }

    public function testTemplateDescription() {
        $this->assertEquals($this->templateDescription, $this->fixture->setTemplateDescription($this->templateDescription)->getTemplateDescription());
    }

    public function testBeans() {
        $newTemplateId = "template";
        $newTemplateDescription = "New template description";
        $newConnectionOptions = array();

        $this->assertEquals($this->fixture->setTemplateId($newTemplateId)->getTemplateId(), $newTemplateId);
        $this->assertEquals($this->fixture->setTemplateDescription($newTemplateDescription)->getTemplateDescription(), $newTemplateDescription);
        $this->assertEquals($this->fixture->setConnectionOptions($newConnectionOptions)->getConnectionOptions(), $newConnectionOptions);

        $this->assertEquals($this->fixture->getPriority(), Document::PRIORITY_NORMAL);
        $this->assertEquals($this->fixture->setPriority(Document::PRIORITY_LOW)->getPriority(), Document::PRIORITY_LOW);
    }

    public function testIntField() {
        $fieldName = "int";
        $fieldValue = 42;

        $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
    }

    public function testFloatField() {
        $fieldName = "float";
        $fieldValue = 36.6;

        $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
    }

    public function testStringField() {
        $fieldName = "string";
        $fieldValue = "Just a string";

        $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
    }

    public function testMultibyteStringField() {
        $fieldName = "mbstring";
        $fieldValue = "Русская строка";

        $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
    }

    public function testEnumField() {
        $fieldName = "enum";
        $fieldValue = "1";

        $this->assertEquals($this->fixture->setEnum($fieldName, $fieldValue)->getEnum($fieldName), $fieldValue);
    }

    public function testUnsetFields() {
        $fieldName = "newfield";
        $fieldValue = "Some string";

        $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);

        $this->assertNotEmpty($this->fixture->getFields());

        $this->assertEmpty($this->fixture->unsetFields()->getFields());
    }

    public function testMultipleFields() {
        $this->fixture->unsetFields();

        $fields = array(
            "fieldInt"          => 10,
            "fieldFloat"        => 1.4e-2,
            "fieldString"       => "String",
            "fieldStringUtf"    => "Русская строка",
        );

        foreach ($fields as $fieldName => $fieldValue) {
            $this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
        }
        $this->assertEquals(count($this->fixture->getFields()), count($fields));

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

    public function testImage() {
        $imageName = "PIC";
        $imageContent = base64_encode(uniqid());

        $this->assertEquals($this->fixture->setImage($imageName, $imageContent)->getImage($imageName), $imageContent);
    }


    public function testFieldDescription() {
        $fieldName = "descriptionfield";
        $fieldDescription = "Description of a field";

        $this->assertEquals($this->fixture->setFieldDescription($fieldName, $fieldDescription)->getFieldDescription($fieldName), $fieldDescription);
    }

    public function testEnumDescription() {
        $fieldName = "descriptionenum";
        $fieldDescription = "Description of a enum";

        $this->assertEquals($this->fixture->setEnumDescription($fieldName, $fieldDescription)->getEnumDescription($fieldName), $fieldDescription);
    }

    public function testTableDescription() {
        $tableName = "descriptiontable";
        $tableDescription = "Description of a table";

        $this->assertEquals($this->fixture->setTableDescription($tableName, $tableDescription)->getTableDescription($tableName), $tableDescription);
    }

    public function testImageDescription() {
        $imageName = "descriptionimage";
        $imageDescription = "Description of a image";

        $this->assertEquals($this->fixture->setImageDescription($imageName, $imageDescription)->getImageDescription($imageName), $imageDescription);
    }

    // public function testGetPDFConten() {
    // }
}