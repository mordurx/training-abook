<?php
session_start();   
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");
$username=$_POST['username'];

$sql1="SELECT COUNT(nombre)as count_user FROM Usuario WHERE nombre='$username'";

if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        $error=mysqli_error($con);
        echo $error;
        exit();
    }
    $arr_nombre=$resultado->fetch_assoc();
    $nombre=$arr_nombre['count_user'];
    if ($nombre<1)
    {
    #si no existe el user en la bd
       echo  json_encode(-1);
       exit();

      
    }
    else
    {
        $sql="INSERT ignore INTO Cuento_por_Usuario (id_usuario,id_cuento) SELECT Usuario.nombre, id_cuento FROM Usuario INNER JOIN Cuento where Usuario.nombre='$username'";
                if (!$resultado = $con->query($sql)) 
                {
                    $error=mysqli_error($con);
                    //echo $error;
                    exit();
                }
        $sql="INSERT ignore INTO Pregunta_por_Usuario (id_usuario) values ('$username')";
                if (!$resultado = $con->query($sql)) 
                {
                    $error=mysqli_error($con);
                    //echo $error;
                    exit();
                }
        


        $_SESSION['username'] = $username;
        echo  json_encode(1);
    

    }
    

    
    


mysqli_close($con);  
unset($con);



?>
