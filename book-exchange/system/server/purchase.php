<?php
//Include the system's core
	require_once("../../../Connections/connDBA.php");
	require_once("../../../Connections/jsonwrapper/jsonwrapper.php");
	
//Fetch all relevant data from the database
	if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
		$datagrabber = mysql_query("SELECT books.ISBN, books.title, books.author, books.edition, CONCAT_WS(' ', bookcategories.name, books.number, books.section) AS class, books.price, books.condition, books.written, books.comments, books.imageURL, users.firstName, users.lastName, users.emailAddress1 FROM `books` RIGHT JOIN (bookcategories) ON books.course = bookcategories.id RIGHT JOIN (users) ON books.userID = users.id WHERE books.linkID = (SELECT linkID FROM books WHERE id = '{$_GET['id']}' LIMIT 1)", $connDBA);
		
		if ($datagrabber) {
		//If this book is listed for multiple classes, then collapse these values into one value
			$overview = array();
			$classes = array();
			$counter = 1;
			
			while($data = mysql_fetch_assoc($datagrabber)) {
				if ($counter == 1) {
					$overview = $data;
				}
				
				array_push($classes, $data['class']);
			}
			
			$classes = implode(", ", $classes);
			$overview['class'] = $classes;
						
			echo json_encode($overview);
		}
	}
?>