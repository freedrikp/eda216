<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$db->openConnection();
	$movieName = $_SESSION['movieName'];
	$sDate = $_SESSION['sDate'];
	$rNbr = $db->bookTicket($movieName, $sDate, $userId);
	$db->closeConnection();
?>

<html>
<head><title>Booking 4</title><head>
<body><h1>Booking 4</h1>
	One ticket booked. Booking number: <?php print $rNbr; ?> 
</body>
</html>
