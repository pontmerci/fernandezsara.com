<?php
	function check_email_address($email)
	{
		// Primero, checamos que solo haya un símbolo @, y que los largos sean correctos
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
		{
			// correo inválido por número incorrecto de caracteres en una parte, o número incorrecto de símbolos @
		return false;
	  }
	  // se divide en partes para hacerlo más sencillo
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++)
		{
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
			{
		  return false;
		}
	  }
	  // se revisa si el dominio es una IP. Si no, debe ser un nombre de dominio válido
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

	require("class.phpmailer.php");
	require("class.smtp.php");

// fin function formRegistro()

// verificamos si se han enviado ya las variables necesarias.

	if (isset($_POST["correo"]) && $_POST["correo"]!='' )
	{
		$nombre = $_POST["nombre"];
		$correo = $_POST["correo"];
		$asunto = $_POST["asunto"];
		$consulta = $_POST["consulta"];

		//include ("consola/includes/abrir_conexion.php");
		$paso = 'S';

		if (check_email_address($correo)) {

			$mail = new PHPMailer();
			//Luego tenemos que iniciar la validación por SMTP:
			$mail->IsSMTP();
			$mail->Host = "localhost"; //"localhost";
			//$mail->SMTPDebug  = 2;
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier

			$mail->Username = "mail.fernandezsara.com"; // Correo completo a utilizar
			$mail->Password = "Munecos2016"; // Contraseńa
			//$mail->Port = 465; // Puerto a utilizar
			$mail->Port = 587;

			$mail->From = "yo@fernandezsara.com";
			$mail->FromName = "Consulta desde fernandezsara.com";
			$mail->Subject = "Consulta de:".$nombre;
			//$mail->AddAddress($_POST['destino']);
			$mail->AddAddress("yo@fernandezsara.com");
			//$mail->AddCC("contacto@.com.ar");

			$body= "<strong>Nombre y Apellido:</strong> ".$nombre."<br><br>";
			$body.= "<strong>Email:</strong> ".$correo."<br><br>";
			$body.= "<strong>Asunto:</strong> ".$asunto."<br><br>";
			$body.= "<strong>Consulta:</strong><br>".$consulta."<br><br><br>";

			$body.= "<i>Enviado desde Fernandezsara.com</i>";
			$mail->Body = $body;
			$mail->IsHTML(true);
			$exito = $mail->Send(); // Envía el correo.
			if($exito){
				$msg = "Mensaje enviado correctamente. Nos contactaremos a la brevedad.";
			}else{
				//echo 'Lo sentimos, hubo un inconveniente al intentar enviar el E-mail.';
				$msg = 'Lo sentimos, hubo un inconveniente al intentar enviar el E-mail.'; //$mail->ErrorInfo;
			}
			echo $msg;
			$estado = 'P';
			/*$query = 'INSERT INTO adj_contactos (correo, nombre, tel, celular, horario, localidad, observaciones, estado, fecha, hora, profesion, tipo)
			VALUES (\''.$correo.'\',\''.$nombre.'\',\''.$telefono.'\',\'\',\'\',\'\',\''.$consulta.'\',\''.$estado.'\',\''.date("Y-m-d").'\',\''.date("H:i:s").'\',\''.$asunto.'\', \'MAIL\' )';

			mysql_query($query) or die(mysql_error());*/

			//echo $nombre.".".$apellido;
		} else {
			echo "(*) Atencion! El correo ingresado es incorrecto.";
		}
	} else {
		echo "(*) Debe completar los campos requeridos.";

	} // fin si trae codigo
	//echo json_encode($_POST);
?>
