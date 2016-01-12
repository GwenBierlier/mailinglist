<?php
	ob_start();

	include('../config.inc.php');
	include('../functions.inc.php');

?>

<html>
	<head>

		<meta charset="UTF-8">
		<title>Espace administration • The Mailinglist Project</title>
		<link rel="stylesheet" href="../assets/css/style.css">

	</head>
	
	<body>
		
		<a href="../index.php" class="return">Accueil</a>
		
		<div class="container admin">
			
			<?php
				$login = $_GET['login'];
				switch ($login) {
					case 'ok':
						include('dashboard.view.php');
						break;

					default:
						include('login.view.php') ;
						break;
				}
			?>

		</div>
	</body>
</html>