<?php

require_once '../lib/PHPerge/IDocument.php';
require_once '../lib/PHPerge/Document.php';

$connection = require 'connection.php';

$doc = new \PHPerge\Document("schema", $connection);
$doc->setField("TEMPLATENAME", "Ля-ля-ля");

// var_dump($doc->getFields());
// var_dump($doc->getConnectionOptions());
// var_dump($doc->getPDFContent());

header("Content-Type: application/pdf");
echo $doc->getPDFContent();
