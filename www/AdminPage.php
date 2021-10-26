<html>
<head><title>Admin Page</title></head>
<body>


<h1>Admin Page</h1>

<?php
	session_start();
	$User=$_SESSION['user'];

	include 'database.php';

	if(!isset($_SESSION['admin'])||$_SESSION['admin']==false){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	    exit;
	}
	

?>
<p><b>Add Movie:</b></p>
<form action="AdminForm.php" enctype= 'multipart/form-data' method="POST">
	Title: <input type="text" name="title">
	Description: <input type="text" name="desc">
	Length: <input type="int" name="length">
	Release Year: <input type="int" name="RY">
	Poster: <input type = "file" name="poster" accept="image/png, image/jpeg">
	<input type="submit" value="Submit"></form>
