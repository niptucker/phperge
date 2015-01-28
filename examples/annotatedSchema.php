<?php

// Usage

// install via composer
// bootstrap with vendor/autoload.php
require '../vendor/autoload.php';

// require connection options with format:
// array("url" => "<address to Verge/Writer>")
$connection = require 'connection.php';

// create document, 1st argument is template id, 2nd - connection options
$doc = new \PHPerge\Document("sample", $connection);

// set field value
// 'TEMPLATENAME' is name of user field in the .odt file
$doc->setField("QUICKLY", "непосредственно");

$doc->setField("CAN", "0");
$doc->setField("@PIC", base64_encode(file_get_contents("pic.jpg")));

// set table content
// 'STRUCTURE' is table name in the .odt file
// 'TYPE', 'NAME', 'DESCRIPTION' and 'VALUES' are table cells content which
// will be replaced with value
$doc->setTable("TABLE", array(
            array("CELLVAL1"    => "Тип 1"
                , "CELLVAL2"    => "Имя 1"
                , "CELLVAL3"    => "Описание 1"
                , "CELLVAL4"    => "Значения 1"),
            array("CELLVAL1"    => "Тип два"
                , "CELLVAL2"    => "Имя два"
                , "CELLVAL3"    => "Описание два"
                , "CELLVAL4"    => "Значения два"),
            array("CELLVAL1"    => "Тип 3"
                , "CELLVAL2"    => "Имя 3"
                , "CELLVAL3"    => "Описание 3"
                , "CELLVAL4"    => "Значения 3"),
        ));


header("Content-Type: application/pdf");
// header("Content-Disposition: attachment; filename=Ля-ля-ля.pdf");
echo $doc->getPDFContent();
