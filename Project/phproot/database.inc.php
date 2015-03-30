<?php
/*
 * Class Database: interface to the movie database from PHP.
 *
 * You must:
 *
 * 1) Change the function userExists so the SQL query is appropriate for your tables.
 * 2) Write more functions.
 *
 */
class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;

	/**
	 * Constructs a database object for the specified user.
	 */
	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}

	/**
	 * Opens a connection to the database, using the earlier specified user
	 * name and password.
	 *
	 * @return true if the connection succeeded, false if the connection
	 * couldn't be opened or the supplied user name and password were not
	 * recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database",
					$this->userName,  $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error = "Connection error: " . $e->getMessage();
			print $error . "<p>";
			unset($this->conn);
			return false;
		}
		return true;
	}

	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset($this->conn);
	}

	/**
	 * Execute a database query (select).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}

	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
  			$stmt->execute($param);
  			$count = $stmt->rowCount();
  		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $count;
	}

	/*
	 * *** Add functions ***
	 */
	public function getRecipes(){
		$sql = "select recipeName from Recipes";
		$rows = $this->executeQuery($sql);
		foreach ($rows as $row) {
			$result[] = $row['recipeName'];
		}
		return $result;
	}


	public function producePallets($recipe,$palletAmount){
		$this->conn->beginTransaction();
		$nbrCookies = 5400*$palletAmount;
		$sql = "select nbrCookies from Recipes where recipeName = ?";
		$cookiesOfRecipe = $this->executeQuery($sql,array($recipe))[0]['nbrCookies'];
		$timesOfRecipe = $nbrCookies/$cookiesOfRecipe;

		$sql = "select ingredientName,ingredientAmount,stockAmount from IngredientsInRecipes natural join IngredientsInStock where recipeName = ? for update";
		$rows = $this->executeQuery($sql,array($recipe));
		foreach ($rows as $row) {
			$amounts[$row['ingredientName']] = $row['ingredientAmount']*$timesOfRecipe;
			if ($amounts[$row['ingredientName']] > $row['stockAmount']){
				$this->conn->rollBack();
				return array();
			}
		}

		foreach ($amounts as $key => $value){
			$sql = "update IngredientsInStock set stockAmount=stockAmount - ? where IngredientName = ?";
			$count = $this->executeUpdate($sql,array($value,$key));
			if ($count <= 0){
				$this->conn->rollBack();
				return array();
			}
		}

		for ($i = 0; $i < $palletAmount; $i++){
			$sql = "insert into Pallets(blocked,inFreezer,recipeName) values (false,true,?)";
			$count = $this->executeUpdate($sql,array($recipe));
			if ($count <= 0){
					$this->conn->rollBack();
					return array();
			}
			$sql = "select last_insert_id() as last_id";
			$pallets[] = $this->executeQuery($sql)[0]['last_id'];

		}

		$this->conn->commit();
		return $pallets;
	}

	public function getBlockedPallets(){
		$sql = "select * from Pallets where blocked=true order by timeMade";
		$rows = $this->executeQuery($sql);
		return $rows;
	}

	public function getUnblockedPallets(){
		$sql = "select * from Pallets where blocked=false order by timeMade";
		$rows = $this->executeQuery($sql);
		return $rows;
	}

	public function findPalletID($palletId){
		$sql = "select * from Pallets left outer join (DeliveredPallets natural join Orders) on Pallets.palletId = DeliveredPallets.palletId where Pallets.palletId = ?";
		$rows = $this->executeQuery($sql, array($palletId));
		return $rows;
	}

	public function findPalletRecipe($recipe){
		$sql = "select * from Pallets left outer join (DeliveredPallets natural join Orders) on Pallets.palletId = DeliveredPallets.palletId where recipeName like ?";
		$rows = $this->executeQuery($sql, array($recipe));
		return $rows;
	}

	public function findPalletBetween($fromDate, $toDate){
		$sql = "select * from Pallets left outer join (DeliveredPallets natural join Orders) on Pallets.palletId = DeliveredPallets.palletId where timeMade >= ? and timeMade <= ?";
		$rows = $this->executeQuery($sql, array($fromDate, $toDate));
		return $rows;
	}

	public function blockPallet($palletId){
		$sql = "update Pallets set blocked = true where palletId = ?";
		$this->conn->beginTransaction();
		$count = $this->executeUpdate($sql, array($palletId));
		if ($count != 1){
			$this->conn->rollBack();
			return -1;
		}
		$this->conn->commit();
		return $count;
	}

	public function blockBetweenPallet($fromDate, $toDate){
		$sql = "update Pallets set blocked = true where timeMade >= ? and timeMade <= ?";
		$this->conn->beginTransaction();
		$count = $this->executeUpdate($sql, array($fromDate, $toDate));
		if ($count < 0){
			$this->conn->rollBack();
			return -1;
		}
		$this->conn->commit();
		return $count;
	}

	public function unblockBetweenPallet($fromDate, $toDate){
		$sql = "update Pallets set blocked = false where timeMade >= ? and timeMade <= ?";
		$this->conn->beginTransaction();
		$count = $this->executeUpdate($sql, array($fromDate, $toDate));
		if ($count < 0){
			$this->conn->rollBack();
			return -1;
		}
		$this->conn->commit();
		return $count;
	}

	public function unblockPallet($palletId){
		$sql = "update Pallets set blocked = false where palletId = ?";
		$this->conn->beginTransaction();
		$count = $this->executeUpdate($sql, array($palletId));
		if ($count != 1){
			$this->conn->rollBack();
			return -1;
		}
		$this->conn->commit();
		return $count;
	}

}
?>
