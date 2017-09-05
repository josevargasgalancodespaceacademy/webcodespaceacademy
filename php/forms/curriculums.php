<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../config.php';

$request = array(
	"name" => "David",
	"email" => "davidfisher24@gmail.com",
	"telephone" => "633561928",
	"website" => "www.davidfisher.com",
	"linkedin" => "",
);
$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();

$validator = new Validator($request);
$validator->filledIn("name")->length("name", "<=", 100);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$validator->filledIn("telephone")->length("telephone", "<=", 15);
$errors = $validator->getErrors();

$errors = $validator->getErrors();
if ($errors) die(print_r($errors));


$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
$mysql->insertRow("curriculums",$request);



?>