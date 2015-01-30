<?php

namespace PHPerge;

interface IDocument {

    public function setTemplateId($templateId);

    public function getTemplateId();

    public function setPriority($priority);

    public function getPriority();

    public function setConnectionOptions($connectionOptions);

    public function getConnectionOptions();

    public function getFields();

    public function unsetFields();

    public function setField($fieldName, $fieldValue);

    public function getField($fieldName);

    public function setEnum($fieldName, $fieldValue);

    public function getEnum($fieldName);

    public function setImage($imageName, $imageContent);

    public function getImage($imageName);

    public function setTable($tableName, $tableContent);

    public function getTable($tableName);

    public function setFieldDescription($fieldName, $fieldDescription);

    public function getFieldDescription($fieldName);

    public function setEnumDescription($fieldName, $fieldDescription);

    public function getEnumDescription($fieldName);

    public function setImageDescription($imageName, $imageDescription);

    public function getImageDescription($imageName);

    public function setTableDescription($tableName, $tableDescription);

    public function getTableDescription($tableName);

    public function getPDFContent();

    public function getTemplateDescription();

    public function setTemplateDescription($templateDescription);

}
