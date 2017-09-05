<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../config.php';

$request = array(
	"name" => "David",
	"surnames" => "Fisher",
	"email" => "davidfisher24@gmail.com",
	"telephone" => "633561928",
	"date_of_birth" => "17/03/1982",
	"type_identification" => "dni",
	"number_identification" => "77180224K",
	"city" => "Malaga",
	"linkedin" => "",
	"comment" => "",
);
$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();

$validator = new Validator($request);
$validator->filledIn("name")->length("name", "<=", 100);
$validator->filledIn("surnames")->length("surnames", "<=", 100);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$validator->filledIn("date_of_birth")->date("date_of_birth","dd/mm/yyyy");
$validator->filledIn("telephone")->length("telephone", "<=", 15);
$validator->filledIn("city")->length("city", "<=", 100);
$validator->filledIn(array("type_identification","number_identification"))->length($request["type_identification"], "<=", 10)->spanish_id("number_identification",$request["type_identification"]);

$errors = $validator->getErrors();
if ($errors) die(print_r("Errors"));

$insertData = $request;
$insertData["created"] = date('Y-m-d G:i:s');

$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
$mysql->insertRow("promotion_entries",$insertData);



?>