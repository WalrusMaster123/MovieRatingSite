<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	$query=$pdo->prepare('Select * from friends Where (Username1 = :us OR Username2 = :us) AND (Username1 = :them OR Username2 = :them)');
		$query->bindValue(':us',$_SESSION['user']);
		$query->bindValue(':them',$_GET['id']);
		$query->execute();
	
	if(!(empty($row=$query->fetch()))){
		echo 'You are already friends with this user';
		exit();
	}	
	
	$query=$pdo->prepare('Select * from friendrequest Where (Username1 = :us OR Username2 = :us) AND (Username1 = :them OR Username2 = :them)');
		$query->bindValue(':us',$_SESSION['user']);
		$query->bindValue(':them',$_GET['id']);
		$query->execute();
	
	if(!(empty($row=$query->fetch()))){
		echo 'A friendrequest already exists between you and this user';
		exit();
	}	
	
	$query=$pdo->prepare('Insert into friendrequest(Username1,Username2)Values(:Val,:Us)');
	$query->bindValue(':Val',$_GET['id']);
	$query->bindValue(':Us',$_SESSION['user']);
	$query->execute();
	
	//header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	//exit;
?>