<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("admin", "Question of the Week", "question", array("question", 1));
	
//Add a toolbar for administrative access other features of this plugin
	echo "<nav class=\"toolbar\"></nav>";
	
//Include the footer from the administration template
	footer("admin");
?>