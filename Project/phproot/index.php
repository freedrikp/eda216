<?php
	require_once('database.inc.php');
	require_once("mysql_connect_data.inc.php");
	
	$db = new Database($host, $userName, $password, $database);
	$db->openConnection();
	if (!$db->isConnected()) {
		header("Location: cannotConnect.html");
		exit();
	}
	
	$db->closeConnection();
	
	session_start();
	$_SESSION['db'] = $db;
?>
<html>
<head>
<title>Krusty Kookies AB</title>
</head>
<body align="center">

<h1 align="center">Krusty Kookies AB</h1>
<h2 align="center">Choose your desired action:</h2>
<p>
<a href="produce1.php">Produce Cookies</a>
<p>
<a href="sob1.php">Search and Block Pallets</a>

</body>
</html>
