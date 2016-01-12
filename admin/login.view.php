<?php
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
		$password = trim(strip_tags($p['password'])) ;		

		// Validation
		if ($email == '') {
			$errors['email'] = "Veuillez entrer votre email." ;
		}

		if ($password == '') {
			$errors['password'] = "Veuillez entrer votre mot de passe." ;
		}

		// EMAIL + PASSWORD = correct ?
		if(empty($errors)) {
			$sql = "SELECT * FROM users WHERE email = :email AND password = :password" ;
			$preparedStatement = $connexion->prepare($sql);
            $preparedStatement->bindValue(':email', $email);
            $preparedStatement->bindValue(':password', $password);
            $preparedStatement->execute();

            $user = $preparedStatement->fetch();

			// incorrect
			if (empty($user)) {
				$errors['wrong_password'] = 'Le login et le mot de passe ne correspondent pas';

			// Bingo
			} else {
				header("Location: index.php?login=ok");
				$_SESSION['logged-in'] = "ok";
			}
		}
	}
?>

			<form method="POST" class="login">

				<legend>Log in</legend>

				<ol>
					<li>
						<label for="email">Adresse email</label>
						<input type="email" id="email" name="email" value="<?php if($p) { echo $email ; } ?>" placeholder="admin@mail.co">
						<?php if($p) { displayFeedback('error', $errors, 'email') ; } ?>
					</li>

					<li>
						<label for="password">Mot de passe</label>
						<input type="password" id="password" name="password" placeholder="admin">
						<?php if($p) { displayFeedback('error', $errors, 'password') ; } ?>
					</li>

					<li>
						<label class="user_email" for="user_email">Entrez votre adresse mail</label>
						<input class="user_email" type="text" id="user_email" name="user_email">
					</li>

					<li>
						<input type="submit" value="Connexion" name="submit">
					</li>
				</ol>
			</form>
			
			<?php if($p) { displayFeedback('error', $errors, 'wrong_password') ; } ?>
