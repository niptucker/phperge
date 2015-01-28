<?php

use PHPerge\Examples\Sample;
use PHPerge\Examples\SampleTableRow;

// Usage

// install via composer
// bootstrap with vendor/autoload.php
require '../vendor/autoload.php';
// require '../bootstrap.php';

// require connection options with format:
// array("url" => "<address to Verge/Writer>")
$connection = require 'connection.php';


$sample = (new Sample())
    ->setQuickly("неожиданно быстро")
    ->setCan(Sample::CAN_WANT)
    ->setPic(__DIR__ . "/pic.jpg")
    ->setTable(array(
        (new SampleTableRow())
            ->setCellval1("val1-1")
            ->setCellval2("val1-2")
            ->setCellval3("val1-3")
            ->setCellval4("val1-4"),
        (new SampleTableRow())
            ->setCellval1("val2-1")
            ->setCellval2("val2-2")
            ->setCellval3("val2-3")
            ->setCellval4("val2-4"),
        (new SampleTableRow())
            ->setCellval1("val3-1")
            ->setCellval2("val3-2")
            ->setCellval3("val3-3")
            ->setCellval4("val3-4"),
        ));

header("Content-Type: application/pdf");
echo $sample->render();
