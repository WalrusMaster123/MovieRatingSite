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
		Exit();
	}
		
	
	If (!password_verify($Password,$Thing)){
		echo '<b>Password does not match user password<b>';
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
