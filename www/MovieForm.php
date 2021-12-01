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
	
	if($_POST['rate']>10 || $_POST['rate']<1){
		echo "The Rating range is 1 to 10";
		exit();
	}
	if(!(empty($row=$query->fetch()))){
		$query=$pdo->prepare('UPDATE Ratings SET Value = :thi WHERE Username = :us AND MovieID = :id ');
		$query->bindValue(':us',$_SESSION['user']);
		$query->bindValue(':id',$_GET['id']);
		$query->bindValue(':thi',$_POST['rate']);
		$query->execute();
		$Movie = $_GET['id'];
		header('Location: http://localhost/MovieRatingSite/www/MoviePage.php?id='.$Movie.'');
		exit;
	}
	
	$Movie = $_GET['id'];
	//echo $Movie;
	$query=$pdo->prepare('Insert into Ratings(Value,Username,MovieID,Time_Made)Values(:Val,:Us,:Id,NOW())');
	$query->bindValue(':Val',$_POST['rate']);
	$query->bindValue(':Us',$_SESSION['user']);
	$query->bindValue(':Id',$Movie);
	
	$query->execute();
	header('Location: http://localhost/MovieRatingSite/www/MoviePage.php?id='.$Movie.'');
	exit;

?>