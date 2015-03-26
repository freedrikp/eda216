<?php
	session_start();
?>
<html>
<head><title>Search for Pallet</title><head>
<body align="center">
	<h1>Search for Pallet</h1>
	<p>
	<form method=post action="sob1searchResultID.php">
		<p>
		Search by entering:<br>
		<input type="radio" name="search_option" value=0 checked>PalletID
		<input type="radio" name="search_option" value=1>Recipe
		<input type="radio" name="search_option" value=2>Time Interval
		<p>
		<br>
		Enter palletID or recipe: 
		<input type="text" name="search_text">
		
		<p>
		<br>
		Search for pallets produced between: <br>
		<input type="datetime-local" name="searchfromDate">
		-
		<input type="datetime-local" name="searchtoDate">
		<p>
		<input type=submit value="Search">
	</form>
	<p>
		<a href="sob1.php">Back to Search and Block 1</a>
</body>
</html>
