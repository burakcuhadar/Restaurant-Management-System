<?php
	require("../db_connection.php");	

	session_start();
	if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "admin" ) {
		die("Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.");

	}
	else if( empty($_POST["table_no"]) or (!isset($_POST["add_button"]) and !isset($_POST["delete_button"])) ){
		die("You should fill all the fields and come here from admin page. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back</a>.");
	}
	else {
		$table_no 	  = $_POST["table_no"];
		$no_of_seats  = $_POST["no_of_seats"];
		
		if(isset($_POST["add_button"])) {
			if(empty($_POST["no_of_seats"])) {
				die("You should enter number of seats of the table. Please <a href= 'http://localhost/restaurant/admin/homepage.php'>go back and try again</a>.");			
			}
			else {
				$sql = "INSERT INTO tables(table_no, no_of_seats) values(?,?)";
				$stmt = $conn -> prepare($sql);
				$stmt -> bind_param("ii", $table_no, $no_of_seats);
				$res = $stmt -> execute();
				if($res === false) {
					die("Error while adding table. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
				}
				$stmt -> close();
				header("Location:http://localhost/restaurant/admin/homepage.php");		
			}
		}
		else if(isset($_POST["delete_button"])){
			$sql = "DELETE FROM tables WHERE table_no = ?";
			$stmt = $conn -> prepare($sql);
			$stmt -> bind_param("i", $table_no);
			$res = $stmt -> execute();	
			if($res === false) {
				die("Error while deleting table. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
			}
			$stmt -> free_result();

			//delete from 'assign' table
			$sql = "DELETE FROM assign WHERE table_no = ?";
			$stmt = $conn -> prepare($sql);
			$stmt -> bind_param("i", $table_no);
			$res = $stmt -> execute();	
			if($res === false) {
				die("Error while deleting table. <a href= 'http://localhost/restaurant/admin/homepage.php'>Go back</a>.");
			}
			$stmt -> close();

			header("Location:http://localhost/restaurant/admin/homepage.php");					
		}
	}
?>