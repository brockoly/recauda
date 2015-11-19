<?php
	class Util{
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
	}
?>