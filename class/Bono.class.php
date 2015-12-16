<?php 

class Bono{
	 private $bonId;
	 private $bonMonto;
	 
	function setBoleta($bonId, $bonMonto){
	 		$this->bonId=trim($bonId);
	 		$this->bonMonto=trim($bonMonto);
	}
}
?>
