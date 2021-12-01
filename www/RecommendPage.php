<h2>Based on your friends ratings, we recommned you watch:
<?php 
	session_start();
	include 'database.php';
	
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
	}
	
	$query=$pdo->prepare('Select Title,Movies.MovieID as wal,COUNT(*) as MovieCount from Movies,ratings,friends WHERE Movies.MovieID = Ratings.MovieID AND ((ratings.Username = friends.Username1 AND friends.Username2 = :un) OR (ratings.Username = friends.Username2 AND friends.Username1 = :un) ) AND ratings.value = 10 GROUP BY wal ORDER BY MovieCount DESC');
	// WHERE MovieID IN(Select MovieID from Ratings WHERE value = 10 AND Movies.Username =)');
		$query->bindValue(':un',$_SESSION['user']);
		$query->execute();
		while($row = $query->fetch()){
			//if($row['Username1']==$_GET['id']){
				//echo $row['Username2'];}
			//if($row['Username2']==$_GET['id']){
				//echo $row['Username1'];}
				echo "<br>";
				
				$thi = $row['wal'];
				$title = $row['Title'];
				echo  '<p><a href = "http://localhost/MovieRatingSite/www/MoviePage.php?id='.$thi.'">'.$title.'</a></p> based on ',$row['MovieCount'],' of your friends rating it 10 out of 10';
				//echo $row['MovieCount'];
		}
		//Need info from ratings movies and friends. If Rating from Friend is 10 then list movie.
		//Select * from comments WHERE Username IN (Select Username2 from Friends  WHERE Username1 = :you)
		//only max score matters, group by and inner joins.
	?></h2>