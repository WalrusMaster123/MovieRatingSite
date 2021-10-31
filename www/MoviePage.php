<!DOCTYPE>

<head>
<title>I am A WEBSITE</title>
</head>

<body> 
<?php

	session_start();
	include 'database.php';
	
	//$id=$_GET['movie'];
	$query=$pdo->prepare('Select * from Movies WHERE MovieID = :id');
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	while ($row = $query->fetch ())
	{
	echo 'Title: ',$row['Title'], '<br>'; 
	echo 'Movie Description: ',$row['Description'],'<br>';
	echo 'Length: ',$row['Length'],'<br>';
	echo 'Year of Release: ',$row['Release_Year'],'<br>';
	
	$PosterID = $row['Poster'];
	$MovieID = $row['MovieID'];
	
	//$Thing = $row['Poster'];
	//echo "<img src= 'files/80.jpg'>";
	$image = imagecreatefromjpeg ('files/'.$PosterID.'.jpg');
	$width = imagesx ($image);
	$height = imagesy ($image);
	$thumbHeight =500;
	$thumbWidth = floor ($width * ($thumbHeight/$height));
	$thumbnail = imagecreatetruecolor ($thumbWidth, $thumbHeight);
	imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
	$thumbName='files/'.$MovieID.'.jpg';
	imagejpeg ($thumbnail, $thumbName); 
	echo "<img src= 'files/".$PosterID.".jpg'>";
	
	}
	// echo $row['MovieID'];
	
	//if((empty($row=$query->fetch()))){
		//header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	//}
	$test = 0;
	$query=$pdo->prepare('Select Value from Ratings WHERE MovieID = :id');
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	while ($row = $query->fetch ()){
	
		$test = $test + $row['Value'];
		
	}
	$query=$pdo->prepare('Select COUNT(*) from Ratings WHERE MovieID = :id');
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	$row = $query->fetch ();	
	$Wal = $test / $row['COUNT(*)'];
	echo '<br><br>','Overall Rating: ',$Wal,' out of 10','<br>';
	
	if(isset($_SESSION['user'])){
	$query=$pdo->prepare('Select Value from Ratings WHERE Username = :us AND MovieID = :id');
	$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	}
	
	if(isset($_SESSION['user']) && (empty($row=$query->fetch())) ){
		?>
	<p><b>RateMovie:</b></p>
	<form action="MovieForm.php?id=<?php echo $_GET['id']?>" method="POST">
	Rating: <input type="int" maxlength = "10" name="rate">
	<input type="submit" value="Submit"></form>
	<br>

	<?php
	}
	elseif(isset($_SESSION['user'])){
		//$row=$query->fetch();
		echo '<br>','You rated this movie: ',$row['Value'],' out of 10';
	}
	if(isset($_SESSION['user'])){
		?>
	<p><b>Leave a Comment:</b></p>
	<form action="MovieForm1.php?id=<?php echo $_GET['id']?>" method="POST">
	Enter text here: <input type="text" name="comment">
	<input type="submit" value="Submit"></form>
	<?php
	}
	
	//$query=$pdo->prepare('Select * from friendrequest Where Username1=:id or Username2 = :id');
	//$query->bindValue(':id',$_SESSION['user']);
	//$query->execute();
	
	echo "<br>","Comments:";
	$query=$pdo->prepare('Select * from Comments Where MovieID=:id ORDER BY Time_Made DESC LIMIT 10');
	$query->bindValue(':id',$MovieID);
	$query->execute();
	while ($row = $query->fetch ()){	
		echo '<br>','From: ',$row['Username'],": ",$row['Text_Entered'];
		if($_SESSION['user']!=$row['Username']){
		?> <form action="MovieForm2.php?id=<?php echo $row['Username']?>" method="POST">
		<input type="submit" value="Friend Request"></form><?php
		}
	}
	
?>
</body>