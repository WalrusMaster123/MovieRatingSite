<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	$query=$pdo->prepare('Select * from friendrequest Where Username1=:id or Username2 = :id');
		$query->bindValue(':id',$_SESSION['user']);
		$query->execute();
	while(	$row = $query->fetch ()){
	if($row['Username1']==$_GET['id']||$row['Username2']==$_GET['id']){
		echo 'A friendrequest already exists between you and this user';
		exit();
	}	
	}
	$query=$pdo->prepare('Insert into friendrequest(Username1,Username2)Values(:Val,:Us)');
	$query->bindValue(':Val',$_GET['id']);
	$query->bindValue(':Us',$_SESSION['user']);
	$query->execute();
	
	header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
?>