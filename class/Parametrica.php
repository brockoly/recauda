<? 
	if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
class Parametrica{
	function arrayAJson($arrayQR){
		$i=0;
		if(mysql_num_rows($arrayQR)){
			while($RSdatos = mysql_fetch_array($arrayQR)){
				$datos[$i] = array("id"=>$RSdatos[0],"valor"=>$RSdatos[1]);
				$i++;
			}
		}else{
			$datos[0] = array("id"=>'',"valor"=>'SIN DATOS...');
		}
		return json_encode($datos);	
	}
}?>