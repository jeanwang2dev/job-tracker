<?php

require_once '/home/Db_conn.php';
date_default_timezone_set('America/Detroit');

class DBHandler extends DatabaseConn {

	private $stat;
	private $conn;
	private $db;
	private $error;

	public function selectedBinded($sql, $bindings){

		$this->error = false;
		try{
			$this->create_db_conn();
			$this->stat = $this->conn->prepare($sql);
			$this->createBinding($bindings);
			$this->executeStat();
			
		}catch (PDOException $Exception){
			$this->writeLog($Exception->getMessage());
			return 'error';
		}

		$this->conn = null;
		if(!$this->error){
			return $this->stat->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			return 'error';
		}


	}

	public function selectNotBinded($sql){

		$this->error = false;
		try{
			$this->create_db_conn();
			$this->stat = $this->conn->prepare($sql);
			$this->executeStat();
		}catch (PDOException $Exception){
			
			$this->writeLog($Exception->getMessage());
			return 'error';
		}

		$this->conn = null;
		if(!$this->error){
			return $this->stat->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			return 'error';
		}
	}

	/* For CREATE, UPDATE, DELETE that does return a value, other than select*/
	public function otherBinded($sql, $bindings){

		$this->error = false;
		
		$this->create_db_conn();
		$this->stat = $this->conn->prepare($sql);
		$this->createBinding($bindings);
		$this->executeStat();
		$this->conn = null;
      
		if(!$this->error){
			return 'noerror';
		}
		else{
			return 'error';
		}
	}

    /** PRIVATE FUNCTIONS **/
	private function createBinding($bindings){

		foreach ($bindings as $value) {
			switch($value[2]){
				case 'int' : $this->stat->bindParam($value[0],$value[1], PDO::PARAM_INT);
				case 'str' : $this->stat->bindParam($value[0],$value[1], PDO::PARAM_STR);
			}	
			
		}
	}

	private function create_db_conn(){

		$this->db = new DatabaseConn();
		$this->conn = $this->db->dbOpen();
	}

	private function executeStat(){

		try{
			$this->stat->execute();

		}catch ( PDOException $Exception) {

			$this->writeLog($Exception->getMessage());
			$this->error = true;
		}
	}

	private function writeLog($msg){

		$error = date('F-j-Y \a\t h:i:s') . " - ERROR! --- ". $msg. " --- \n";
	    file_put_contents('../logs/pdo_errors.log', $error, FILE_APPEND);
		
    }


}