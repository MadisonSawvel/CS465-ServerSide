<?php 
	setcookie('cookie[one]', 'cookieone');
?>
<html>
	<?php 
		function replaced($replacearr) {
			$forbidden = array();
			$forbidden[0] = '/Democrat/';
			$forbidden[1] ='/Republican/';
			$forbidden[2] = '/Dumbass/';
			$instead = array();
			$instead[0] = 'Blue';
			$instead[1] = 'Red';
			$instead[2] = 'Homie';
			$corrected = preg_replace($forbidden, $instead, $replacearr);
			return $corrected;
		}
		function removedup($perfectarr) {
			$split = preg_split("/[,\n\r\t ]/", $perfectarr, -1, PREG_SPLIT_NO_EMPTY);
			$nodup = array_unique($split);
			return $nodup;
		}
		@$data = htmlspecialchars ($_REQUEST['data']);
		//if and foreach from daniweb
		if(isset($_COOKIE['cookie'])) {
			foreach ($_COOKIE['cookie'] as $name => $value) {
				$name = htmlspecialchars ($name);
				$value = htmlspecialchars ($data);
			}
		}
		@$corrected = replaced($value);
		$nodup = removedup($corrected); 
		echo "You entered: $corrected <br>"; 
		print_r($nodup);
	?>
	<form>
		Enter your guests<br>
		<textarea rows=20 cols=60 name=data><?php
			foreach ($nodup as $n)
			{
				if (empty($seen[$n]))
					echo(trim($n) . "\n");
					$seen[$n] = 1;
			}
		?></textarea><br>
		<input type=submit><br>
		</form>
</html>
