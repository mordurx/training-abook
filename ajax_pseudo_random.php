<?php
session_start();   
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");

$id_cuento=$_POST['id_cuento'];
$id_numeracion=$_POST['num'];
$username=$_SESSION['username'];
$id_pagina=$_SESSION['id_pagina'];

$cond_exp1='cond_exp_1';
$cond_exp2='cond_exp2';
$cond_exp3='cond_exp3';

$sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_cuento=$id_cuento and id_usuario='$username'";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
$arr_veces_leido=$resultado->fetch_assoc();     
$veces_leido=$arr_veces_leido['veces_leido'];



$sql="SELECT Pregunta.id_pregunta as id_pregunta,Pregunta.pregunta_texto, Pregunta.btn_izq,Pregunta.btn_der,Pregunta.respuesta_correcta".
" from Respuesta_pregunta inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta".
" where Pregunta.id_pagina=$id_pagina and Respuesta_pregunta.nombre_usuario='$username' and intento=$veces_leido";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
    $pregunta_ramdom_vect=$resultado->fetch_assoc();
    if (is_null($pregunta_ramdom_vect['id_pregunta'])) {
        echo json_encode(-1);
    }
    else{
    $_SESSION['id_pregunta']=$pregunta_ramdom_vect['id_pregunta'];
   
    echo json_encode($pregunta_ramdom_vect);
    }













mysqli_close($con);  
unset($con);


?>
