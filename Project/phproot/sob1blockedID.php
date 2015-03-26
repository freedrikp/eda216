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

	$pallet = $_POST['pallet_to_unblock'];

	if($pallet > 0){
		$palletNbrs = extract_numbers($pallet);
		$palletId = $palletNbrs[0];
		$rNbr = $db->unblockPallet($palletId);
	}

	$pallets = $db->getBlockedPallets();
	$db->closeConnection();
?>
<html>
<head><title>Blocked Pallets</title><head>
<body align="center">
	<h1>Blocked Pallets</h1>
	</p>
	Select palletID to unblock:
	<p>
	<form method=post action="sob1blockedID.php">
		<select name="pallet_to_unblock" size=10>
		<?php
			$first = true;
			foreach ($pallets as $palletcolumn) {
					
					if ($first) {
						print "<option selected>";
						$first = false;
					} else {
						print "<option>";
					}

					print $palletcolumn['palletId'];
					print "&nbsp;&nbsp;&nbsp;&nbsp;";
					print $palletcolumn['timeMade'];
					print "&nbsp;&nbsp;";
					print $palletcolumn['recipeName'];

			}
		?>
		</select>
		<p>		
		<input type=submit value="Select pallet">
	</form>
	<p>
	<?php
	if ($rNbr == 1){
		print "The pallet has been UNBLOCKED."; 
	}else if($rNbr == -1){
		echo "<font color='red'>Could not unblock pallet </font>";
	}
	?> 
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
