<?php
//Include the system's core
	require_once("../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Book Exchange", "" , "", "<link href=\"system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"system/stylesheets/main.css\" rel=\"stylesheet\" />
<script src=\"system/javascripts/interface.js\"></script>");
	echo "<section class=\"body\">
";

//Grab the categories from the database
	if (exist("bookcategories")) {
		$categories = array();
		$categoryGrabber = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);
		
		while($category = mysql_fetch_array($categoryGrabber)) {
			array_push($categories, $category);
		}
	} else {
		$categories = false;
	}
	
//Display the header which contains a "Sell Books" button and a seach section
	echo "<section class=\"header\">
<div class=\"tools\">
<button class=\"blue large openLogin\" data-redirect=\"" . $root . "book-exchange/sell-books/\">Sell Books</button>

<form action=\"search\" method=\"get\">
<h2 class=\"search\">Search for Books:</h2>
<input autocomplete=\"off\" class=\"search\" name=\"search\" type=\"text\" />
<span class=\"expand\">Advanced Search Options</span>

<div class=\"controls hidden\">
<div class=\"menuWrapper\">
<div style=\"height: 0px;\"><div><input class=\"collapse noMod\" name=\"category\" type=\"text\" value=\"0\" /></div></div>

<ul class=\"categoryFly\">";

//Generate the category dropdown menu
	$counter = 1;

	foreach($categories as $category) {
	//Break up this "dropdown" list into columns every 10 items
		if ($counter % 10 == 1) {
		//Include an "all" menu item if this is the first item
			if ($counter == 1) {
				echo "
<li>
<ul>
<li class=\"all selected\" data-value=\"0\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('system/images/icons/all.png');\">All Disciplines</span></span></li>";

			//Since we inserted a "free" item, add one to the counter
				$counter++;
			} else {
				echo "
<li>
<ul>";
			}
		}
		
		echo "
<li data-value=\"" . $category['id'] . "\"><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";

		if ($counter % 10 == 0) {
			echo "
</ul>
</li>
";
		}

		$counter++;
	}
	
	echo "
</ul>
</li>
</ul>
</div>

<span class=\"step\">Search by:</span>
<ul class=\"dropdown\" data-name=\"searchBy\">
<li class=\"selected\">Title</li>
<li>Author</li>
<li>ISBN</li>
</div>

<input class=\"submit\" type=\"submit\" value=\"Search\" />
</form>
</div>

";

//Generate a scroller to advertise the most popular books and categories on the site
	

<div class=\"linkbar\">
Hi
</div>
</section>";

//Get and display the category bar
	$counter = 1;
	
	echo "<aside class=\"categories\">
<h2>Book Listings</h2>

<ul>";

	foreach($categories as $category) {
	//If we reach 15 items, cut the list short, and display a "show more" button
		if ($counter == 15) {
			echo "
</ul>

<div class=\"center\">
<button class=\"button\" onclick=\"document.location.href='listings/'\">Show More</button>
</div>
";
			
			break;
		}
		
		echo "
<li>
<a href=\"listings/view-listing.php?id=" . $category['id'] . "\" class=\"name\">
<span class=\"icon\" style=\"background-color: " . $category['color1'] . "\"><img src=\"../data/book-exchange/icons/" . $category['id'] . "/icon_032.png\" /></span>
<span class=\"text\">" . $category['name'] . "</span>
</a>
</li>";

		$counter ++;
	}
	
//If we didn't reach 15 items,then we'll need to append a </ul> to finish the list
	if ($counter < 15) {
		echo "
</ul>
";
	}
	
	echo "</aside>

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