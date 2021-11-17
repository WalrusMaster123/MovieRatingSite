<!DOCTYPE>

<head>
<title>I am A WEBSITE</title> 
<style>


</style>
</head>

<body> 

<!-- <ul style="list-style-type: none;
  margin: 0;
  padding: 0;
   background-color: #dddddd;
text-align: center";>
  <li style="display: inline;padding: 45px;font-size: 60";><a href="http://localhost/MovieRatingSite/www/AdminPage.php">Home</a></li>
  <li style="display: inline;padding: 45px;font-size: 60";><a href="news.asp">News</a></li>
  <li style="display: inline;padding: 45px;font-size: 60";><a href="contact.asp">Contact</a></li>
  <li><form action="SearchForm.php" enctype= 'multipart/form-data' method="POST">
	Search: <input type="text" name="Search">
		<input type="submit" value="Submit"></form></li>
</ul>
-->
<p><h2>Hello, this is the Home page website<h2></p>

<form action="SearchForm.php" enctype= 'multipart/form-data' method="POST">
	Search: <input type="text" name="Search">
		<input type="submit" value="Submit"></form>
		


<?php
	session_start();
	include 'database.php';
	//var_dump ($_SESSION);
	//echo '<p><a href="http://localhost/MovieRatingSite/www/Login%20Page.php">Login Page</a></p>';
	
	//Anytime you list a username, list a link to the user's profile. Maybe make a function where it auto does the link.
	
	if(isset($_SESSION['user'])){
	echo 'Hello '; echo $_SESSION['user'];
	//echo '<br>Admin Status: '; echo $_SESSION['admin'];
	echo '<p><a href="LogOut.php">LogOut</a></p>';
		if($_SESSION['admin']==true){
			echo '<p><a href="http://localhost/MovieRatingSite/www/AdminPage.php">Admin Page</a></p>';
		}	
		$query=$pdo->prepare('Select Title,MovieID from Movies ORDER BY Date_Added DESC LIMIT 10');
		//$query->bindValue(':Use',$_POST['username']);
		$query->execute();	
		
			
		while ($row = $query->fetch ())
		{	
		$movie=$row['MovieID'];
		$title=$row['Title'];
		
		
		echo  '<p><a href = "http://localhost/MovieRatingSite/www/MoviePage.php?id='.$movie.'">'.$title.'</a></p>';
		}
		
		
		$query=$pdo->prepare('Select * from comments WHERE Username IN (Select Username2 from Friends  WHERE Username1 = :you) ORDER BY Time_Made DESC LIMIT 10');
		$query->bindValue(':you',$_SESSION['user']);
		$query->execute();
		?>
		Friend Activity:<li id="lineItem" style="display:none;list-style-type:none;">Nothing to see here</li>
		<ul id="container"><?php
		while($row = $query->fetch ()){
			echo '<li id="lineItem" style="list-style-type:none;">',"From ".$row['Username'].': '.$row['Text_Entered'],'</li>';
		}?>
		</ul><script> 
			
			
			$(document).ready( function(){ 
				$.post( "RequestFormA.php", { name: "<?php echo $use2?>" , id: 2 })
				.done(function(data) {
				$("#container").empty();
	  //$.each(data, function (index,element){
				data=JSON.parse(data);
				$.each(data, function (index,element){
	//alert( "Data Loaded: "+ (data.value));
				alert( "Data Loaded: "+ (element));
				var lineItem = $("#lineItem").clone ();
				lineItem.text(element);
				$("#container").append(lineItem);
				lineItem.fadeIn ();
	//$("#Invis").text(data.value);
		});
		});
		});
			
			
			</script>
			
		
		
		
		<?php
		
		$query=$pdo->prepare('Select * from friendrequest WHERE Username1 = :un OR Username2 = :un');
		$query->bindValue(':un',$_SESSION['user']);
		$query->execute();
		?><script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script> <?php
		while ($row = $query->fetch ())
		{	
			if($_SESSION['user']==$row['Username1']){
				$use2 = $row['Username2'];
			?><p id=Req<?php echo $use2?>>Friend Request from <?php echo $row['Username2'];?></p><p style="font-size: 20px" id=Invis></p><?php
			?> <button id=Accept<?php echo $use2?>>Accept</button>
			<button id=Reject<?php echo $use2?>>Reject</button>  <?php
			}
?>
<script>

$(document).ready( function(){ 
 
$("#Accept<?php echo $use2?>").click(function(){
//$("#Hi").hide(); 
//$.getJSON("RequestFormA.php?id="<?php echo $use2?>"", function(data){
	//$("#Invis").text(JSON.stringify(data.value));
//});

  $("#Req<?php echo $use2?>").hide();
  $("#Accept<?php echo $use2?>").hide();
  $("#Reject<?php echo $use2?>").hide(); 
  $.post( "RequestFormA.php", { name: "<?php echo $use2?>" , id: 0 })
  .done(function(data) {
	  $("#container").empty();
	  //$.each(data, function (index,element){
    data=JSON.parse(data);
	$.each(data, function (index,element){
	//alert( "Data Loaded: "+ (data.value));
	alert( "Data Loaded: "+ (element));
	var lineItem = $("#lineItem").clone ();
				lineItem.text(element);
				$("#container").append(lineItem);
				lineItem.fadeIn ();
	//$("#Invis").text(data.value);
	});
	 });
  });

$("#Reject<?php echo $use2?>").click(function(){

 $("#Req<?php echo $use2?>").hide();
  $("#Accept<?php echo $use2?>").hide();
  $("#Reject<?php echo $use2?>").hide(); 
$.post( "RequestFormA.php", { name: "<?php echo $use2?>" , id: 1 })
  .done(function(data) {
	//alert(JSON.stringify(data));
});
});
});
</script><?php
			//if($_SESSION['user']==$row['Username2']){
			//echo 'Friend Request from ',$row['Username1'];
			//}
		}
	}
	
	
	else{echo '<p><a href="http://localhost/MovieRatingSite/www/Login%20Page.php">Login Page</a></p>';
		$query=$pdo->prepare('Select Title,MovieID from Movies ORDER BY Date_Added DESC LIMIT 10');
		//$query->bindValue(':Use',$_POST['username']);
		$query->execute();	

		while ($row = $query->fetch ())
		{	
		$movie=$row['MovieID'];
		$title=$row['Title'];
		
		
		echo  '<p><a href = "http://localhost/MovieRatingSite/www/MoviePage.php?id='.$movie.'">'.$title.'</a></p>';
		}
	
	}
	
	
	//If ($user[‘admin’]){
		//Echo ‘Add Movie’; //Check if they are admin all the way down the line;
//javascript.post specifiy varibles you send. Works outside of php, still get JSON but specify format. Send post data with JSON.
	//echo $use2;
?>


</body>
