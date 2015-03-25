<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	//$pallets = $db->getBlockedPallets(0);
	$db->closeConnection();
?>
<html>
<head><title>Search for Pallet</title><head>
<body>
	<h1>Search for Pallet</h1>
	</p>
	Enter a customer you want to see pallets for:
	<p>
	<form method=post action="sob1searchResult.php">
		Last name:<br>
		<input type="text" name="searchCustomerName">
		<br><br>
		<input type=submit value="Search">
	</form>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
