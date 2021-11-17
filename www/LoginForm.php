<?php 

include 'database.php';
$userid = $_POST['username'];
$Password = $_POST['password'];
$Thing=null;
//Lookup user in db by userid
$query=$pdo->prepare('Select password from Users WHERE username = :Use');
	$query->bindValue(':Use',$_POST['username']);
	$query->execute();

	while ($row = $query->fetch ())
	{
	$Thing=$row['password'];
	//echo $row['password'].'<br>';
	//echo $Thing;
	}
	
	$query=$pdo->prepare('Select password from Users WHERE username = :Use');
	$query->bindValue(':Use',$_POST['username']);
	$query->execute();

	if((empty($row=$query->fetch()))){
		echo "<B>The Username entered is not in the database<B>";
		exit();
	}
	
	$query=$pdo->prepare('Select TIMESTAMPDIFF(SECOND,FailLog,NOW()) as thing from Users WHERE username = :Use');
	$query->bindValue(':Use',$_POST['username']);
	$query->execute();
	$row = $query->fetch ();
	 
	$want = $row['thing']; 
		//TimestampDiff sql  units you want differance starting time(database) Endingtime NOW(); get back seconds.
		
	if($want != null && $want < 20){
		echo 'This account has been temporarly delayed for login, login will available 20 seconds after the failed login.';
		exit();
	}
	
	
	 
	
	If (!password_verify($Password,$Thing)){
		echo '<b>Password does not match user password, try again in 20 seconds.<b>';
		$query=$pdo->prepare('Update Users SET FailLog = NOW() WHERE username = :Use');
		$query->bindValue(':Use',$_POST['username']);
		$query->execute();
		Exit();
	};
	
	$query=$pdo->prepare('Select Admin_Status from Users WHERE username = :Use');
	$query->bindValue(':Use',$_POST['username']);
	$query->execute();
	
	$Admin=null;
	while ($row = $query->fetch ())
	{
	$Admin=$row['Admin_Status'];
	
	}
	
	
	If (password_verify($Password,$Thing)){
	Session_start();
	Session_Regenerate_id(true);
	$_SESSION['user'] = $userid;
	$_SESSION['admin'] = $Admin;
	//echo 'It worked!';
	header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	};
?>
