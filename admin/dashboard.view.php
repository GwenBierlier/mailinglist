<?php
	ob_start();
	include('../config.inc.php');
?>

<a class="admin-log" href="logout.php">Se déconnecter</a>

<h1>Abonnés</h1>

<?php

	$sql = 'SELECT * FROM users' ;
	$query = $connexion->prepare($sql);
	$query->execute();

	$result = $query->fetchAll();
	$result = array_reverse($result);

?>

<ul class="list">
	<?php
		foreach($result as $m) {
	?>
	
		<li><?php echo $m['email'] ; ?></li>
	
	<?php			
		}
	?>
</ul>

