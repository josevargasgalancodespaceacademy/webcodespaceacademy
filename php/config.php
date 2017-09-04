<?php  

// DB Settings 
define('DB_SERVER', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'codespaceacademy'); 

define('FROM_EMAIL', 'admin@codespaceacademy.com'); 
define('FROM_NAME', 'Codespace Academy'); 


session_start(); 


$mini = false; 
$nonav = false; 
error_reporting(0);

require_once 'mysql.php'; 
$mysql = new Mysql(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);

?>