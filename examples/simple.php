<?php

// Usage

// install via composer
// bootstrap with vendor/autoload.php
require '../vendor/autoload.php';

// require connection options with format:
// array("url" => "<address to Verge/Writer>")
$connection = require 'connection.php';

// create document, 1st argument is template id, 2nd - connection options
$doc = new \PHPerge\Document("schema", $connection);

// set field value
// 'TEMPLATENAME' is name of user field in the .odt file
$doc->setField("TEMPLATENAME", "Ля-ля-ля");

// set table content
// 'STRUCTURE' is table name in the .odt file
// 'TYPE', 'NAME', 'DESCRIPTION' and 'VALUES' are table cells content which
// will be replaced with value
$doc->setTable("STRUCTURE", array(
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
        ));


header("Content-Type: application/pdf");
echo $doc->getPDFContent();
