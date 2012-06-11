<?php
//Include the system's core
	require_once("../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Book Exchange", "" , "", "<link href=\"system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"system/stylesheets/main.css\" rel=\"stylesheet\" />
<script src=\"system/javascripts/interface.js\"></script>
<script src=\"../javascripts/jQuery/jquery.jcarousel.min.js\"></script>
<script>

jQuery(document).ready(function() {
    jQuery('ul.scrollerContainer').jcarousel({
		'scroll' : 1,
		'auto' : 7,
		'wrap' : 'last'
	});
});

</script>");
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
	foreach($categories as $category) {
		echo "<li data-value=\"" . $category['id'] . "\">" . $category['name'] . "</li>
";
	}
	
	echo "</ul>
</div>

<input class=\"yellow submit\" type=\"submit\" value=\"Search\" />
</form>
</div>

<div class=\"overFlowHide\">
<ul class=\"scrollerContainer\">
";

//Generate a scroller to advertise the most popular books and categories on the site
	$featuredList = "";
	$featuredGrabber = mysql_query("SELECT books.*, COUNT(books.id) AS repeats, bookcategories.name, bookcategories.course AS courseShortName, bookcategories.description, bookcategories.total, bookcategories.color1, bookcategories.color2, bookcategories.color3, bookcategories.textColor, MIN(books.price) AS minPrice, MAX(books.price) AS maxPrice, GROUP_CONCAT(DISTINCT books.course) AS listedInID, GROUP_CONCAT(DISTINCT bookcategories.name) AS listedIn FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id GROUP BY title HAVING repeats > 1 ORDER BY repeats DESC LIMIT 7", $connDBA);
		
	while ($featured = mysql_fetch_assoc($featuredGrabber)) {
	//Reformat the name of the categories from a simple comma-seperated list into an English-ready sentence
		$listedIn = explode(",", $featured['listedIn']);
		$formattedList = "";
		
		switch(sizeof($listedIn)) {
			case 1 : 
				$formattedList = $listedIn[0];
				break;
				
			case 2 : 
				$formattedList = $listedIn[0] . " and " . $listedIn[1];
				break;
				
			default : 
				for ($i = 0; $i <= sizeof($listedIn) - 2; $i++) { //We are doing size - 2 so that we can manually add an "and" before the last item
					$formattedList .= $listedIn[$i] . ", ";
				}
				
				$formattedList .= "and " . $listedIn[sizeof($listedIn) - 1];
				break;
		}
		
	//Explode the string of comma-seperated category IDs
		$listedInID = explode(",", $featured['listedInID']);
		$formattedIDList = "<ul>
<li><span>Find this book in: </span></li>
";
		
		for($i = 0; $i <= sizeof($listedInID) - 1; $i++) {
			$formattedIDList .= "<li><img src=\"../data/book-exchange/icons/" . $listedInID[$i] . "/icon_032.png\" title=\"" . $listedIn[$i] . "\" /></li>
";
		}
		
		$formattedIDList .= "</ul>";
		
		echo "
<li>
<div class=\"scroller\">
<h2 style=\"color: " . $featured['color1'] . "; border-bottom-color: " . $featured['color1'] . ";\" title=\"" . $featured['title'] . "\">" . $featured['title'] . "</h2>
<span class=\"browse\">Browse " . $featured['repeats'] . " more of these books in " . $formattedList . "</span>
<span class=\"buttonLink\"><span>Starting at \$" . $featured['minPrice'] . "</span></span>
<img class=\"cover\" src=\"" . $featured['imageURL'] . "\" />

" . $formattedIDList . "
</div>
</li>
";
	}
	
	
echo "</ul>
</div>
</section>

";

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
	
	echo "
";
	
//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>