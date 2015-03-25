<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$pallets = $db->getUnblockedPallets();
	$db->closeConnection();


/**
* HÄR SKA MAN KUNNA BLOCKERA 
* DONE!
*
*OCH SÖKA EFTER LEVERERADE PALLET TILL SPEC. KUND.
*
*/
?>

<html>
<head><title>Search and Block 1</title><head>
<body><h1>Search and Block 1</h1>
	<p>
		<a href="sob1blockedID.php">List Blocked Pallets by palletID</a>
		<br>
		<a href="sob1blockedTimeMade.php">List Blocked Pallets by TimeMade - FUNKAR EJ</a>
		<br>
		<a href="sob1search.php">Search for pallet - FUNKAR EJ</a>
		<br>
	</p>
	Select time/date of pallet to BLOCK:
	<p>
	<form method=post action="sob1blockpallet.php">
		<select name="pallet_to_block" size=10>
		<?php
			$first = true;
			foreach ($pallets as $palletDate) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $palletDate;
			}
		?>
		</select>		
		<input type=submit value="Select pallet">
	</form>
	<p>
		<a href="index.html">Back to the homepage</a>
</body>
</html>
