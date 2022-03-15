<?php
	session_start();

	if($_SESSION['logged_in'] != True ): {
		header("Location: login.php");
	}
	else:
?>
Now logged out.
<?php 
	header("Location: login.php");
	endif; 
?>

