<?php
session_start();   
include("ConectarBaseDatos.php");
include("test_pseudo_ram.php");

$con=ConectarDB();
$con->set_charset("utf8");
$id_cuento=$_POST['id_cuento'];
$id_numeracion=$_POST['id_numeracion'];

$_SESSION['id_cuento'] = $id_cuento;
$_SESSION['num'] = $id_numeracion;
$username=$_SESSION['username'];

//get how many pages has the cuento
$sql="SELECT COUNT(id_pagina)as num_pages FROM Pagina WHERE id_cuento=$id_cuento";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
$arr_count_num_pages=$resultado->fetch_assoc();     
$num_pages=$arr_count_num_pages['num_pages'];
$pseudo_ramdom=pseudo_ram('infer','struct','monit',$num_pages);
$intento=1;
$id_num=1;
foreach ($pseudo_ramdom as $key => $vector_intentos) {
    
    foreach ($vector_intentos as $key => $value)
    {    
         //print_r($id_num);
         //print_r($value);
         $sql="SELECT id_pregunta FROM Pregunta INNER JOIN Pagina ON Pregunta.id_pagina=Pagina.id_pagina where Pagina.id_cuento=$id_cuento and Pagina.numeracion=$id_num and cond_exp='$value'";
         if (!$resultado = $con->query($sql)) 
            {
                $error=mysqli_error($con);
                echo $error;
                exit();
            }
            $arr_id_pregunta=$resultado->fetch_assoc();     
            $id_pregunta=$arr_id_pregunta['id_pregunta'];
            $sql="insert ignore into Respuesta_pregunta (id_pregunta,nombre_usuario,intento)values('$id_pregunta','$username','$intento')";
   
        if (!$resultado = $con->query($sql)) {
            $error=mysqli_error($con);
            echo $error;
            exit();
        }
         $id_num++;

    }
    $id_num=1;
    $intento++;
    //print "<br>";
    //print_r(array_count_values($value));
    //print "<br>";
}

//$data=pseudo_random(0,1,1,'A','B','C') ;

// foreach ($pseudo_ramdom as $key => $value) {
//     print_r($value);
//     print_r(array_count_values($value));
//     print "<br>";
// }




$sql1= "SELECT id_pagina,pagina_texto FROM Pagina where id_cuento=$id_cuento and numeracion=$id_numeracion";

if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        echo "error consulta a la base de datos.";
        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql1 . "\n";
        echo "Errno: " . $con->errno . "\n";
        echo "Error: " . $con->error . "\n";
        exit;
    }
$cuento =array();
$cuentos =array();
if ($resultado->num_rows > 0) {
    // output data of each row
    
    while($row = $resultado->fetch_assoc()) {
        $_SESSION['id_pagina'] = $row["id_pagina"];
        //$imagen=base64_encode($row["imagen"]);
        //$texto = json_encode(stripslashes($row["pagina_texto"]));
       // $texto=json_encode($row["pagina_texto"]);
        array_push($cuentos,$row["pagina_texto"]);
        //array_push($cuentos, $cuento);
        //unset($cuento);
        //$cuento = array();  
        //echo $imagen;
    }

    echo  json_encode($cuentos);
    
} else {
    echo "0 results";
}


mysqli_close($con);  
unset($con);



?>
