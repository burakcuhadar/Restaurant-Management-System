<?php
	require("db_connection.php");
	
	if(!isset($_GET["name"]) or !isset($_GET["pass"]) or !isset($_GET["submit"])) {
		echo "There is nothing to show in this page. You can <a href= 'http://localhost/restaurant/login.php'>log in here</a>.";
	}
	else {
	$name = $_GET["name"];
	$pass = $_GET["pass"];

	$sql  = "SELECT username, role from users where username = ? AND password = ?";
	$stmt = $conn -> prepare($sql);
	$stmt -> bind_param("ss", $name, $pass);
	$stmt -> execute();
	$result = $stmt -> get_result();

	if($result->num_rows > 0) {
		$row = $result -> fetch_assoc();
		session_start();
		$_SESSION["username"] = $name;
		$_SESSION["role"] = $row["role"];
		
		if($row["role"] === "admin") {
			header("Location:http://localhost/restaurant/admin/homepage.php");
		}
		else {
			header("Location:http://localhost/restaurant/head-waiter/homepage.php");	
		}
	}
	else {
		echo "Wrong username or password!";
		?>
		<html>
			<head>
				<title>Login failed!</title>
			</head>
			<body>
				<a href="http://localhost/restaurant/login.php">Try again.</a>
			</body>
		</html>
		<?php
	}
	$conn->close();
	}
?>