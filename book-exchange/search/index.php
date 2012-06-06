<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	require_once("../system/server/Validate.php");
	
//Perform a search operation on the database
	if (isset($_GET['search']) && $_GET['search'] != "") {
		$query = mysql_real_escape_string($_GET['search']);
		$category = mysql_real_escape_string(Validate::numeric($_GET['category']));
		$searchBy = mysql_real_escape_string(Validate::required($_GET['searchBy'], array("Title", "Author", "ISBN", "Course")));
		
	//Different search methods will vary the query that is executed on the database
		switch($searchBy) {
			case "Title" : 
				$searchGrabber = mysql_query("SELECT books.*, users.id AS userTableID, users.firstName, users.lastName, users.emailAddress1, MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE) AS score FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE) GROUP BY linkID ORDER BY score DESC, title ASC, upload ASC", $connDBA);
				break;
		}
	} else {
		redirect("../");
	}
			
//Include the top of the page from the administration template
	topPage("public", "Search Reults for &quot;" . $_GET['search'] . "&quot;", "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />");
	echo "<section class=\"body\">
";

//Display the results of the search
	while ($search = mysql_fetch_array($searchGrabber)) {
		echo $search['title'] . "<br />";
	}
	
//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>