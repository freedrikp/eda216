<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$pallets = $db->getBlockedPallets(1);
	$db->closeConnection();
?>
<html>
<head><title>Blocked Pallets</title><head>
<body align="center">
	<h1>Blocked Pallets   -----------FUNKAR EJ ÄN----------</h1>
	</p>
	Select TimeMade to unblock:
	<p>
	<form method=post action="sob1unblockpallet.php">
		<select name="pallet_to_unblock" size=10>
		<?php
			$first = true;
			foreach ($pallets as $palletTimeMade) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $palletTimeMade;
			}
		?>
		</select>		
		<input type=submit value="Select pallet">
	</form>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
