<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../config.php';


//$request = array("email" => "davidfisher24gmail.com");
parse_str($_SERVER['QUERY_STRING'],$request);

$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();
$validator = new Validator($request);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$errors = $validator->getErrors();

$insertData = $request;
$insertData["subscribed"] = 1;

$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
if ($mysql->checkRowExists("newsletter_subscriptions", array("email" => $request["email"])) > 0) $errors["general"] = "Ya has suscrito al newsletter";

if (!$errors) {
	$mysql->insertRow("newsletter_subscriptions",$insertData);
}
echo json_encode($errors);


?>