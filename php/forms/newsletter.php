<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../config.php';

$request = array("email" => "davidfisher24gmail.com");

$validator = new Validator($request);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$errors = $validator->getErrors();


$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
// check that we are not repeating the name
// add to the database



?>