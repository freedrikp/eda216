<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$palletId = $_POST['searchPalletId'];
	$pallets = $db->findPalletID($palletId);
	$db->closeConnection();
?>
<html>
<head><title>Search Result</title><head>
<body align="center">
	<h1>Search Result</h1>
	<?php
	if (count($pallets) > -1){
		print "Pallet found:<br><br>"; 
	}else {
		echo "<font color='red'>No pallet found</font>";
	}
				echo "<table style='width:60%' border=1 align='center'>";
  				echo "<tr>";
   				echo "<th align='center'>PalletID</th>";
    			echo "<th align='center'>timeMade</th>";
    			echo "<th align='center'>recipeName</th>";
    			echo "<th align='center'>inFreezer</th>";
    			echo "<th align='center'>Blocked</th>";
    			echo "<th align='center'>TimeOfDelivery</th>";
    			echo "<th align='center'>CustomerName</th>";
    			echo "<th align='center'>CustomerAddress</th>";
  				echo "</tr>";

				foreach ($pallets as $palletcolumn) {
					echo "<tr>";
					echo "<td align='center'>". $palletcolumn['palletId'] ."</td>";
					echo "<td align='center'>". $palletcolumn['timeMade'] ."</td>";
					echo "<td align='center'>". $palletcolumn['recipeName'] ."</td>";

					if($palletcolumn['inFreezer'] == 1){
						echo "<td align='center'>TRUE</td>";
					}else{
						echo "<td align='center'>FALSE</td>";
					}
					if($palletcolumn['blocked'] == 1){
						echo "<td align='center'>TRUE</td>";
					}else{
						echo "<td align='center'>FALSE</td>";
					}


					echo "<td align='center'></td>";
					echo "<td align='center'></td>";
					echo "<td align='center'></td>";
					echo "</tr>";
				}
			
		?>
		</table>
		<br>
		<a href="sob1search.php">Back to Search</a>
</body>
</html>
