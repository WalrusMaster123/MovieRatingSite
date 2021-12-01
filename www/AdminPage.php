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
	
	if(isset($_GET['id'])){
		$w = $_GET['id'];
		
		?>
		<p><b>Update Movie:</b></p>
	<form action="AdminForm1.php?id=<?php echo$w?>" enctype= 'multipart/form-data' method="POST">
		Title: <input type="text" name="title">
		Description: <input type="text" name="desc">
		Length: <input type="int" name="length">
		Release Year: <input type="int" name="RY">
		Genre: <input type="text" name="Genr">
		Studio:<input type="text" name="Studio">
		People who Worked on it: <input type="text" name="Peop">
		Poster: <input type = "file" name="poster" accept="image/png, image/jpeg">
		<input type="hidden" name="MAX_FILE_SIZE" value="25000">
		<input type="submit" value="Submit"></form>
		<?php
	}
	else{
		?>
		<p><b>Add Movie:</b></p>
<form action="AdminForm.php" enctype= 'multipart/form-data' method="POST">
	Title: <input type="text" name="title">
	Description: <input type="text" name="desc">
	Length: <input type="int" name="length">
	Release Year: <input type="int" name="RY">
	Poster: <input type = "file" name="poster" accept="image/png, image/jpeg">
	<input type="hidden" name="MAX_FILE_SIZE" value="25000">
	<input type="submit" value="Submit"></form>
	
	<form action="AdminForm.php?id=<?php echo '0' ?>" enctype= 'multipart/form-data' method="POST">
	New Studio:<input type="text" name="Stud">
	<input type="submit" value="Submit"></form>
	
	<form action="AdminForm.php?id=<?php echo '1' ?>" enctype= 'multipart/form-data' method="POST">
	New Person:<input type="text" name="Peopl">
	<input type="submit" value="Submit"></form>
		<?php
	}

?>