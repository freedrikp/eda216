<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$pallet = $_POST['pallet_to_unblock'];
	$rNbr = $db->unblockPallet($pallet);
	$db->closeConnection();
?>
<html>
<head><title>Unblocking</title><head>
<body>
	<h1>Unblocking</h1>
	<?php
	if ($rNbr > -1){
		print "The pallet has been UNBLOCKED."; 
	}else {
		echo "<font color='red'>An ERROR occur when trying to unblock pallet </font>";
	}
	?> 
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>