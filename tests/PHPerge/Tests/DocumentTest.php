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
	}

	public function testFields() {

		$fields = array(
			"fieldInt"			=> 10,
			"fieldFloat"		=> 1.4e-2,
			"fieldString"		=> "String",
			"fieldStringUtf"	=> "Русская строка",
		);

		foreach ($fields as $fieldName => $fieldValue) {
			$this->assertEquals($this->fixture->setField($fieldName, $fieldValue)->getField($fieldName), $fieldValue);
		}

	}
}