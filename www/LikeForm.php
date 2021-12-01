<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	$query=$pdo->prepare('Select * from Likes WHERE Username = :us AND CommentID = :id');
	$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	if(!(empty($row=$query->fetch()))){
		echo 'You have already liked this comment';
		exit();
	}
	
	$query=$pdo->prepare('Insert into Likes(Username,CommentID)Values(:Val,:Id)');
	$query->bindValue(':Val',$_SESSION['user']);
	$query->bindValue(':Id',$_GET['id']);
	$query->execute();
	header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	//Possibly use AJax if you have time.
?>