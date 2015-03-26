<?php
	session_start();
?>
<html>
<head><title>Search for Pallet</title><head>
<body align="center">
	<h1>Search for Pallet</h1>
	<p>
	<form method=post action="sob1searchResultID.php">
		Enter a palletID you want to see information about:<br>
		<input type="number" name="searchPalletId">
		<p>
		<input type=submit value="Search">
	</form>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
