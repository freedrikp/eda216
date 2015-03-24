<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$db->openConnection();
	$rNbr = $db->bookTicket($_SESSION['show'],$userId);
	$db->closeConnection();
?>

<html>
<head><title>Booking 4</title><head>
<body><h1>Booking 4</h1>
	<?php
	if ($rNbr > -1){
		print "One ticket booked. Booking number: ".$rNbr; 
	}else {
		echo "<font color='red'>Could not book ticket </font>". $rNbr;
	}
	?> 
	<p>
	<form method=post action="booking1.php">		
		<input type=submit value="Make a new reservation">
	</form>
</body>
</html>
