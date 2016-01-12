<?php

	// Connect to database
	$host = 'localhost';
	$dbname = 'mailinglist';
	$usr = 'root';
	$pwd = 'root';

	try{
		$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
		$connexion = new PDO($dsn, $usr, $pwd);
	}catch(PDOException $e){
		echo "db error";
	}
	
