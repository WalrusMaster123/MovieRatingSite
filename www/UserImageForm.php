<?php 
	session_start();
	include 'database.php';
	
	$finfo = new finfo (FILEINFO_MIME_TYPE);
	$ftype = $finfo->file ($_FILES['pfp']['tmp_name']);
	if (filesize($_FILES['pfp']['tmp_name'])>100000){
		echo 'File size is too big, please either pick a different image or reduce its size';
		exit();
	}
	if($ftype != 'image/jpeg'){
		echo 'Not correct file type!';
		exit();
	}
	$user=$_GET['id'];
	echo $user;
	move_uploaded_file($_FILES['pfp']['tmp_name'] , 'files/'.$user.'pfp.jpg');
	
	$query=$pdo->prepare('UPDATE Users SET pfp= :UserPfp  WHERE Username = :UserID');
	$query->bindValue(':UserID',$user);
	$query->bindValue(':UserPfp',$user.'pfp');
	$query->execute();
	
	header('Location:http://localhost/MovieRatingSite/www/UserPage.php?id='.$user.'');
	exit;
	
	
	?>