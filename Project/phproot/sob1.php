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
		<a href="sob1blockedID.php">View blocked pallets</a>
		<br>
		<a href="sob1search.php">Search for pallet(s)</a>
		<br>
	</p>
	<br>
	<br>	
	<p>
	<form method=post action="sob1betweenDates.php">
	Block/Unblock pallet(s) between: 
	<input type="datetime-local" name="fromDate">
	-
	<input type="datetime-local" name="toDate">
	
	<input type="radio" name="blocking" value=1 checked>Block
	<input type="radio" name="blocking" value=0>Unblock
	
	<input type="submit" value="Execute">
	</form>
	<p>
	<br>
	<br>	
	Select time/date of pallet to BLOCK:
	<p>
	<form method=post action="sob1blockpallet.php">
		<select name="pallet_to_block" size=10>
		<pre>
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
					print " - ";
					print $palletcolumn['timeMade'];
					print " - ";
					print $palletcolumn['recipeName'];

			}
		?>
		
		</select>		
		<input type=submit value="Block pallet">
	</form>
	<p>
		<a href="index.php">Back to the homepage</a>
</body>
</html>
