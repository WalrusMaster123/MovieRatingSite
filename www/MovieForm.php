<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	
	
	$query=$pdo->prepare('Select * from Ratings WHERE Username = :us AND MovieID = :id');
	$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	if(!(empty($row=$query->fetch()))){
		//header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
		exit();
	}
	
	if($_POST['rate']>10 || $_POST['rate']<1){
		echo "The Rating range is 1 to 10";
		exit();
	}
	
	$Movie = $_GET['id'];
	//echo $Movie;
	$query=$pdo->prepare('Insert into Ratings(Value,Username,MovieID)Values(:Val,:Us,:Id)');
	$query->bindValue(':Val',$_POST['rate']);
	$query->bindValue(':Us',$_SESSION['user']);
	$query->bindValue(':Id',$Movie);
	
	$query->execute();
	header('Location: http://localhost/MovieRatingSite/www/MoviePage.php?id='.$Movie.'');
	exit;

?>