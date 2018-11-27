<?php
	require("../db_connection.php");	

	session_start();
	if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "head-waiter" ) {
		die("Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.");

	}
	else if( empty($_POST["waiter_name"])  or  (!isset($_POST["add_button"]) and !isset($_POST["delete_button"])) ){
		die("You should fill the required fields and come here from head-waiter home page. Please <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>go back</a>.");
	}
	$waiter_name 	= $_POST["waiter_name"];
	$table_no  		= $_POST["table_no"];
	$start_time 	= $_POST["start_time"];
	$end_time 		= $_POST["end_time"];

	if(isset($_POST["add_button"])) {
		date_default_timezone_set('Europe/Istanbul');
		$start_time = str_replace("T"," ",$start_time);
		$end_time   = str_replace("T"," ",$end_time);
		$now = date("Y-m-d H:i:s");

		if(empty($_POST["table_no"]) or empty($_POST["start_time"]) or empty($_POST["end_time"])) {
			die("You should enter all the fields. Please <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>go back and try again</a>.");
		}
		else if( $start_time >= $end_time) {
			die("End time of the assignment shoul be greater than start time of the assignment. Please <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>go back and try again</a>.");
		}
		else if( $start_time < $now or  $end_time <= $now ) {
			die("End time and start time of the assignment cannot be earlier than now. Please <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>go back and try again</a>.");
		}

		//delete the assignments that have ended already
		$sql = "DELETE FROM assign WHERE end_time <= NOW()";
		$stmt = $conn -> prepare($sql);
		$res = $stmt -> execute();
		if($res === false) {
			die("Error while adding assignment. <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>Go back</a>.");
		}
		$stmt -> free_result();

		//check whether waiter is assigned in this time interval
		$sql = "SELECT start_time, end_time FROM assign WHERE waiter_name = ?";
		$stmt = $conn -> prepare($sql);
		$stmt -> bind_param("s", $waiter_name);
		$res = $stmt -> execute();
		if($res === false) {
			die("Error while adding assignment. <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>Go back</a>.");
		}
		$result = $stmt -> get_result();
		while($row = $result -> fetch_assoc()) {
			if( ($start_time >= $row["start_time"] and $start_time <= $row["end_time"]) or ($end_time >= $row["start_time"] and $end_time <= $row["end_time"]) or ($start_time <= $row["start_time"] and $end_time >= $row["end_time"]) ) {
				die("There is another assignment in the interval you have entered.Please <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>go back and try again</a>.");
			}
		}
		$stmt -> free_result();

		//adding assignment
		$sql = "INSERT INTO assign(waiter_name, table_no, start_time, end_time) VALUES(?, ?, ?, ?)";
		$stmt = $conn -> prepare($sql);
		$stmt -> bind_param("siss", $waiter_name, $table_no, $start_time, $end_time);
		$res = $stmt -> execute();
		if($res === false) {
			die("Error while adding assignment. <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>Go back</a>."); 
		}
		$stmt -> close();

		header("Location:http://localhost/restaurant/head-waiter/homepage.php");		
	}
	else if(isset($_POST["delete_button"])){
		if(empty($_POST["start_time"]) or empty($_POST["end_time"])) {
			die("You should enter waiter name, start time and end time of the assignment to delete it. Please <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>go back and try again</a>.");
		}

		//delete the assignments that have ended already
		$sql = "DELETE FROM assign WHERE end_time <= NOW()";
		$stmt = $conn -> prepare($sql);
		$res = $stmt -> execute();
		if($res === false) {
			die("Error while adding assignment. <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>Go back</a>.");
		}
		$stmt -> free_result();

		//delete the assignment
		$sql = "DELETE FROM assign WHERE waiter_name = ?, start_time = ?, end_time = ?";
		$stmt = $conn -> prepare($sql);
		$stmt -> bind_param("sss", $waiter_name, $start_time, $end_time);
		$res = $stmt -> execute();
		if($res === false) {
			die("Error while deleting assignment. <a href= 'http://localhost/restaurant/head-waiter/homepage.php'>Go back</a>."); 
		}
		$stmt -> close();

		header("Location:http://localhost/restaurant/head-waiter/homepage.php");			
	}
?>