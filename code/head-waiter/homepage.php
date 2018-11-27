<html>
<head>
	<title>Head-waiter Home Page</title>
</head>
<body>
	<?php
		session_start();
		if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "head-waiter" ) {
			echo "Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.";
		}
		else {
			echo "Welcome " . $_SESSION["username"] . ". You are logged in as " . $_SESSION["role"] . ". ";
			echo "You can <a href= 'http://localhost/restaurant/logout.php'>log out here</a>.";
	?>
		<form action="modify_assignment.php" method="post">
		  <table>
		    <tr>
		      <td align="left">Start datetime:</td>
		      <td align="left"><input type="datetime-local" name="start_time" /></td>
		    </tr>
		    <tr>
		      <td align="left">End datetime:</td>
		      <td align="left"><input type="datetime-local" name="end_time" /></td>
		    </tr>
		    <tr>
		      <td align="left">Waiter name:</td>
		      <td align="left"><input type="text" name="waiter_name"/></td>
		    </tr>
		    <tr>
		      <td align="left">Table number:</td>
		      <td align="left"><input type="number" name="table_no"/></td>
		    </tr>
		    <tr>
		      <td align="left"><input type="submit" name="add_button"    value="Add" /></td>
		      <td align="left"><input type="submit" name="delete_button" value="Delete"/></td>
		    </tr>
		  </table>
		</form>
		<?php
		}
		?>	
</body>
</html>