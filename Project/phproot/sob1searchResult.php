<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$customerName = $_POST['searchCustomerName'];
	$pallets = $db->findPalletOfCustomer($customerName);
	$db->closeConnection();
?>
<html>
<head><title>Search Result</title><head>
<body>
	<h1>Search Result</h1>
	<?php
	if ($rNbr > -1){
		print "The pallet has been UNBLOCKED."; 
	}else {
		echo "<font color='red'>No pallet(s) found</font>";
	}
	?> 
<ol>
		<?php
			foreach ($pallets as $pallet) {
				if ($first) {
					echo "<li>";
					print $pallet;
					echo "</li>";
			}
		?>
</ol>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
