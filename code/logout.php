<?php
	session_start();
	session_destroy();
	header("Location:http://localhost/restaurant/login.php");
?>