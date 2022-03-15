<?php
	session_start();
	if($_SESSION['logged_in'] != True): {
		header("Location: login.php");
	}
	else:
?>
	<form method="get">
		<h3>You've successfully logged in! Welcome to the tip of the day</h3>
		<h4>Today's tip is: <p>&#9733; be nicer to your wife &#9733; </p></h4>
		<input type=submit name="add" value="Add User" />
		<input type=submit name="logout" value="Log Out" />
	</form>
<?php 
	if(isset($_GET['add'])){
		header("Location: addHere.php");
	}
	if(isset($_GET['logout'])){
		header("Location: logout.php");
	}
	endif; 
?>
