<h2>

<?php 
	session_start();
	include 'database.php';
	
	echo $_GET['id'],"'s Profile Page",'<br><br>';
	//$query=$pdo->prepare('Select * from comments WHERE Username IN (Select Username2 from Friends  WHERE Username1 = :you) ORDER BY //Time_Made DESC LIMIT 10'); 
	$query=$pdo->prepare('Select * from ratings WHERE Username =:un ORDER BY Time_Made DESC LIMIT 10');
		$query->bindValue(':un',$_GET['id']);
		$query->execute();
		echo 'Recently Rated Movies: ','<br>';
		while($row = $query->fetch()){
			//echo $row['Username'];
			$quer=$pdo->prepare('Select * from movies WHERE MovieID =:un');
			$quer->bindValue(':un',$row['MovieID']);
			$quer->execute();
			
			while($rowa = $quer->fetch()){
				echo "This User rated ",$rowa['Title'],": ",$row['Value']," out of 10","<br>";
			}
		}
	
	echo '<br>','Friends of user: ','<br>';
	
	$query=$pdo->prepare('Select * from friends WHERE Username1 =:un OR  Username2 =:un');
		$query->bindValue(':un',$_GET['id']);
		$query->execute();
		while($row = $query->fetch()){
			if($row['Username1'] != $_GET['id']){
				echo $row['Username1'],"<br>";
			}
			
			if($row['Username2'] != $_GET['id']){
				echo $row['Username2'],"<br>";
			}
		}
		
	if($_GET['id']==$_SESSION['user']){
		?>
		<p><b>Add picture</b></p>
		<form action="UserImageForm.php?id=<?php echo $_GET['id'] ?>" enctype= 'multipart/form-data' method="POST">
		Upload Profile Picture:<input type = "file" name="pfp" accept="image/png, image/jpeg">
		<input type="submit" value="Submit"></form>
		
		<?php
	}
	$query=$pdo->prepare('Select pfp from users WHERE username = :fre');	
	$query->bindValue(':fre',$_GET['id']);
	$query->execute();
	$row=$query->fetch(); 
	$PfpID = $row['pfp'];
	//$MovieID = $row['MovieID'];
	$image = imagecreatefromjpeg ('files/'.$PfpID.'.jpg');
	$width = imagesx ($image);
	$height = imagesy ($image);
	$thumbHeight =250;
	$thumbWidth = 250;//floor ($width * ($thumbHeight/$height));
	$thumbnail = imagecreatetruecolor ($thumbWidth, $thumbHeight);
	imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
	$thumbName='files/'.$PfpID.'.jpg';
	imagejpeg ($thumbnail, $thumbName); 
	echo "<img src= 'files/".$PfpID.".jpg'>";
	?>
</h2>