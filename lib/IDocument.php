<?php

namespace PHPerge;

interface IDocument {

    public function setField($fieldName, $fieldValue);

    public function getField($fieldName);

}