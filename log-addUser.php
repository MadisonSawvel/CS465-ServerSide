<?php
	session_start();

	if($_SESSION['logged_in'] != True):
	{
		header("Location: login.php");
	}
	else:
?>
	<form method="get">
		<h2>Add Users</h2>
		New Username: <input type="text" name="newu"><br>
		New Password: <input type="password" name="newp"><br><br>
		<input type=submit name="add" value="Submit" />
		<input type=submit name="logout" value="Log Out" />
	</form>
<?php
	@$npass = $_GET['newp'];
	$hnpass = password_hash($npass, PASSWORD_BCRYPT);
	@$user = $_GET['newu'];
	$servername = "localhost";
	$username = "nations";
	$password = "nations!";
	$conn = new mysqli($servername, $username, $password, "nations");
	if($conn->connect_error){
		die("Failed: " . $conn->connect_error);
	}
	$command = $conn->prepare("SELECT username from mlogins WHERE username = ?");
	$command->bind_param('s', $user);
	$command->execute();
	$result = $command->get_result();
	if(mysqli_num_rows($result)==0){
		echo "Nothing to match from database, user added";
		$input_command = $conn->prepare("insert into mlogins values (?,?)");
		$input_command->bind_param('ss', $user, $hnpass);
		$input_command->execute();
	}else{
		echo "This is already an exisiting user.";
	}
	if(isset($_GET['logout'])) {
		header("Location: logout.php");
	}
	$conn->close();
	endif;
?>
