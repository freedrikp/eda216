<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$recipes = $db->getRecipes();
	$db->closeConnection();
?>

<html>
<head><title>Produce Cookies 1</title><head>
<body align="center"><h1>Produce Cookies 1</h1>
	Select recipe:
	<p>
	<form method=post action="produce2.php">
		<select name="recipe" size=10>
		<?php
			$first = true;
			foreach ($recipes as $name) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $name;
			}
		?>
		</select>
		<p>
		Select the amount of pallets to produce:
		<p>
		<input type="number" name="palletAmount" value="1">	
		<p>
		<input type=submit value="Produce Pallets">
	</form>
	<p>
	<br>
	<a href="index.php">Back to the homepage</a>
</body>
</html>
