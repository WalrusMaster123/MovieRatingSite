<?php
session_start();
session_unset();
session_destroy();
//Header redirect
header('Location: http://localhost/MovieRatingSite/www/MovieWebsite.php');
	exit;
?>