<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$customerName = $_POST['searchCustomerName'] . '%';
	$pallets = $db->findPalletCustomer($customerName);
	$db->closeConnection();
?>
<html>
<head><title>Search Result</title><head>
<body>
	<h1>Search Result</h1>
	<?php
	if (count($pallets) > -1){
		print "Pallet(s) found:<br><br>"; 
	}else {
		echo "<font color='red'>No pallet found</font>";
	}

				foreach ($pallets as $palletcolumn) {

					print $palletcolumn['palletId'];
					print "&nbsp;&nbsp;";
					print $palletcolumn['timeMade'];
					print "&nbsp;&nbsp;";
					print $palletcolumn['recipeName'];
					print "<br>";
				}
			
		?>
		<br>
		<a href="sob1search.php">Back to Search and Block 1</a>
</body>
</html>
