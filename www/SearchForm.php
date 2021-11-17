<head>
<title>I am A WEBSITE</title> 
</head>

<body> 
<p><h1>Search Page<h1></p>

<form action="SearchForm.php" enctype= 'multipart/form-data' method="POST">
	Search: <input type="text" name="Search">
		<input type="submit" value="Submit"></form>


<?php 
	session_start();
	include 'database.php';

	$Thing ='%'.$_POST['Search'].'%';
	$query=$pdo->prepare('Select * from Movies WHERE Title LIKE :sr');
	$query->bindValue(':sr',$Thing);
	$query->execute();
	while ($row = $query->fetch ())
		{
		$movie = $row['MovieID'];	
		$title = $row['Title'];	
		echo'<p><a href = "http://localhost/MovieRatingSite/www/MoviePage.php?id='.$movie.'">'.$title.'</a></p>';
			}
?>
</body>