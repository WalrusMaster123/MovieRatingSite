
<?php
	include 'database.php';
	
	//echo '.$_POST['username'].';
	$password = $_POST['password'];
	$password2 = $_POST['Test'];
	if(strlen($password)>20||strlen($password2)>20){
		echo "<B>The entered password(s) exceeds max character limit<B>";
		Exit();
	}
	$EncryptedPassword = password_hash ($password,PASSWORD_BCRYPT); 
	
	//echo ($EncryptedPassword);
	
	//echo ($EncryptedPassword2);
	$sql = 'INSERT into USERS(Username,Password,Admin_Status)Values(:Username,:password,false)';
	$query=$pdo->prepare($sql);
	$query->bindValue(':Username',$_POST['username']);
	$query->bindValue(':password',$EncryptedPassword);
	
	
	
	
	$quer=$pdo->prepare('Select username from Users where username = :Use');
	$quer->bindValue(':Use',$_POST['username']);
	$quer->execute();
	$resultSet=$quer->setFetchMode(PDO::FETCH_ASSOC);
	
	if(!(empty($quer->fetch()))){
		echo "<B>The Username entered is already being used<B>";
		Exit();
	}
	
	
	
	//if($_POST['password'])
	
	if($_POST['password']!=$_POST['Test']){
		echo "<b>The passwords entered do not match<b>";
		Exit();
	}
	
	//try{
	$query->execute();
	header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;


//echo 'You entered:
//'.htmlentities($_POST['username'],ENT_QUOTES).'<br>';

?>
