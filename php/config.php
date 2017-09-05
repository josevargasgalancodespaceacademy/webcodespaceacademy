<?php  

// DB Settings 
define('DB_SERVER', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'codespaceacademy'); 

define('SMTP_HOST', '');
define('SMTP_USER', '');
define('SMTP_PASSWORD', '');
define('SMTP_PORT', 587);
define('SMTP_DEBUG', 0);
define('SMTP_SECURE', 'tls');
define('STMP_LANGUAGE', 'es');

define('FROM_EMAIL', 'admin@codespaceacademy.com'); 
define('FROM_NAME', 'Codespace Academy'); 

session_start(); 


$mini = false; 
$nonav = false; 
error_reporting(0);



?>