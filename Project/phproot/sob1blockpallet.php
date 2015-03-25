<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$pallet = $_POST['pallet_to_block'];
	$rNbr = $db->blockPallet($pallet);
	$db->closeConnection();
?>
<html>
<head><title>Blocking</title><head>
<body>
	<h1>Blocking</h1>
	<?php
	if ($rNbr > -1){
		print "The pallet has been BLOCKED."; 
	}else {
		echo "<font color='red'>Could not block pallet </font>";
	}
	?> 
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
