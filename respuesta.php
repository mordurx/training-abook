<?php
session_start();  
include("ConectarBaseDatos.php");
$con=ConectarDB();
$id_cuento=$_SESSION['id_cuento'];
$id_pagina=$_SESSION['id_pagina'];
$user=$_SESSION['username'];
$id_pregunta=$_GET['id'];
$_SESSION['id_pregunta']=$id_pregunta;
$resp_user=$_GET['resp_user'];
$resp_user=base64_decode($resp_user);
$resp_correcta=$_GET['resp'];
$resp_correcta=base64_decode($resp_correcta);
$intento=$_SESSION['nveces'];
$id_numeracion=$_SESSION['num'];
include("save_resp.php");
//$feedback=insert_Resp_User($con,$user,$id_pregunta,$resp_user,$resp_correcta);
insert_Resp_User($con,$user,$id_pregunta,$resp_user,$resp_correcta,$intento,$id_cuento);  
    




?>
