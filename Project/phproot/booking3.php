<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$db->openConnection();
	$movieName = $_SESSION['movieName'];
	$sDate = $_POST['sDate'];
	$show = $db->getPerformance($movieName, $sDate);
	$_SESSION['show'] = $show;
	$db->closeConnection();
?>

<html>
<head><title>Booking 3</title><head>
<body><h1>Booking 3</h1>
	Current user: <?php print $userId ?>
	<p>
	Data for selected performance:
	<p>	
	<br>
	Movie: <?php print $show['mName'] ?>
	<br>
	Date: <?php print $show['sDate'] ?>
	<br>
	Theater: <?php print $show['tName'] ?>
	<br>
	Free seats: <?php print $show['freeSeats'] ?>
	<p>
		<?php if($show['error'] == 1) echo "<font color='red'> Selected performance NOT possible</font>"; ?>
	<form method=post action="booking4.php">		
		<input type=submit value="Book ticket">
	</form>
</body>
</html>
