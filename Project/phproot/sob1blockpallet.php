<?php
	require_once('database.inc.php');
	function extract_numbers($string)
	{
	preg_match_all('/([\d]+)/', $string, $match);
	return $match[0];
	}

	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$pallet = $_POST['pallet_to_block'];
	$palletNbrs = extract_numbers($pallet);
	$palletId = $palletNbrs[0];
	$rNbr = $db->blockPallet($palletId);
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
