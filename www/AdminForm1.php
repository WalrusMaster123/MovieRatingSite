
<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['admin'])||$_SESSION['admin']==false){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	$query=$pdo->prepare('SELECT * from Movies WHERE MovieID = :id');
	$query->bindValue(':id',$_GET['id']);
	$query->execute();
	$row=$query->fetch();
	//$MovieID = null;
	//echo $MovieID;
	//while($row=$query->fetch()){
	//
	$MovieID = $row['MovieID'];
	
	//}
	
	$query=$pdo->prepare('UPDATE Movies SET Title = :Title, Description = :Description, 
		Length = :Length, Release_Year = :Release_Year WHERE MovieID = :Th');
	$query->bindValue(':Title',$_POST['title']);
	$query->bindValue(':Description',$_POST['desc']);
	$query->bindValue(':Length',$_POST['length']);
	$query->bindValue(':Release_Year',$_POST['RY']);
	$query->bindValue(':Th',$MovieID);
	$query->execute();
	
	
	$finfo = new finfo (FILEINFO_MIME_TYPE);
	$ftype = $finfo->file ($_FILES['poster']['tmp_name']);
	if (filesize($_FILES['poster']['tmp_name'])>100000){
		echo 'File size is too big, please either pick a different image or reduce its size';
		exit();
	}
	if($ftype != 'image/jpeg'){
		echo 'Not correct file type!';
		exit();
	}
	//$location = "files/";
	move_uploaded_file($_FILES['poster']['tmp_name'] , 'files/'.$MovieID.'.jpg');
	$query=$pdo->prepare('UPDATE Movies SET Poster= :MovieID  WHERE MovieID = :MovieID');
	$query->bindValue(':MovieID',$MovieID);
	$query->execute();

	$query=$pdo->prepare('SELECT * from genres');
	$query->execute();
	while($row=$query->fetch()){
	if($_POST['Genr']==$row['GenreName']){
		//echo $row['GenreName'];
		if($_POST['Genr']!= null){
		$quer=$pdo->prepare('SELECT * from hasgenre WHERE MovieID = :id');
		$quer->bindValue(':id',$_GET['id']);
		$quer->execute();
		while($rowa= $quer->fetch()){
			
			if($_POST['Genr'] == $rowa['GenreName']){
			echo 'This Movie already has that genre'; 
			exit;
		}
		}
		$query=$pdo->prepare('Insert into hasgenre(GenreName,MovieID)
		Values(:yo,:dude)');
		$query->bindValue(':yo',$_POST['Genr']);
		$query->bindValue(':dude',$_GET['id']);
		$query->execute();
	}
		
	}
	}
	$query=$pdo->prepare('SELECT * from people');
	$query->execute();
	while($row=$query->fetch()){
		
	if($_POST['Peop']==$row['Name']){
	$quer=$pdo->prepare('SELECT * from people WHERE PersonID IN(Select PersonID from workedin WHERE MovieID = :id)');
	$quer->bindValue(':id',$_GET['id']);
	$quer->execute();
	$va=null;
	while($rowa=$quer->fetch()){
	if($row['Name']==$_POST['Peop']){
		echo 'This person is already linked to this movie';
		exit;
		}
		
	}
	}
		
	
	if($_POST['Peop']!= null && $_POST['Peop']==$row['Name']){
	$query=$pdo->prepare('Insert into workedin(PersonID,MovieID)
		Values(:yo,:dude)');
		$query->bindValue(':yo',$row['PersonID']);
		$query->bindValue(':dude',$_GET['id']);
		$query->execute();
	}
	}
	
	$query=$pdo->prepare('SELECT * from studio');
	$query->execute();
	while($row=$query->fetch()){
	
	if($_POST['Studio']==$row['Name']){
	$quer=$pdo->prepare('SELECT * from studio WHERE Name IN(Select Name from produced WHERE MovieID = :id)');
	$quer->bindValue(':id',$_GET['id']);
	$quer->execute();
	while($rowa=$quer->fetch()){
		
	if($rowa['Name']==$_POST['Studio']){
		echo 'This Studio is already linked to this movie';
		exit;
		}
		
	}
	}
	if($_POST['Studio']!= null && $_POST['Studio']==$row['Name']){
	$query=$pdo->prepare('Insert into produced(Name,MovieID)
		Values(:yo,:dude)');
		$query->bindValue(':yo',$row['Name']);
		$query->bindValue(':dude',$_GET['id']);
		$query->execute();
	}
	}
	
	
		//echo $_POST['Genr'];
	//echo $row['GenreName'];
	$e=$_GET['id'];
	//update after execute
	header("Location: http://localhost/MovieRatingSite/www/MoviePage.php?id=$e");
	exit;
	//header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	//exit;








?>