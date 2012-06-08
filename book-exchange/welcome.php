<?php
//Include the system's core
	require_once("../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Book Exchange", "" , "", "<link href=\"system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"system/stylesheets/welcome.css\" rel=\"stylesheet\" />
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
	echo "<section class=\"favorites\">
<h2>Some of our favorites:</h2>

<div class=\"overFlowHide\">
<ul class=\"scrollerContainer\">
";

//Generate a scroller to advertise the most popular books and categories on the site
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
<h2 title=\"" . $featured['title'] . "\">" . $featured['title'] . "</h2>
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

//Display part three of the welcome page
	$categoriesGrabber = mysql_query("SELECT bookcategories.id, bookcategories.name, COUNT(bookcategories.id) AS repeats FROM books RIGHT JOIN (bookcategories) ON bookcategories.id = books.course WHERE books.id IS NOT NULL GROUP BY bookcategories.id ORDER BY repeats DESC, title ASC LIMIT 8", $connDBA);

	echo "<section class=\"categories\">
<h2>Popular categories</h2>
</section>";

//Display part four of the welcome page
	$booksCounter = mysql_query("SELECT * FROM books", $connDBA);
	$books = mysql_num_rows($booksCounter);
	
	if ($books >= 0 && $books <= 199) {
		$totalBooks = "the growing database";
	} elseif ($books >= 199 && $books <= 1999) {
		$totalBooks = "hundreds";
	} else {
		$totalBooks = "thousands";
	}

	echo "<section class=\"questions\">
<div class=\"design\">
<h2>What Can I do Here?</h2>

<ul>
<li>
<img src=\"system/images/welcome/sell_books.png\" />
<h3>Buy and Sell Books</h3>
<p>Sell your books in three easy steps, and buy other at discounted prices.</p>
<button class=\"blue\">Try it Now!</button>
</li>

<li>
<img src=\"system/images/welcome/search.png\" />
<h3>Search the Growing Database</h3>
<p>Search " . $totalBooks . " of books by title, author, course, or ISBN,  contributed by students like you!</p>
<button class=\"blue\">Try it Now!</button>
</li>

<li>
<img src=\"system/images/welcome/categories.png\" />
<h3>Browse by Category</h3>
<p>Each category has its own unique color tile, designed to catch your eye when you come across a class you recognize.</p>
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