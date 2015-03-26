<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$blocking = $_POST['blocking'];
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	if($blocking == 1){
		$rNbr = $db->blockBetweenPallet($fromDate, $toDate);
	}else{
		$rNbr = $db->unblockBetweenPallet($fromDate, $toDate);
	}
	$db->closeConnection();
?>
<html>
<head><title>Blocking dates</title><head>
<body>
	<h1>Blocking dates</h1>
	<?php
	if ($rNbr > 0){
		if($blocking == 1){
			print "The pallet(s) has been BLOCKED."; 
		}else{
			print "The pallet(s) has been UNBLOCKED."; 
		}
	}else {
		if($blocking == 1){
			echo "<font color='red'>Could not block pallet </font>";
		}else{
			echo "<font color='red'>Could not unblock pallet </font>";
		}
	}
	?>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
