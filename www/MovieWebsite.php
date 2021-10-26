<!DOCTYPE>

<head>
<title>I am A WEBSITE</title>
</head>

<body> 
<p><h1>Hello, this is the Home page website<h1></p>





<?php
	session_start();
	include 'database.php';
	//var_dump ($_SESSION);
	//echo '<p><a href="http://localhost/MovieRatingSite/www/Login%20Page.php">Login Page</a></p>';
	
	if(isset($_SESSION['user'])){
	echo 'Hello '; echo $_SESSION['user'];
	echo '<br>Admin Status: '; echo $_SESSION['admin'];
	echo '<p><a href="LogOut.php">LogOut</a></p>';
		if($_SESSION['admin']==true){
			echo '<p><a href="http://localhost/MovieRatingSite/www/AdminPage.php">Admin Page</a></p>';
		}
	
	}
	
	else{echo '<p><a href="http://localhost/MovieRatingSite/www/Login%20Page.php">Login Page</a></p>';
		$query=$pdo->prepare('Select Title from Movies ORDER BY Date_Added DESC');
		//$query->bindValue(':Use',$_POST['username']);
		$query->execute();

	
		while ($row = $query->fetch ())
		{
		echo $row['Title'] ,'<br>';
	
		}
	
	}
	
	
	//If ($user[‘admin’]){
		//Echo ‘Add Movie’; //Check if they are admin all the way down the line;

	
?>


</body>
