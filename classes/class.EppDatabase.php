<?php

class EppDatabase {
	  
	 public	$dbHost = DB_SERVER;
     public $dbUser = DB_USER;
     public $dbName = DB_NAME;
     public $dbPass = DB_PASS;
	 public $InsertID;


	//Connects to the database and returns a result	
	function EppDatabaseQuery($query){
			$dbLink = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);
			if(!$dbLink) die("Could not connect to database. " . mysql_error());
			// Select database
			mysql_select_db($this->dbName);
			$result = mysql_query($query);			
			 // Test to make sure query worked
			if(!$result) die("Query didn't work. " . mysql_error());
			// Assign the values to the data members
			$this->InsertID = mysql_insert_id(); // this will be the autoid
			// Close database connection
			mysql_close($dbLink);
			return $result;
	}
	
	


} // End User class definition
?>