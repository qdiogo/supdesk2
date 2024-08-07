<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auxiliar {
    // Converte array para string    
        function array_to_string($entrada) {
		return implode(";", $entrada);
	}
	// Converte string para array
	    function string_to_array($entrada){
		return explode(";", $entrada);
	}

	// Remove formatação do campo
	function rem_format($entrada){
		$chars = array(".","/","-",";");
		 return str_replace($chars, "", $entrada);
	}


}