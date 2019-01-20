<?php	
	$host = 'mysql';
	$user = 'root';
	$pass = 'rootpassword';
	
	$mysqli = new mysqli($host, $user, $pass);
	
	$sql = "CREATE DATABASE dataintegration";
	mysqli_query($mysqli, $sql);
	
	$mysqli = new mysqli($host, $user, $pass, "dataintegration");
	
	$sql = "CREATE TABLE dataintegration.all_merged_dataset_with_id_copy_and_priority(
	  title VARCHAR(150) DEFAULT NULL,
	  ingredients TEXT DEFAULT NULL,
	  instructions VARCHAR(255) DEFAULT NULL,
	  source VARCHAR(250) DEFAULT NULL,
	  categories VARCHAR(255) DEFAULT NULL,
	  rating DOUBLE DEFAULT NULL,
	  course VARCHAR(100) DEFAULT NULL,
	  cuisine VARCHAR(100) DEFAULT NULL,
	  flavors VARCHAR(150) DEFAULT NULL,
	  numberOfservings DOUBLE DEFAULT NULL,
	  picture_link VARCHAR(255) DEFAULT NULL,
	  thumbnailUrl VARCHAR(150) DEFAULT NULL,
	  totalTime VARCHAR(50) DEFAULT NULL,
	  totalTimeInSeconds DOUBLE DEFAULT NULL,
	  yield VARCHAR(200) DEFAULT NULL,
	  recipeID MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
	  duplicate TINYINT(1) DEFAULT NULL,
	  priority INT(11) DEFAULT NULL,
	  du_reference INT(11) DEFAULT NULL,
	  PRIMARY KEY (recipeID)
	)";
	mysqli_query($mysqli, $sql);
	
	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file("data.sql");
	// Loop through each line
	foreach ($lines as $line){
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';'){
			// Perform the query
			mysqli_query($mysqli, $templine);
			// Reset temp variable to empty
			$templine = '';
		}
	}
	
	header('Location: ./home.php');
?>