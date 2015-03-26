<?php
	session_start();
?>
<html>
<head><title>Search for Pallet</title><head>
<body>
	<h1>Search for Pallet</h1>
	<p>
	<form method=post action="sob1searchResultID.php">
		Enter a palletID you want to see pallets for:<br>
		<input type="number" name="searchPalletId">
		<br>
		<input type=submit value="Search">
	</form>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
