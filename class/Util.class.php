<?php
	class Util{
		function obtenerHora(){
			$hora=date("H:i:s");
			return $hora;
		}
		function cambiarfecha_mysql($fecha){
					list($dia,$mes,$ano)=explode("/",$fecha);
					$fecha="$ano-$mes-$dia";
					return $fecha;
		}
		function cambiarfecha_mysql_a_normal($fecha){
					list($ano,$mes,$dia)=explode("-",$fecha);
					$fecha="$dia/$mes/$ano";
					return $fecha;
		}
		function cambiarfecha_mysql_a_normalGuion($fecha){
					list($ano,$mes,$dia)=explode("-",$fecha);
					$fecha="$dia-$mes-$ano";
					return $fecha;
		}
		function valida_rut($rut)
		{
			// Agradecimientos a rbarrigav link -> https://gist.github.com/rbarrigav/3881019
		    $rut = preg_replace('/[^k0-9]/i', '', $rut);
		    $dv  = substr($rut, -1);
		    $numero = substr($rut, 0, strlen($rut)-1);
		    $i = 2;
		    $suma = 0;
		    foreach(array_reverse(str_split($numero)) as $v)
		    {
		        if($i==8)
		            $i = 2;
		        $suma += $v * $i;
		        ++$i;
		    }
		    $dvr = 11 - ($suma % 11);
		    
		    if($dvr == 11)
		        $dvr = 0;
		    if($dvr == 10)
		        $dvr = 'K';
		    if($dvr == strtoupper($dv))
		        return $numero; //MODIFICADO
		    else
		        return 0;
		}
		function formatRut($_rol) {
		    /* Bonus: remuevo los ceros del comienzo. */
		    while($_rol[0] == "0") {
		        $_rol = substr($_rol, 1);
		    }
		    $factor = 2;
		    $suma = 0;
		    for($i = strlen($_rol) - 1; $i >= 0; $i--) {
		        $suma += $factor * $_rol[$i];
		        $factor = $factor % 7 == 0 ? 2 : $factor + 1;
		    }
		    $dv = 11 - $suma % 11;
		    /* Por alguna razón me daba que 11 % 11 = 11. Esto lo resuelve. */
		    $dv = $dv == 11 ? 0 : ($dv == 10 ? "K" : $dv);
		    $rut=$this->rut($_rol . "-" . $dv);
		    return $rut;
		}
		function rut( $rut ) {
	    	return number_format( substr ( $rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $rut, strlen($rut) -1 , 1 );
		}
		function objectToArray($d) {
			if (is_object($d)) {
				$d = get_object_vars($d);
			}
	 
			if (is_array($d)) {
				return array_map(__FUNCTION__, $d);
			}else{
				return $d;
			}
		}
		function calcularEdad($fecha) { 
			list($anio,$mes,$dia) = explode("-",$fecha);
			$anio_dif = date("Y") - $anio;
			$mes_dif = date("m") - $mes;
			$dia_dif = date("d") - $dia;
			if ($dia_dif < 0 && $mes_dif < 0)
				$anio_dif--;
			return $anio_dif;
		}
		
		function formatDinero($monto){
			$montoFormat=number_format($monto,0);
  			return str_replace(',', '.', $montoFormat);
		}


		
		function diferenciaTiempo($fecha, $hora){
			$fecha= $fecha." ".$hora.":00";
			$hoy= date("Y-m-d H:i:s");			
			//return $hoy." - ".$fecha;
			//return (strtotime($hoy))-(strtotime($fecha));
			$seconds = strtotime($fecha) - strtotime($hoy);
			$seconds2 = strtotime($hoy) - strtotime($fecha);
			$days2    = floor($seconds2 / 86400);
			$hours2   = floor(($seconds2 - ($days2 * 86400)) / 3600);
			$minutes2 = floor(($seconds2 - ($days2 * 86400) - ($hours2 * 3600))/60);
			$seconds2 = floor(($seconds2 - ($days2 * 86400) - ($hours2 * 3600) - ($minutes2*60)));
			$days    = floor($seconds / 86400);
			$hours   = floor(($seconds - ($days * 86400)) / 3600);
			$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
			$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
			$cerohrs="";
			$ceromin="";
			$ceroseg="";
			if($hours<10){
				$cerohrs="0";
			}else{
				$cerohrs="";
			}
			if($minutes<10){
				$ceromin="0";
			}else{
				$ceromin="";
			}
			if($seconds<10){
				$ceroseg="0";
			}else{
				$ceroseg="";
			}
			if($days2==0){
				if($seconds2>=0 && $minutes2>=0 && $hours2>=0){
					return $cerohrs.$hours.":".$ceromin.$minutes.":".$ceroseg.$seconds;
					//return "IN- ".$cerohrs.$hours.":".$ceromin.$minutes.":".$ceroseg.$seconds." - - Fecha 1: ".$days." - ".$hours.":".$minutes.":".$seconds." - Fecha 2: ".$days2." - ".$hours2.":".$minutes2.":".$seconds2;	;								
				}/*else{
					return "OUT - 00:00:00 - - Fecha 1: ".$days." - ".$hours.":".$minutes.":".$seconds." - Fecha 2: ".$days2." - ".$hours2.":".$minutes2.":".$seconds2;	
				}*/
			}else{
				return "00:00:00";
				//return "OUT2 - 00:00:00 - - Fecha 1: ".$days." - ".$hours.":".$minutes.":".$seconds." - Fecha 2: ".$days2." - ".$hours2.":".$minutes2.":".$seconds2;	
			}
		}

		function eliminaEspacios($string){ // Ej: "A      B      C" -> "A B C" , Es decir, deja solo un espacio entre palabras
			
			$cadena = preg_replace('/\s+/', ' ', trim($string));
			return $cadena;
		}

		function eliminaTodoEspacios($string){ // Ej: "A      B      C" -> "A B C" , Es decir, deja solo un espacio entre palabras
			
			$cadena = preg_replace('/\s+/', '', trim($string));
			return $cadena;
		}
	}
?>