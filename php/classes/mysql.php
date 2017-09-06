<?php

/**
* MySQL connection Class
* Functions to connect to sql and run queries
* 
* @author  David Fisher <davidfisher@codespaceacademy.com>
*/


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
	
	/**
	 *
	 * Creates sql connection
	 *
	 * @return $sql connections
	 *
	*/

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

	/**
	 *
	 * Disconnects the sql connection
	 *
	 * @return void
	 *
	*/
 
	function disconnect() {
		if ($this->conn) {
			$this->conn = null;
		}
	}

	/**
	 *
	 * Executes a passed sql query and returns the first row found
	 *
	 * @param  string  $query  The query to run
	 * @return array $response  The first row found
	 *
	*/
	
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

	/**
	 *
	 * Executes a passed sql query and returns all found data
	 *
	 * @param  string  $query  The query to run
	 * @return array $response  All rows found
	 *
	*/
	
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

	/**
	 *
	 * Executes a passed sql query and returns response
	 *
	 * @param  string  $query  The query to run
	 * @return response $response  SQL response
	 *
	*/
	
	function execute($query) {
		$query = $this->conn->prepare($query);
		//if (!$response = $this->conn->exec($query)) {
		if (!$response = $query->execute()) {
			echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();
		}
		return $response;
	}

	/**
	 *
	 * Builds a query to inserts a new sql row. Adds a "created" timestamp
	 *
	 * @param  string  $tableName  The table to insert the data to
	 * @param  array  $data  $key => $value data to enter
	 * @return void 
	 *
	*/

	function insertRow($tableName,$data) {
		$columns = array_keys($data);
		$values = array_values($data);
		array_push($columns,"created");
		array_push($values,date('Y-m-d G:i:s'));

        $query = "INSERT INTO $tableName (".implode(',',$columns).") VALUES ('" . implode("', '", $values) . "' )";
        return $this->execute($query);
	}

	/**
	 *
	 * Check if row exists on an array of parameters
	 *
	 * @param  string  $tableName  The table to check
	 * @param  array  $data    $key => $value data to check against
	 * @return integer $count  Number of rows found for entered data  
	 *
	*/

	function checkRowExists($tableName,$data) {
        $query = "SELECT * FROM $tableName WHERE ";
        foreach ($data as $key => $value) {
        	$query .= "$key = '$value' OR ";
        }

        $result = $this->getAll(substr($query,0,-4));
        return count($result);
	}

}

