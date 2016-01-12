<?php

	require('lib/PHPMailerAutoload.php');

	include('config.inc.php');
	include('functions.inc.php');

	ob_start();

	$errors = array() ;
	$feedback = array() ;
	$p = $_POST ;

	if ($p) {

		// Honeypot
		if(!empty($p['user_email'])) {
			die ("Interdit : SPAM") ;
		}

		// Clean
		$email = trim(strip_tags($p['email'])) ;
		
		// Validation
		if (is_valid_email($email) == false ) {
			$errors['email'] = "Veuillez entrer une adresse email valide." ;
		}

		// If email is already in the database
		$sql = 'SELECT * FROM users WHERE email = :email';

		$preparedStatement = $connexion -> prepare($sql);
		$preparedStatement -> bindValue(':email', $email);
		$preparedStatement->execute();
		if( $preparedStatement->fetch() ) {
			$errors['already'] = "Vous êtes déjà inscrit à la newsletter avec cette adresse mail." ;
		}

		// Si tout est OK, 
		if(empty($errors)) {
			$timestamp = date('Y-m-d H:i:s');
			$sql = "INSERT INTO users(email, role, timestamp) VALUES(:email, :role, :timestamp)";

			$preparedStatement = $connexion->prepare($sql);
			$preparedStatement->bindValue(':email', $email);
			$preparedStatement->bindValue(':role', "lecteur");
			$preparedStatement->bindValue(':timestamp', $timestamp);
			
			if($preparedStatement->execute()){

	// Messages automatiques
	$message = '<p>Bonjour, veuillez <a href="localhost:8888/examen/confirm.php?email='.$email.'">confirmer votre adresse mail</a>.' ;
	$messagetxt = 'Bonjour, confirmez votre adresse mail en vous rendant à cette adresse : localhost:8888/examen/confirm.php?email='.$email.'">' ;

				sendConfirm($email, "The Mailinglist Project - Confirmer votre adresse mail.", $message, $messagetxt);
				$feedback['success'] = "Merci de votre inscription ! Veuillez confirmer votre adresse au plus vite dans le mail que nous venons de vous envoyer. 👍";
			
			}
		}
	}
?>

<html>
	<head>

		<meta charset="UTF-8">
		<title>The Mailinglist Project</title>
		<link rel="stylesheet" href="assets/css/style.css">

	</head>
	
	<body class="landing">
		<div class="container register-email">
			
			<a class="admin-log" href="admin/index.php">Espace administration</a>
			
			<h1>Inscription à la mailinglist</h1>
			
			<form method="POST" class="register">
				<ol>
					<li>
						<label for="email">Entrez votre adresse email pour vous inscrire</label>
						<input type="email" id="email" name="email" placeholder="david.bowie@mail.co" value="
						<?php if($p) { echo $email ; } ?>">
					</li>

					<li>
						<label class="user_email" for="user_email">Entrez votre adresse mail</label>
						<input class="user_email" type="text" id="user_email" name="user_email">
					</li>

					<li>
						<input type="submit" value="S'inscrire" name="submit">
					</li>
				</ol>
			</form>

			<?php
				if($p) {
					displayFeedback('error', $errors, 'email') ;
					displayFeedback('error', $errors, 'already') ;

					displayFeedback('feedback', $feedback, 'success') ;
				}
			?>
		</div>
	</body>
</html>