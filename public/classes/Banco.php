<?php

class Banco{

	private $conn;

	function __construct() {
        $this->conn();
    }
    
    // destructor
    function __destruct() {
        $this->conn = "";
    }

    public function begin()
    {
    	$this->conn->beginTransaction();
    }

    public function commit()
    {
    	$this->conn->commit();
    }

    public function rollback()
    {
    	$this->conn->rollback();
    }

	public function conn()
	{
		$servername = "localhost";
		$username = "bravi";
		$password = "123456";
		$dbName = "bravidb";

		try {
		 	$this->conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
		  
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
		} catch(PDOException $e) {
			throw new Exception("Connection failed: " . $e->getMessage());
		}
	}

	public function exec($sql, $params = array())
	{
		try{
			$consulta = $this->conn->prepare($sql);
			// foreach ($params as $campo => $valor) {
			// 	$consulta->bindParam($campo, $valor);
			// }
	  		$retorno = $consulta->execute();
			return true;
		}catch(Exception $e){
			$this->rollback();
			print_r($e);
			exit;
		}
	}

	public function read($sql)
	{
		try{
			$consulta = $this->conn->prepare($sql);
	  		$consulta->execute();
	  		$consulta->setFetchMode(PDO::FETCH_ASSOC);
			return $consulta->fetchAll();
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}