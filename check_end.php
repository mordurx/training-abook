<?
function Is_End($con,$user,$id_cuento)
{ 
	  $con->set_charset("utf8");
	  $sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_usuario='$user' and id_cuento=$id_cuento";
	    if (!$resultado = $con->query($sql)) 
    {
        echo "error consulta a la base de datos.";
        exit;
    }
     $arr_intento = $resultado->fetch_assoc();
     $veces_leido=$arr_intento['veces_leido'];


	$sql="SELECT COUNT(Respuesta_pregunta.id_pregunta)as resp_faltantes FROM Respuesta_pregunta ".
        "inner join Cuento_por_Usuario ON Respuesta_pregunta.nombre_usuario=Cuento_por_Usuario.id_usuario ". 
        "inner join Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "INNER JOIN Pagina on Pregunta.id_pagina=Pagina.id_pagina and Cuento_por_Usuario.id_cuento=Pagina.id_cuento ".
        "WHERE veces_leido=$veces_leido AND id_usuario='$user' and Pagina.id_cuento=$id_cuento and estado=0 and intento=$veces_leido ".
        "ORDER by Pagina.numeracion  ASC";



    if (!$resultado = $con->query($sql)) 
	    {
	        echo "error consulta a la base de datos.";
	        exit;
	    }
	    $arr_preg_rest = $resultado->fetch_assoc();
     	$resp_faltantes=$arr_preg_rest['resp_faltantes'];
     	if ($resp_faltantes>0)
     	{

     		return False;
     	}
     	else
     	{
     		return True;
     	}

mysqli_close($con);  
unset($con);

}

?>