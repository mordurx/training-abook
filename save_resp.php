<?php
function insert_Resp_User($con,$user,$id_pregunta,$resp_user,$resp_correct,$intento,$id_cuento)
{   include("check_end.php");
    $con->set_charset("utf8");

    if ($resp_correct==$resp_user)
    {
    $result=1;
    $sql1="select feedback_correcto from Pregunta where id_pregunta=$id_pregunta";
    if (!$resultado = $con->query($sql1)) 
    {
        echo "error consulta a la base de datos.";
        exit;
    }
     $feedback_vect = $resultado->fetch_assoc();
     $feedback=$feedback_vect['feedback_correcto'];
     
     $feedback_flag=1;
    }
    else
    {
        $result=0;
        $sql1="select feedback_incorrecto from Pregunta where id_pregunta=$id_pregunta";
        if (!$resultado = $con->query($sql1)) 
        {
        echo "error consulta a la base de datos.";
        exit;
        }
        $feedback_vect = $resultado->fetch_assoc();
        $feedback=$feedback_vect['feedback_incorrecto'];
        
        $feedback_flag=0;

     
    }
    //$resp_user=utf8_encode($resp_user);
    
    //print $result;
    //print $user;
    $sql="SELECT num_preg FROM Pregunta_por_Usuario WHERE id_usuario='$user'";
        if (!$resultado = $con->query($sql)) 
    {
        echo "error consulta a la base de datos.";
        exit;
    }
    $arr_num_preg = $resultado->fetch_assoc();
    $num_preg=$arr_num_preg['num_preg'];

    $sql1="update Respuesta_pregunta set resultado=$result,resp_user='$resp_user',id_feedback=$feedback_flag,estado=1,order_resp=$num_preg+1 where nombre_usuario='$user' and id_pregunta=$id_pregunta and estado=0";
    if (!$resultado = $con->query($sql1)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
    }

    $sql1="update Pregunta_por_Usuario set num_preg=num_preg+1,id_cuento=$id_cuento where id_usuario='$user'";
    if (!$resultado = $con->query($sql1)) {
        $error=mysqli_error($con);
         echo $error;
         exit;
    }

    $termino=Is_End($con,$user,$id_cuento);
    if ($termino==False) 
    {

      $sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_usuario='$user' and id_cuento=$id_cuento";
        if (!$resultado = $con->query($sql)) 
    {
        echo "error consulta a la base de datos.";
        exit;
    }
     $arr_intento = $resultado->fetch_assoc();
     $veces_leido=$arr_intento['veces_leido'];
        $sql="SELECT Pagina.numeracion FROM Respuesta_pregunta ".
        "inner join Cuento_por_Usuario ON Respuesta_pregunta.nombre_usuario=Cuento_por_Usuario.id_usuario ". 
        "inner join Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "INNER JOIN Pagina on Pregunta.id_pagina=Pagina.id_pagina and Cuento_por_Usuario.id_cuento=Pagina.id_cuento ".
        "WHERE veces_leido=$veces_leido AND id_usuario='$user' and Pagina.id_cuento=$id_cuento and estado=0 and intento=$veces_leido ".
        "ORDER by Pagina.numeracion  ASC limit 1";

        if (!$resultado = $con->query($sql)) 
        {
            echo "error consulta indice.";
            exit;
        }
        $arr_num= $resultado->fetch_assoc();
        $id_numeracion=$arr_num['numeracion'];
        //print_r($id_numeracion);
         $sql1="update Cuento_por_Usuario set ind_pagina=$id_numeracion  where id_usuario='$user' and id_cuento=$id_cuento";
            if (!$resultado = $con->query($sql1)) {
                $error=mysqli_error($con);
                 echo $error;
               
                exit;
            }
    }

mysqli_close($con);  
unset($con);
$feedback=base64_encode($feedback_flag);
echo '<script type="text/javascript">
           window.location = "feedback.html?id_feed='.$feedback.'"</script>';

} 

?>
