<?php
	session_start();
	$_SESSION['logged_in'] = False;
?>
	<form>
		<h3>Login to see the tip of the day</h3>
		Username: <input type="text" name="user"><br>
		Password: <input type="password" name="pword"><br><br>
		<input type=submit>
	</form>
<?php
	@$paword=$_GET['pword'];
	@$usern=$_GET['user'];
	$servername = "localhost";
	$username = "nations";
	$password = "nations!";
	$conn = new mysqli($servername, $username, $password, "nations");
	if($conn->connect_error){
		die("Failed: " . $conn->connect_error);
	}
	$command = $conn->prepare("SELECT username, password from mlogins WHERE username = ?");
	$command->bind_param('s',$usern);
	$command->execute();
	$result = $command->get_result();
	if(mysqli_num_rows($result)==0){
		echo "User not found in database.";
	}else{
		if($result){
			while($row = $result->fetch_assoc()){
				$r = $row['password'];
				if(password_verify($paword, $r)){
					$_SESSION['logged_in'] = True;
					header("Location: outcome.php"); 
				}else{
					echo "Wrong password.";
				}
			}
		}
	}
	$conn->close();
?>
