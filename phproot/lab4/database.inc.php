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
	
	/**
	 * Check if a user with the specified user id exists in the database.
	 * Queries the Users database table.
	 *
	 * @param userId The user id 
	 * @return true if the user exists, false otherwise.
	 */
	public function userExists($userId) {
		$sql = "select uName from Users where uName = ?";
		$result = $this->executeQuery($sql, array($userId));
		return count($result) == 1; 
	}

	/*
	 * *** Add functions ***
	 */

	public function getMovieNames(){
		$sql = "select mName from Movies";
		$results = $this->executeQuery($sql);
		
		foreach($results as $result){
			$movienames[] = $result['mName'];
		}
		return $movienames; 
	}

	public function getDates($movie){
		$sql = "select sDate from Shows where mName=?";
		$results = $this->executeQuery($sql, array($movie));
		
		foreach($results as $result){
			$sDates[] = $result['sDate'];
		}
		return $sDates; 
	}

	public function getPerformance($movie, $date){
		$sql = "select sDate,mName,tName, (capacity-nbrBooked) as freeSeats from Shows natural join Theaters where sDate = ? and mName = ?";
		$results = $this->executeQuery($sql, array($date, $movie));
		$c = count($results);
		if($c == 1){ 
		 foreach($results as $result){
		 	$sDate = $result['sDate'];
		 	$mName = $result['mName'];
		 	$theater = $result['tName'];
		 	$freeSeats = $result['freeSeats'];
		}
		$show['sDate'] = $sDate;
		$show['mName'] = $mName;
		$show['tName'] = $theater;
		$show['freeSeats'] = $freeSeats;
		$show['c'] = $c;
		}else
		{
			$show['error'] = 1;
		}
		return $show; 
	}

	public function bookTicket($show, $user){//$movie, $date, $user
		$sql = "select (capacity-nbrBooked) as freeSeats from Shows natural join Theaters where sDate = ? and mName = ? for update";
		$this->conn->beginTransaction();		
//$this->$conn->beginTransaction();
		$results = $this->executeQuery($sql, array($show['sDate'], $show['mName']));
		$count = count($results);
		if ($count == 1){
			foreach ($results as $result){
				$freeSeats = $result['freeSeats'];
			}
		}else{
			$this->conn->rollBack();
			//conn->rollback();
			return -1;
		}

		if ($freeSeats <= 0){
			$this->conn->rollBack();
			//$conn->rollback();
			return -2;
		}
		$sql = "insert into Reservations(uName,sDate,mName) values(?, ?, ?)";
		$count = $this->executeUpdate($sql, array($user, $show['sDate'], $show['mName']));
		if ($count != 1){
			$this->conn->rollBack();
			//$conn->rollback();
			return -3;
		}
		$sql = "update Shows set nbrBooked = nbrBooked+1 where mName = ? and sDate = ?";
		$count = $this->executeUpdate($sql, array($show['mName'], $show['sDate']));
		if ($count != 1){
			$this->conn->rollBack();
			//$conn->rollback();
			return -4;
		}
		$sql = "select last_insert_id() as last_id";
		$results = $this->executeQuery($sql);
		$count = count($results);
		if($count == 1){
		foreach($results as $result){
			$rNbr = $result['last_id'];
		}
		}else{
			$this->conn->rollBack();
			//$conn->rollback();
			return -5;
		}
		$this->conn->commit();
		//$this->$conn->commit();
		return $rNbr;
		
	}
}
?>
