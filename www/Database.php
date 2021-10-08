<?php
try{
	$pdo = new PDO('mysql:host=localhost;dbname=moviereviewsite','TestUser','Walrus11');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES utf8');
	
	}
		
catch(PDOException $e){
	
	echo "Unable to connect to database";
	exit();
	
}	
	
?>