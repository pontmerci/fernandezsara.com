<?php
header('Content-Type: application/json');

	function check_email_address($email)
	{
		// Primero, checamos que solo haya un s�mbolo @, y que los largos sean correctos
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
		{
			// correo inv�lido por n�mero incorrecto de caracteres en una parte, o n�mero incorrecto de s�mbolos @
		return false;
	  }
	  // se divide en partes para hacerlo m�s sencillo
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++)
		{
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
			{
		  return false;
		}
	  }
	  // se revisa si el dominio es una IP. Si no, debe ser un nombre de dominio v�lido
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
		{
		 $domain_array = explode(".", $email_array[1]);
		 if (sizeof($domain_array) < 2)
			 {
			return false; // No son suficientes partes o secciones para se un dominio
		 }
		 for ($i = 0; $i < sizeof($domain_array); $i++)
			 {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
					{
			   return false;
			}
		 }
	  }
	  return true;
	}

	//require("class.phpmailer.php");
	//require("class.smtp.php");
	require "helpmail/class.phpmailer.php";
// fin function formRegistro()

// verificamos si se han enviado ya las variables necesarias.

	$apellido = $_POST["apellido"];
	$correo = $_POST["correo"];
	$asunto = $_POST["asunto"];
	$consulta = $_POST["consulta"];

	if ($correo!=''){
		if (check_email_address($email)) {

			$mail = new PHPMailer();
			$mail->PluginDir = "./helpmail/";
			$mail->Mailer = "smtp";
			$mail->Host = "mail.1234.com"; //"mail.diseenio.com.ar" ; # Editar el Host smtp
			$mail->SMTPAuth = true;
			$mail->Username = "yo@1234.com.ar";  // $mi_mail; //"alejandro@diseenio.com.ar"; # editar el usuario
			$mail->Password = "1234"; // # Editar el password
			$mail->From = "yo@1234.com.ar"; //$correo;//"contacto@penarolelortondo.com.ar"; //"alejandro@diseenio.com.ar"; //$mailFROM;
			$mail->FromName = $apellido//"www.penarolelortondo.com.ar";
			$mail->Subject = "Consulta desde mi sitio web de: ".$apellido ;

			$body= "<strong>Nombre:</strong> ".$apellido."<br>";
			$body.= "<strong>Email:</strong> ".$email."<br>";
			$body.= "<strong>Asunto:</strong> ".$asunto."<br>";
			$body.= "<strong>Consulta:</strong><br>".$consulta."<br><br><br>";

			$mail->Body = $body;
			$mail->AltBody = "-";
			$mail->Timeout=20;
			//$mail->AddAddress("contacto@penarolelortondo.com");
			$mail->AddAddress("comunicacion.penarol@gmail.com");
			$exito = $mail->Send();

			$intentos=1;
			while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
			    sleep(5);
				$exito = $mail->Send();
				$intentos=$intentos+1;
			}

			if ($mail->ErrorInfo=="SMTP Error: Data not accepted") {
			 	$exito=true;
			}


			if($exito){
				echo  "@@@ Mensaje enviado correctamente. @@@ Nos contactaremos a la brevedad.";
			}else{
				echo 'Lo sentimos, hubo un inconveniente al intentar enviar el E-mail.'.$mail->ErrorInfo;
			}

		} else {
			echo "(*) Atencion! El correo ingresado es incorrecto.";
		}
	} else {
		echo "(*) Por favor complete todos los campos.";


	} // fin si trae codigo

?>
