<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../config.php';

$request = array("email" => "davidfisher24@gmail.com");
$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();

$validator = new Validator($request);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$errors = $validator->getErrors();
if ($errors) die(print_r("Errors"));

$insertData = $request;
$insertData["subscribed"] = 1;
$insertData["created"] = date('Y-m-d G:i:s');

$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
$mysql->insertRow("newsletter_subscriptions",$insertData);



?>