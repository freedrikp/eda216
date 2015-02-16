<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$db->openConnection();
	$movieName = $_POST['movieName'];
	$_SESSION['movieName'] = $movieName;
	$sDates = $db->getDates($movieName);
	$db->closeConnection();
?>

<html>
<head><title>Booking 2</title><head>
<body><h1>Booking 2</h1>
	Current user: <?php print $userId ?>
	<br>	
	Selected Movie: <?php print $movieName ?>
	<p>	
	Performance dates:
	<p>
	<form method=post action="booking3.php">
		<select name="sDate" size=10>
		<?php
			$first = true;
			foreach ($sDates as $sDate) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $sDate;
			}
		?>
		</select>		
		<input type=submit value="Select date">
	</form>
</body>
</html>
