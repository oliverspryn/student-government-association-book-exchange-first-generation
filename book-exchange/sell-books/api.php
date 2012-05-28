<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	require_once("../../Connections/jsonwrapper/jsonwrapper.php");
	
//Check and see if a given ISBN number exists in the database
	if (isset($_GET['ISBN']) && strlen($_GET['ISBN']) == 10) {
		$ISBN = $_GET['ISBN'];
		$ISBNGrabber = mysql_query("SELECT books.*, bookcategories.name, bookcategories.course AS courseID, bookcategories.color1 FROM `books` RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE books.ISBN = '{$ISBN}' ORDER BY books.upload ASC LIMIT 1", $connDBA);
		$ISBNData = mysql_fetch_assoc($ISBNGrabber);
		
		if ($ISBNData) {		
			echo json_encode($ISBNData);
		} else {
			echo "failure";
		}
	} else {
		echo "failure";
	}
?>