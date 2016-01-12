<?php

	ob_start();

	include('config.inc.php');
	include('functions.inc.php');

	$errors = array();

	// Get email in url
	$email = $_GET['email'];

	// Get timestamp in database
	$sql = 'SELECT * FROM users WHERE email = :email';

	$preparedStatement = $connexion -> prepare($sql);
	$preparedStatement -> bindValue(':email', $email);
	$preparedStatement->execute();

	$usr = $preparedStatement->fetch();
	$timestamp = $usr['timestamp'];

	// Timestamp = subscribe time
	$timestamp = strtotime($timestamp);
	// Subscribe time after 30 minutes
	$timestamp = $timestamp + (60 * 30);

	// Get current time
	date_default_timezone_set('europe/brussels') ;
	$currenttime = date('Y-m-d H:i:s') ;
	$currenttime = strtotime($currenttime) ;

	// If there is more than 30 minutes between current time and subscribe time : ERROR
	if ($currenttime > $timestamp){

		$errors['obsolete'] = "Ce lien est maintenant invalide, veuillez <a href='index.php'>vous réinscrire</a>." ;


	} else {

		// Right on time : set state to VALID
		$sql = 'UPDATE users SET state = "valid" WHERE email = :email';
        $preparedStatement = $connexion->prepare($sql);
        $preparedStatement->bindValue(':email', $email);
        $preparedStatement->execute();
        
		if($preparedStatement->execute()) {
			$feedback['success'] = "Inscription terminée, merci !" ;
		} else {
			
			// Oops
			$errors['oops'] = "Oups, une petite erreur interne, réessayez plus tard." ;
		}
	}
?>

<html>
	<head>

		<meta charset="UTF-8">		
		<title>Confirmation d'email</title>
		<link rel="stylesheet" href="assets/css/style.css">
		
	</head>

	<body>

		<a href="index.php" class="return">Accueil</a>

		<div class="container">

			<h1>Confirmation</h1>
			
			<?php
				displayFeedback('error', $errors, 'obsolete') ;
				displayFeedback('error', $errors, 'oops') ;

				displayFeedback('feedback', $feedback, 'success') ;
			?>

		</div>

	</body>
	
</html>