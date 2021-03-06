<?php 
	session_start();
	include 'database.php';
	if(!isset($_SESSION['admin'])||$_SESSION['admin']==false){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	if($_GET['id']==0){
		$query=$pdo->prepare('Select * from studio');
		$query->execute();
		while($row=$query->fetch()){
			if($_POST['Stud']==$row['Name']){
				echo 'This studio is already in the database';
				exit;
			}
		}
	$query=$pdo->prepare('Insert into studio(Name)Values(:eik)');
	$query->bindValue(':eik',$_POST['Stud']);
	$query->execute();
	
	header('Location: http://localhost/MovieRatingSite/www/AdminPage.php');
	exit;
	}
	
	if($_GET['id']==1){
		$query=$pdo->prepare('Select * from people');
		$query->execute();
		while($row=$query->fetch()){
			if($_POST['Peopl']==$row['Name']){
				echo 'This Person is already in the database';
				exit;
			}
		}
	$query=$pdo->prepare('Insert into people(Name)Values(:eik)');
	$query->bindValue(':eik',$_POST['Peopl']);
	$query->execute();
	
	header('Location: http://localhost/MovieRatingSite/www/AdminPage.php');
	exit;
	}
	
	
	$query=$pdo->prepare('Select Title, Release_Year from Movies WHERE Title = :title AND Release_Year = :ry ');
	$query->bindValue(':title',$_POST['title']);
	$query->bindValue(':ry',$_POST['RY']);
	$query->execute();
	
	$row=$query->fetch();
	if(!(empty($row['Title']))&&!(empty($row['Release_Year']))){
		echo "<B>The Movie already exists in the Database<B>"; //This is the problem one
		Exit();
	}
		
	
	
	
	$query=$pdo->prepare('Insert into Movies(Title,Description,Length,Poster,Release_Year,Date_Added)
		Values(:Title,:Description,:Length,null,:Release_Year,NOW())');//:Date_Added
	$query->bindValue(':Title',$_POST['title']);
	$query->bindValue(':Description',$_POST['desc']);
	$query->bindValue(':Length',$_POST['length']);
	$query->bindValue(':Release_Year',$_POST['RY']);
	$query->execute();
	
	$query=$pdo->prepare('Select MovieID from Movies WHERE Title = :title AND Release_Year = :ry ');
	$query->bindValue(':title',$_POST['title']);
	$query->bindValue(':ry',$_POST['RY']);
	$query->execute();
	$row=$query->fetch();
	$MovieID = $row['MovieID'];
	
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



	//update after execute
	header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;








?>






?>