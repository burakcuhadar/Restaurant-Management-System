<html>
<head>
	<title>Admin Home Page</title>
</head>
<body>
	<?php
		session_start();
		if(!isset($_SESSION["username"])  or !isset($_SESSION["role"]) or $_SESSION["role"] !== "admin" ) {
			echo "Please <a href= 'http://localhost/restaurant/login.php'>log in </a> to view this page.";
		}
		else {
			echo "Welcome " . $_SESSION["username"] . ". You are logged in as " . $_SESSION["role"] . ".";
			echo "You can <a href= 'http://localhost/restaurant/logout.php'>log out here</a>.";
	?>
		<form action="modify_head-waiter.php" method="post">
		  <table>
		    <tr>
		      <td align="left">Head-waiter name:</td>
		      <td align="left"><input type="text" name="name" /></td>
		    </tr>
		    <tr>
		      <td align="left">Head-waiter password:</td>
		      <td align="left"><input type="Password" name="pass" /></td>
		    </tr>
		    <tr>
		      <td align="left"><input type="submit" name="add_button"    value="Add" /></td>
		      <td align="left"><input type="submit" name="delete_button" value="Delete"/></td>
		    </tr>
		  </table>
		</form>
		<form action="modify_waiter.php" method="post">
		  <table>
		    <tr>
		      <td align="left">Waiter name:</td>
		      <td align="left"><input type="text" name="name" /></td>
		    </tr>
		    <tr>
		      <td align="left">Waiter age:</td>
		      <td align="left"><input type="number" name="age" /></td>
		    </tr>
		    <tr>
		      <td align="left"><input type="submit" name="add_button"    value="Add" /></td>
		      <td align="left"><input type="submit" name="delete_button" value="Delete"/></td>
		    </tr>
		  </table>
		</form>
		<form action="modify_table.php" method="post">
		  <table>
		    <tr>
		      <td align="left">Table number:</td>
		      <td align="left"><input type="number" name="table_no" /></td>
		    </tr>
		    <tr>
		      <td align="left">Number of seats:</td>
		      <td align="left"><input type="number" name="no_of_seats" /></td>
		    </tr>
		    <tr>
		      <td align="left"><input type="submit" name="add_button"    value="Add" /></td>
		      <td align="left"><input type="submit" name="delete_button" value="Delete"/></td>
		    </tr>
		  </table>
		</form>
		<form action="stored_procedure.php" method="get">
		  <table>
		  	<tr>
		      <td align="left">Table number:</td>
		      <td align="left"><input type="text" name="table_no" /></td>
		    </tr>
		    <tr>
		      <td align="left">Datetime:</td>
		      <td align="left"><input type="datetime-local" name="datetime" /></td>
		    </tr>
		    <tr>
		      <td align="left"><input type="submit" name="sp" value="SP"/></td>
		    </tr>
		  </table>
		</form>
	<?php
		}
	?>
</body>
</html>