<?php
//Include the system's core
	require_once("../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Book Exchange", "" , "", "<link href=\"system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"system/stylesheets/welcome.css\" rel=\"stylesheet\" />
<script src=\"system/javascripts/interface.js\"></script>");
	echo "<section class=\"body\">
";

//Grab the list of categories
	$categories = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);

//Display part one of the welcome page
	echo "<section class=\"welcome\">
<h1>SGA Book Exchange</h1>

<div class=\"mask\">
<button class=\"blue large openLogin\" data-redirect=\"" . $root . "book-exchange/sell-books/\">Sell Books</button>

<form action=\"search\" method=\"get\">
<h2 class=\"search\">Search for Books:</h2>
<input autocomplete=\"off\" class=\"search\" name=\"search\" type=\"text\" />
<span class=\"expand\">Advanced Search Options</span>

<div class=\"controls hidden\">
<span class=\"step\">Search by:</span>
<ul class=\"dropdown\" data-name=\"searchBy\">
<li class=\"selected\">Title</li>
<li>Author</li>
<li>ISBN</li>
</ul>

<br>

<span class=\"step\">In:</span>
<ul class=\"dropdown\">
<li class=\"selected\" data-value=\"0\">All Disciplines</li>
";

//Generate the category dropdown menu
	while($category = mysql_fetch_array($categories)) {
		echo "<li data-value=\"" . $category['id'] . "\">" . $category['name'] . "</li>
";
	}
	
	echo "</ul>
</div>

<input class=\"green submit\" type=\"submit\" value=\"Search\" />
</form>
</div>
</section>

";

//Display part two of the welcome page
	echo "<section class=\"questions\">
<div class=\"design\">
<h2>What Can I do Here?</h2>

<ul>
<li>
<img src=\"system/images/welcome/sell_books.png\" />
<h3>Buy and Sell Books</h3>
<button class=\"blue\">Try it Now!</button>
</li>

<li>
<img src=\"system/images/welcome/search.png\" />
<h3>Search the Growing Database</h3>
<button class=\"blue\">Try it Now!</button>
</li>

<li>
<img src=\"system/images/welcome/categories.png\" />
<h3>Browse by Category</h3>
<button class=\"blue\">Try it Now!</button>
</li>
</ul>
</div>
</section>";
	
//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>