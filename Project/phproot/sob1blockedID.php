<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$pallets = $db->getBlockedPallets(0);
	$db->closeConnection();
?>
<html>
<head><title>Blocked Pallets</title><head>
<body align="center">
	<h1>Blocked Pallets</h1>
	</p>
	Select palletID to unblock:
	<p>
	<form method=post action="sob1unblockpallet.php">
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
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
