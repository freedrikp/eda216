<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$search_option = $_POST['search_option'];
	$palletId = $_POST['search_text'];
	if($search_option == 0){
		$pallets = $db->findPalletID($palletId);
	}else if($search_option == 1){
		$pallets = $db->findPalletRecipe($palletId ."%");
	}else if($search_option == 2){
		$pallets = $db->findPalletBetween($_POST['searchfromDate'],$_POST['searchtoDate']);
	}
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
					echo "<td align='center'>". $palletcolumn[0] ."</td>";
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

					echo "<td align='center'>". $palletcolumn['deliveryTime'] ."</td>";
					echo "<td align='center'>". $palletcolumn['customerName'] ."</td>";
					echo "<td align='center'>". $palletcolumn['customerAddress'] ."</td>";
					echo "</tr>";
				}
			
		?>
		</table>
		<br>
		<a href="sob1search.php">Back to Search</a>
</body>
</html>
