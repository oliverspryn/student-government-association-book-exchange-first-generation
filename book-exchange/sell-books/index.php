<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Sell Books", "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>
<script src=\"http://cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js\"></script>");
	echo "<section class=\"body\">
";

//Display the page header
	echo "<header class=\"styled sell\"><h1>Sell Your Books</h1></header>
	
";
	
//Include a book preview box
	echo "<section class=\"bookPreview\">
<div class=\"imageContainer\">
<p>Enter the book's ISBN and we'll show the book cover here</p>
</div>

<span class=\"title\">&lt;Book Title&gt;</span>
<span class=\"details\">Author: &lt;Book Author&gt;</span>
<span class=\"details\">Seller: " . $userData['firstName'] . " " . $userData['lastName']  . "</span>
</section>";

//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>