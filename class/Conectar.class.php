<?php 

class Conectar extends PDO {
	private $dns;
	private $lnk; //puntero a la BD
	private $user;
	private $pass;
	private $server; //nombre del servidor
	private $database; //nombre de la base de datos
	private $rs; //resultado de la consulta.
	protected $transactionCounter = 0; 
	
	function __construct(){
		$this->dns="mysql";
		$this->user = "usuario";
		$this->pass = "hospital";
		$this->server = "localhost";
		$this->database = "recaudacion";		
	}
	/*************SOBRECARGAS*************/
	function beginTransaction() 
    { 
        if(!$this->transactionCounter++) 
            return parent::beginTransaction(); 
       return $this->transactionCounter >= 0; 
    } 

    function commit() 
    { 
       if(!--$this->transactionCounter) 
           return parent::commit(); 
       return $this->transactionCounter >= 0; 
    } 

    function rollback() 
    { 
        if($this->transactionCounter >= 0) 
        { 
            $this->transactionCounter = 0; 
            return parent::rollback(); 
        } 
        $this->transactionCounter = 0; 
        return false; 
    } 
    /************************************/

	function db_connect(){
		try{	
			parent::__construct($this->dns.':dbname='.$this->database.';:host='.$this->server, $this->user, $this->pass);
			$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		//$this->lnk = mysql_connect($this->server,$this->user,$this->pass) or die("Error de conexion a BD");		
	}
	function db_select(){
		mysql_select_db($this->database,$this->lnk) or die("Error al Seleccionar BD $database");
	}
	function db_close(){
		mysql_close($this->lnk);
	}
	function consultaSQL($query, $error){
			$this->query('SET NAMES UTF8');
			$this->rs = $this->query($query) or die ($error."\n".print_r($this->errorInfo()));
			return $this->rs;
	}

	function ejecutarSQL($query, $error){ //PARA LOS INSERT, UPDATE Y DELETE
		$cont = $this->query($query) or die ($error."\n".print_r($this->errorInfo()));
		return $cont;
	}	
}?>