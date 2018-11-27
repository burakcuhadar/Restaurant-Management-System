<?php
	require("../db_connection.php");	

	session_start();
	if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "admin" ) {
		die("Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.");

	}
	else if( empty($_POST["name"]) or (!isset($_POST["add_button"]) and !isset($_POST["delete_button"])) ){
		die("You should fill the required fields and come here from admin page. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back</a>.");
	}
	else {
		$name = $_POST["name"];
		$age  = $_POST["age"];
		
		if(isset($_POST["add_button"])) {
			if(empty($_POST["age"])) {
				die("You should enter the age of the waiter. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back and try again</a>.");
			}
			else {
				$sql = "INSERT INTO waiters(name,age) values(?,?)";
				$stmt = $conn -> prepare($sql);
				$stmt -> bind_param("si", $name, $age);
				$res = $stmt -> execute();
				if($res === false) {
					die("Error while adding waiter. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
				}
				$stmt -> close();
				header("Location:http://localhost/restaurant/admin/homepage.php");		
			}
		}
		else if(isset($_POST["delete_button"])){
			$sql = "DELETE FROM waiters WHERE name = ?";
			$stmt = $conn -> prepare($sql);
			$stmt -> bind_param("s", $name);
			$res = $stmt -> execute();	
			if($res === false) {
				die("Error while deleting waiter. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
			}
			$stmt -> free_result();

			//delete from 'assign' table
			$sql = "DELETE FROM assign WHERE name = ?";
			$stmt = $conn -> prepare($sql);
			$stmt -> bind_param("s", $name);
			$res = $stmt -> execute();	
			if($res === false) {
				die("Error while deleting waiter. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
			}

			$stmt -> close();
			header("Location:http://localhost/restaurant/admin/homepage.php");		
		}
	}
?>