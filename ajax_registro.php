<?php
include("ConectarBaseDatos.php");
require_once('PHPMailer/PHPMailerAutoload.php');
$con=ConectarDB();
$con->set_charset("utf8");
$username=$_POST['username'];
$edad=$_POST['edad'];
$edad=(int)$edad;   
$correo=$_POST['email'];

$sql1="SELECT COUNT(nombre)as count_user FROM Usuario WHERE nombre='$username'";

if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        $error=mysqli_error($con);
        echo $error;
        exit();
    }
    $arr_nombre=$resultado->fetch_assoc();
    $nombre=$arr_nombre['count_user'];
    if ($nombre>0)
    {
    #si no existe el correo en la bd
       echo  json_encode(-1);
       exit();

      
    }
    else
    {
    $sql="insert into Usuario (nombre,edad,correo)values('$username',$edad,'$correo')";
   
        if (!$resultado = $con->query($sql)) {
            $error=mysqli_error($con);
            echo $error;
            exit();
        }
        $email=$correo;

        $username_64=base64_encode($username);
        
     
        $email_message="Bienvenidos a nuestra plataforma de lectura asistida.<BR><BR> Esta plataforma está diseñada para acompañar a lector en su proceso de lectura, poniendo especial énfasis en el desarrollo de habilidades meta cognitivas necesarias para una comprensión eficiente. Los cuentos seleccionados en esta plataforma son cuentos recomendados por el Consejo Nacional de la Cultura y las Artes, y contienen una variedad de temas adecuados para todas las edades.
En lo práctico, nuestra plataforma divide los cuentos en pequeños fragmentos, el cual es siempre seguido de una pregunta. Cada pregunta está diseñada para potenciar habilidades específicas relevantes para la comprensión del lenguaje escrito. Luego de responder cada pregunta, el lector recibirá retroalimentación orientado nuevamente a fortalecer habilidades específicas, pero además motivándolos a continuar con su proceso de lectura.
Estamos convencidos que esta plataforma ayudará a los lectores a fortalecer sus habilidades comprensivas y le agradecemos por su participación.<BR><BR>";

        $email_message.="su usuario es : ".$username."\n";
   
        //include("PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->CharSet = "text/html; charset=UTF-8;";  
        $mail->IsSMTP();  // telling the class to use SMTP    <br/>
        $mail->SMTPAuth = true;         // Enable SMTP authentication  <br/>
        $mail->SMTPSecure = 'ssl' ;   
        $mail->Host    = "smtp.gmail.com" ;// SMTP server <br/>
        $mail->Port = 465; // or 587   <br/>

        $mail->Username = 'team.abook@gmail.com';    // SMTP username <br/>
        $mail->Password = 'eplab2016';     // SMTP password   <br/>

        $mail -> IsHTML(true);  
        $mail->From    = 'team.abook@gmail.com'; 
        $mail->FromName = 'team a-book';


        $mail->addAddress($email,'');  

        $mail->WordWrap = 50;  
        $mail->Subject  = "Bienvenidos a nuestra plataforma"; 
        $mail->Body     = $email_message;

        if(!$mail->Send()) { 
        echo 'Message was not sent.';   
        echo 'Mailer error: ' . $mail->ErrorInfo;  
        echo  json_encode($mail->ErrorInfo);
        } 
        else    
         {   
         echo  json_encode(1);  
        } 
        
    

    }
    

    
    


mysqli_close($con);  
unset($con);



?>
