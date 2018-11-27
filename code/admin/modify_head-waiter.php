<?php
	require("../db_connection.php");	

	session_start();
	if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "admin" ) {
		die("Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.");
	}
	else if( empty($_POST["name"]) or (!isset($_POST["add_button"]) and !isset($_POST["delete_button"])) ){
		die("You should fill all the fields and come here from admin page. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back</a>.");
	}
	else {
		$name  = $_POST["name"];
		$pass  = $_POST["pass"];

		if(isset($_POST["add_button"])) {
			if( empty($_POST["pass"]) ) {
				die("You should enter the password of the head-waiter. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back and try again</a>.");			
			}
			else {
				$sql = "INSERT INTO users(username, password, role) values(?,?,?)";
				$stmt = $conn -> prepare($sql);
				$stmt -> bind_param("sss", $name, $pass, $role = "head-waiter");
				$res = $stmt -> execute();
				if($res === false) {
					die("Error while adding head-waiter. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
				}
				$stmt -> close();
				header("Location:http://localhost/restaurant/admin/homepage.php");		
			}
		}
		else if(isset($_POST["delete_button"])){
			$sql = "DELETE FROM users WHERE username = ?";
			$stmt = $conn -> prepare($sql);
			$stmt -> bind_param("s", $name);
			$res = $stmt -> execute();	
			if($res === false) {
				die("Error while deleting head-waiter. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
			}
			
			$stmt -> close();
			header("Location:http://localhost/restaurant/admin/homepage.php");		
		}
	}
?>