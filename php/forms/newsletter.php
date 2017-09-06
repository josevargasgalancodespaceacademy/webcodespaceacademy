<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../classes/mailer.php';
require_once '../config.php';


$request = array("email" => "davidfisher24@gmail.com");

$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();
$validator = new Validator($request);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$errors = $validator->getErrors();
if ($errors) die(print_r($errors));

$insertData = $request;
$insertData["subscribed"] = 1;

$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
if ($mysql->checkRowExists("newsletter_subscriptions", array("email" => $request["email"])) > 0) die(print_r("Already exists"));
$mysql->insertRow("newsletter_subscriptions",$insertData);


?>