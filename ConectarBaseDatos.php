<?php

function ConectarDB()
{
	// Conectando, seleccionando la base de datos
	$mysqli = new mysqli('pdb11.awardspace.net', '2089430_postrain', 'eplab2016','2089430_postrain');
	/* comprobar la conexión */
	if ($mysqli->connect_errno) {
    	printf("Falló la conexión: %s\n", $mysqli->connect_error);
    	exit();
	}
	else{

		//echo "conexion correcta!!!!";
		return $mysqli; 
	}

}

?>

