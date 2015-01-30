<?php

use PHPerge\Examples\SampleForm\Form;
use PHPerge\Examples\SampleForm\JobPosition;

// Usage

// install via composer
// bootstrap with vendor/autoload.php
require '../../vendor/autoload.php';

// require connection options with format:
// array("url" => "<address to Verge/Writer>")
$connection = require '../connection.php';


$form = (new Form())
    ->setLastname("Тагунов")
    ->setFirstname("Тихон")
    ->setPatronymic("Валерьевич")
    ->setGender(Form::GENDER_MALE)
    ->setPhoto(__DIR__ . "/photo.jpg")
    // ->setJobPositions(array(
    //     (new JobPosition())
    //         ->setWhen("2015 - ...")
    //         ->setFirmName("Google Россия")
    //         ->setPosition("Мечтай..."),
    //     (new JobPosition())
    //         ->setWhen("2014 - 2015")
    //         ->setFirmName("РГПУ им. Герцена, группа диспетчерской службы")
    //         ->setPosition("Инженер I категории"),
    //     (new JobPosition())
    //         ->setWhen("2010 - 2014")
    //         ->setFirmName("РГПУ им. Герцена, группа поддержки учебных подразделений")
    //         ->setPosition("Инженер"),
    //     (new JobPosition())
    //         ->setWhen("2010 год")
    //         ->setFirmName("РГПУ им. Герцена, монтажный отдел")
    //         ->setPosition("Монтажник"),
    //     ))
    ;

header("Content-Type: application/pdf");
echo
$form->render($connection);
