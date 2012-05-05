<?php
//Include the system's core
	require_once("../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Book Exchange", "" , "", "<link href=\"system/stylesheets/style.css\" rel=\"stylesheet\" />
<script src=\"system/javascripts/interface.js\"></script>");
	echo "<section class=\"body\">
";
	
//Display the header which contains a "Sell Books" button, seach section, and scroller containing featured books and categories
	echo "<section class=\"header\">
<div class=\"tools\">
<button class=\"button blue\" style=\"width: 100%;\">Sell Books</button>

<h2 class=\"search\">Search for Books:</h2>
<input type=\"text\" class=\"search\" />

<div class=\"controls\">
<div class=\"categoryFlyWrapper\">
<ul class=\"categoryFly\">
<li class=\"selected\"><span class=\"band\" style=\"border-left-color: #FF0000;\"><span class=\"icon\" style=\"background-image: url('http://cdn1.iconfinder.com/data/icons/windows8_icons/26/tear_off_calendar.png');\">This is stuffz</span></span></li>
<li><span class=\"band\" style=\"border-left-color: #00FF00;\"><span class=\"icon\" style=\"background-image: url('http://cdn1.iconfinder.com/data/icons/windows8_icons/26/tear_off_calendar.png');\">This is stuff</span></span></li>
<li><span class=\"band\" style=\"border-left-color: #0000FF;\"><span class=\"icon\" style=\"background-image: url('http://cdn1.iconfinder.com/data/icons/windows8_icons/26/tear_off_calendar.png');\">This is stuff</span></span></li>
<li><span class=\"band\" style=\"border-left-color: #FF0000;\"><span class=\"icon\" style=\"background-image: url('http://cdn1.iconfinder.com/data/icons/windows8_icons/26/tear_off_calendar.png');\">This is stuffz</span></span></li>
</ul>
</div>

<button class=\"button\">Search Books</button>
</div>
</div>

<div class=\"linkbar\">
Hi
</div>
</section>";

//Get and display the category bar
	$categories = mysql_query("SELECT * FROM `book-categories` ORDER BY name ASC", $connDBA);
	
	echo "<aside class=\"categories\">
<h2>Book Categories</h2>

<ul>";

	while ($category = mysql_fetch_array($categories)) {
		echo "
<li>
<a href=\"#\" class=\"name\">
<span class=\"icon\" style=\"background-color: " . $category['color'] . "\"><img src=\"http://cdn1.iconfinder.com/data/icons/windows8_icons/26/tear_off_calendar.png\" /></span>
<span class=\"text\">" . $category['name'] . "</span>
</a>
</li>
";
	}
	
	echo "</ul>
</aside>

";

//Beginning main content
	echo "<section class=\"main\">
";

//Fetch the recent uploads
	$allRecent = mysql_query("SELECT * FROM `books` ORDER BY upload ASC LIMIT 4", $connDBA);
	
	echo "<h2 class=\"sectionHeader\">
";
	
//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>