<?php

require_once '../classes/mysql.php'; 
require_once '../classes/validator.php';
require_once '../classes/sanitizer.php';
require_once '../config.php';

/*$request = array(
	"name" => "David",
	"email" => "davidfisher24@gmail.com",
	"telephone" => "633561928",
	"website" => "www.davidfisher.com",
	"linkedin" => "",
);*/
parse_str($_SERVER['QUERY_STRING'],$request);

$file_upload_errors = array();
if(isset($_FILES['curriculum'])){
	$file_name = $_FILES['curriculum']['name']; 
	$file_size = $_FILES['curriculum']['size']; 
	$file_tmp = $_FILES['curriculum']['tmp_name']; 
	$file_type = $_FILES['curriculum']['type']; 

	if($file_type !== 'application/pdf'){
		$file_upload_errors[] = "extension not allowed, please choose a pdf file.";
	}

	if($file_size > 10485760){
		$file_upload_errors[] = 'File size must be less than 10MB';
	}

	if(empty($file_upload_errors) == true){
		$folder = "../../curriculums/";
		$time = date("Y-m-d");
		$saved_file = $folder . $time . "-" . $file_name;
		move_uploaded_file($file_tmp,$saved_file);
		$request["route_curriculum_pdf"] = $file_name;
	}
}


$sanitizer = new Sanitizer($request);
$request = $sanitizer->sanitizeRequest();

$validator = new Validator($request);
$validator->filledIn("name")->length("name", "<=", 100);
$validator->filledIn("email")->length("email", "<=", 100)->email("email");
$validator->filledIn("telephone")->length("telephone", "<=", 15);
$errors = array_merge($validator->getErrors(),$file_upload_errors);


if (!$errors) {
	$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	$mysql->insertRow("curriculums",$request);
}

echo json_encode($errors);




?>