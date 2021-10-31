<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	$Movie = $_GET['id'];
	
	$query=$pdo->prepare('Insert into Comments(Text_Entered,Username,MovieID,Time_Made)Values(:Val,:Us,:Id,NOW())');
	$query->bindValue(':Val',$_POST['comment']);
	$query->bindValue(':Us',$_SESSION['user']);
	$query->bindValue(':Id',$Movie);
	
	$query->execute();
	header('Location: http://localhost/MovieRatingSite/www/MoviePage.php?id='.$Movie.'');
	exit;

?>