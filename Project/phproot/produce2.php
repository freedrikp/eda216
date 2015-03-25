<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$recipe = $_POST['recipe'];
	$palletAmount = floatval($_POST['palletAmount']);

	$palletsProduced = $db->producePallets($recipe,$palletAmount);
	
	$db->closeConnection();
?>

<html>
<head><title>Produce Cookies 2</title><head>
<body><h1>Produce Cookies 2</h1>
		<?php
		foreach ($palletsProduced as $pallet) {
				print $pallet."<p>";
			}	
		?>
</body>
</html>
