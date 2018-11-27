<?php
	require("../db_connection.php");
	session_start();
	if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "admin" ) {
		die("Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.");
	}
	else if( empty($_GET["table_no"]) or empty($_GET["datetime"]) or !isset($_GET["sp"]) ){
		die("You should fill all the fields and come here from admin page. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back</a>.");
	}

	$table_no = $_GET["table_no"];
	$given_datetime = $_GET["datetime"];
	$given_datetime = str_replace("T"," ",$given_datetime);

	$stmt = $conn -> prepare("CALL get_waiter_count(?,?)");
	$stmt -> bind_param("ss", $table_no, $given_datetime);
	$res = $stmt -> execute();
	if($res  === false) {
		die("Error while executing stored procedure.<a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
	}
	$result = $stmt -> get_result();
	if($result->num_rows > 0) {
		$row = $result -> fetch_array();
		die("Result: " . $row[0] .". <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
	}
	else {
		die("Error while executing stored procedure.<a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");	
	}
?>
