<?php
session_start();   
include("ConectarBaseDatos.php");
include("check_end.php");
$con=ConectarDB();
$con->set_charset("utf8");
$id_cuento=$_POST['id_cuento'];
$username=$_POST['username'];

$data=array();



$sql="SELECT COUNT(resultado)as infer FROM Respuesta_pregunta ". 
"inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ". 
"inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE ". 
"nombre_usuario='$username' and estado=1 and id_cuento=$id_cuento and cond_exp='infer' ". 
"and Respuesta_pregunta.resultado=1";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_cond_exp = $resultado->fetch_assoc();
$infer=$arr_cond_exp['infer'];


//total de preguntas con cond_1
$sql="SELECT COUNT(resultado)as total_preg_cond1 FROM Respuesta_pregunta ". 
"inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ". 
"inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE ". 
"nombre_usuario='$username' and estado=1 and id_cuento=$id_cuento and cond_exp='infer' ";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_total_preg_cond1 = $resultado->fetch_assoc();
$t_p_infer=$arr_total_preg_cond1['total_preg_cond1'];
$percent_cond_1=round(($infer/$t_p_infer)*100,2);
array_push($data,$percent_cond_1); 




$sql="SELECT COUNT(resultado)as struct FROM Respuesta_pregunta ". 
"inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ". 
"inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE ". 
"nombre_usuario='$username' and estado=1 and id_cuento=$id_cuento and cond_exp='struct' ". 
"and Respuesta_pregunta.resultado=1";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_cond_exp_2 = $resultado->fetch_assoc();
$struct=$arr_cond_exp_2['struct'];


$sql="SELECT COUNT(resultado)as total_preg_cond2 FROM Respuesta_pregunta ". 
"inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ". 
"inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE ". 
"nombre_usuario='$username' and estado=1 and id_cuento=$id_cuento and cond_exp='struct' ";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_total_preg_cond2 = $resultado->fetch_assoc();
$t_p_cond_exp_2=$arr_total_preg_cond2['total_preg_cond2'];
$percent_cond_2=round(($struct/$t_p_cond_exp_2)*100,2);
array_push($data,$percent_cond_2);



$sql="SELECT COUNT(resultado)as monit FROM Respuesta_pregunta ". 
"inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ". 
"inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE ". 
"nombre_usuario='$username' and estado=1 and id_cuento=$id_cuento and cond_exp='monit' ". 
"and Respuesta_pregunta.resultado=1";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_cond_exp_3 = $resultado->fetch_assoc();
$monit=$arr_cond_exp_3['monit'];

$sql="SELECT COUNT(resultado)as total_preg_cond3 FROM Respuesta_pregunta ". 
"inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ". 
"inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE ". 
"nombre_usuario='$username' and estado=1 and id_cuento=$id_cuento and cond_exp='monit' ";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_total_preg_cond3 = $resultado->fetch_assoc();
$t_p_cond_exp_3=$arr_total_preg_cond3['total_preg_cond3'];
$percent_cond_3=round(($monit/$t_p_cond_exp_3)*100,2);
array_push($data,$percent_cond_3);














echo  json_encode($data);

     
mysqli_close($con);  
unset($con);
     




?>
