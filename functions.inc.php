<?php

	// Msg error
	function displayFeedback($class, $e, $input) {
		echo "<p class=$class>$e[$input]</p>" ;
	}
	
	// Check email valid
	function is_valid_email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL) ;
	}
	
	// Send confirmation link
	function sendConfirm($email, $subject, $message, $messagetxt) {

		$mail = new PHPMailer;

		$mail->isSMTP();									// Set mailer to use SMTP
		$mail->Host = 'smtp.mandrillapp.com';				// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;								// Enable SMTP authentication
		$mail->Username = 'alexandre@pixeline.be';            // SMTP username
		$mail->Password = 'bDMUEuWn1H4r3FCGQjyO-g';			// SMTP password
		$mail->SMTPSecure = 'tls';							// Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;									// TCP port to connect to

		$mail->setFrom('mail@mail.co', 'Admin');
		$mail->addAddress($email, $email);     				// Add a recipient

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $messagetxt;

		if(!$mail->send()) {
		    echo "Le message ne s'est pas envoyé correctement, veuillez réessayer.";
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}