<?php

class Mysql 
{
	private $conn;
	private $host;
	private $user;
	private $password;
	private $baseName;
	private $port;
	private $Debug;
 
    function __construct($host,$user,$password,$db) {
		$this->conn = false;
		$this->host = $host; 
		$this->user = $user; 
		$this->password = $password; 
		$this->baseName = $db; 
		$this->port = '3306';
		$this->debug = true;
		$this->connect();
	}
 
	function __destruct() {
		$this->disconnect();
	}
	
	function connect() {
		if (!$this->conn) {
			try {
				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->baseName.'', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
			}
			catch (Exception $e) {
				die('Erreur : ' . $e->getMessage());
			}
 
			if (!$this->conn) {
				$this->status_fatal = true;
				echo 'Connection BDD failed';
				die();
			} 
			else {
				$this->status_fatal = false;
			}
		}
 
		return $this->conn;
	}
 
	function disconnect() {
		if ($this->conn) {
			$this->conn = null;
		}
	}
	
	function getOne($query) {
		$result = $this->conn->prepare($query);
		$ret = $result->execute();
		if (!$ret) {
		   echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();
		}
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$reponse = $result->fetch();
		
		return $reponse;
	}
	
	function getAll($query) {
		$result = $this->conn->prepare($query);
		$ret = $result->execute();
		if (!$ret) {
		   echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();
		}
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$reponse = $result->fetchAll();
		
		return $reponse;
	}
	
	function execute($query) {
		if (!$response = $this->conn->exec($query)) {
			echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();
		}
		return $response;
	}


	function insertRow($tableName,$data) {
		$columns = array_keys($data);
		$values = array_values($data);
		foreach ($values as $value) mysqli_real_escape_string($this->conn,$value);

        $query = "INSERT INTO $tableName (".implode(',',$columns).") VALUES ('" . implode("', '", $values) . "' )";
        $this->execute($query);
	}
}

