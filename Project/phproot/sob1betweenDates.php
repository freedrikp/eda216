<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$toDate = $_POST['toDate'];
	$fromDate = $_POST['fromDate'];
	$rNbr = $db->blockBetweenPallet($toDate, $fromDate);
	$db->closeConnection();
?>
<html>
<head><title>Blocking dates</title><head>
<body>
	<h1>Blocking dates</h1>
	<?php
	if ($rNbr > 0){
		print "The pallet(s) has been BLOCKED."; 
	}else {
		echo "<font color='red'>Could not block pallet </font>";
	}
	?> 
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
