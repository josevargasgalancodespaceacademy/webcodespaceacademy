<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../config.php';

$request = array(
	"name" => "David",
	"email" => "davidfisher24@gmail.com",
	"telephone" => "633561928",
	"website" => "www.davidfisher.com",
	"linkedin" => "",
);

$validator = new Validator($request);
$validator->filledIn("name")->length("name", "<=", 100);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$validator->filledIn("telephone")->length("telephone", "<=", 15)->alphanumeric("telephone");
$errors = $validator->getErrors();


$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
// check that this person hasn't added before
// upload and route the
// add to the database



?>