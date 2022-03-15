<html>
	<form>
		Enter partial nation name to receive info: <input type="text" name="keyword"><br>
		<input type=submit>
	</form>

	<?php 
		$servername = "localhost";
		$username = "nations";
		$password = "nations!";
		$conn = new mysqli($servername, $username, $password, "nations");
		if($conn->connect_error){
			die("Failed: " . $conn->connect_error);
		}
		$command = $conn->prepare("SELECT code, name, pop, area FROM nations WHERE name rlike ?");
		$command->bind_param('s', $_GET['keyword']);
		$command->execute();
		$result = $command->get_result();
		if(mysqli_num_rows($result)==0){
			echo "Nothing to show from database.";
		}else{
			if($result){
				echo "<table border ='1'>";
				echo "<tr><th>Nation</th><th>Population</th><th>Area</th><th>Map</th><th>Flag</th><th>Longest Border</th></tr>";
				while($row = $result->fetch_assoc()){
					echo "<tr><td>" . $row["name"] . "</td>" . "<td>" . $row["pop"] . "</td>" . "<td>" . $row["area"] . "</td>";
					$map = "https://www.worldometers.info/img/maps_c/" . strtoupper($row["code"]) . "-map.gif";
					echo "<td>" . "<img src = '$map' style = 'width:150px;height:200px'>" . "</td>";
					$flag = "https://www.worldometers.info/img/flags/small/tn_" . $row["code"] . "-flag.gif";
					echo "<td>" . "<img src = '$flag'>" . "</td>";
					$bcommand = $conn->prepare("SELECT name FROM nations, borders WHERE code1 = ? AND nations.code = borders.code2 ORDER BY length DESC limit 1");
					$bcommand->bind_param('s', $row["code"]);
					$bcommand->execute();
					$border = $bcommand->get_result();
					echo "<td>";
					if(mysqli_num_rows($border)==0){
						echo "None";
					}else{
						while($b = $border->fetch_assoc()){
							echo  $b["name"];
						}
					}
					echo "</td></tr>";
				}
				echo "</table>";
			} else {
				echo "Error in " . $command . "<br>" . $conn->error;
			}
		}
		$conn->close();
	?>
</html>
