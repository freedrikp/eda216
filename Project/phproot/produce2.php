<?php
	require_once('database.inc.php');

	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();

	$recipe = $_POST['recipe'];
	$palletAmount = intval($_POST['palletAmount']);

	$palletsProduced = $db->producePallets($recipe,$palletAmount);

	$db->closeConnection();
?>

<html>
<head><title>Produce Cookies 2</title><head>
<body align="center"><h1>Produce Cookies 2</h1>
	Pallets have been created with the following id:s and are now in the freezer:
	<p>
		<?php
		if (empty($palletsProduced)){
				print "Error! No pallets could be produced.";
		}else{
		foreach ($palletsProduced as $id) {
			print $id."<br>";
		}
		}
		?>
		<p>
	<a href="index.php">Back to the homepage</a>
</body>
</html>
