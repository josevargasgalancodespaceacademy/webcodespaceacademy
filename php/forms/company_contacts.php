<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../config.php';

$request = array(
	"email" => "davidfisher24@gmail.com",
	"name" => "David",
	"telephone" => "633561928",
	"company_name" => "Bits and bobs",
	"company_link" => "www.bitsandbobs.com",
	"training_request" => "si",
	"comment" => "Long Long Long Text",
);
$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();


$validator = new Validator($request);
$validator->filledIn("name")->length("name", "<=", 100);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$validator->filledIn("telephone")->length("telephone", "<=", 15);
$validator->filledIn("company_name")->length("company_name", "<=", 100);
$validator->filledIn("training_request");
$errors = $validator->getErrors();

$errors = $validator->getErrors();
if ($errors) die(print_r($errors));


$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
$mysql->insertRow("company_contacts",$request);




?>