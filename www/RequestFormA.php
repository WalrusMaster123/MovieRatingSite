
<?php
//var_dump($POST_['name']);


session_start();
include 'database.php';

if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
if($_POST['id']==0){

	$query=$pdo->prepare('Select * from Friends WHERE (Username1 = :us OR Username2 = :us) AND (Username1 = :them OR Username2 = :them');
	//$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':them',$_POST['name']);
	$query->execute();
	if(!(empty($row=$query->fetch()))){
		$data = array();
		$data['value']="You are already friends with this user";
		echo json_encode($data);
		exit();
	}
	
	$query=$pdo->prepare('INSERT into Friends(Username1,Username2) Values(:us,:them)');
	$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':them',$_POST['name']);
	$query->execute(); 
	
	$query=$pdo->prepare('DELETE FROM friendrequest WHERE (Username1 = :us OR Username2 = :us) AND (Username1 = :them OR Username2 = :them)');
	$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':them',$_POST['name']);
	$query->execute();
	
	
		$query=$pdo->prepare('Select * from comments WHERE Username IN (Select Username2 from Friends  WHERE Username1 = :you) ORDER BY Time_Made DESC LIMIT 10');
		$query->bindValue(':you',$_SESSION['user']);
		$query->execute();
		$data = array();
		$i=0;
		while ($row = $query->fetch ())
		{		$walrs = "From ".$row['Username'].': '.$row['Text_Entered'];
				$data['value'.$i]=$walrs;
				$i=$i+1;
			}
		echo json_encode($data);
		exit();}
if($_POST['id']==1){
	
	$query=$pdo->prepare('DELETE FROM friendrequest WHERE (Username1 = :us OR Username2 = :us) AND (Username1 = :them OR Username2 = :them)');
	$query->bindValue(':us',$_SESSION['user']);
	$query->bindValue(':them',$_POST['name']);
	$query->execute();
	exit();}
	//https://stackoverflow.com/questions/45759520/ajax-response-and-php-loop
if($_POST['id']==2){
	$query=$pdo->prepare('Select * from comments WHERE Username IN (Select Username2 from Friends  WHERE Username1 = :you) ORDER BY Time_Made DESC LIMIT 10');
	$query->bindValue(':you',$_SESSION['user']);
	$query->execute();
	$data = array();
	$i=0;
	while ($row = $query->fetch ()){
		$walrs = "From ".$row['Username'].': '.$row['Text_Entered'];
				$data['value'.$i]=$walrs;
				$i=$i+1;
	}echo json_encode($data);
	exit();
}


$data = array();
		$data['value']='';
		echo json_encode($data);
		exit();
?>