<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../config.php';

$request = array(
	"email" => "davidfisher24gmail.com",
	"name" => "David",
	"telephone" => "633561928",
	"company_name" => "Bits and bobs",
	"company_link" => "www.bitsandbobs.com",
	"training_request" => "",
	"comment" => "",
);


$validator = new Validator($request);
$validator->filledIn("name")->length("name", "<=", 100);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$validator->filledIn("telephone")->length("telephone", "<=", 15)->alphanumeric("telephone");
$validator->filledIn("company_name")->length("company_name", "<=", 100);
$validator->filledIn("training_request");
$errors = $validator->getErrors();


$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
// check that this person hasn't added before
// upload and route the cv
// add to the database



?>