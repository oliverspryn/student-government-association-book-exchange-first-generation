<?php
//Include the system's core
	require_once("../../../Connections/connDBA.php");
	require_once("Validate.php");
	
//Perform a search operation on the database
	if (isset($_GET['term']) && $_GET['term'] != "") {
		$query = mysql_real_escape_string($_GET['term']);
		//$category = mysql_real_escape_string(Validate::numeric($_GET['category']));
		//$searchBy = mysql_real_escape_string(Validate::required($_GET['searchBy'], array("Title", "Author", "ISBN", "Course")));
		
	//Different search methods will vary the query that is executed on the database
		//switch($searchBy) {
		//	case "Title" : 
				$searchGrabber = mysql_query("SELECT books.*, MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE) AS score, count(books.id) AS total, MIN(books.price) AS price FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE) GROUP BY title ORDER BY score DESC, title ASC, upload ASC LIMIT 7", $connDBA);
		//		break;
		//}
	} else {
		redirect("../");
	}

//Display the results of the search
	$output = array();
	
	while ($search = mysql_fetch_array($searchGrabber)) {
		array_push($output, array("label" => $search['title'], "author" => $search['author'], "image" => $search['imageURL'], "total" => $search['total'], "price" => $search['price']));
	}
	
	echo json_encode($output);
	exit;
?>