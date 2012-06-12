<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Grab the information about a certain book category
	if (exist("bookcategories", "id", $_GET['id'])) {
		$categoryGrabber = mysql_query("SELECT bookcategories.*, COUNT(DISTINCT books.linkID) as total FROM `bookcategories` LEFT JOIN (books) ON bookcategories.id = books.course WHERE bookcategories.id = '{$_GET['id']}' GROUP BY bookcategories.name ORDER BY name ASC", $connDBA);
		$category = mysql_fetch_array($categoryGrabber);
	} else {
		redirect("index.php");
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . $title['title'] . "</a></li>
<li><a href=\"../\">Book Exchange</a></li>
<li><a href=\"../listings\">All Book Listings</a></li>
<li>" . $category['name'] . "</li>\n";
	
//Include the top of the page from the administration template
	topPage("public", $category['name'], "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>", $breadcrumb);
	echo "<section class=\"body\">
";

//Include the page header
	echo "<header class=\"styled\" style=\"border-top-color: " . $category['color1'] . "\">
<h1 style=\"background-color: " . $category['color3'] . "; border-color: " . $category['color2'] . ";\">" . $category['name'] . "</h1>
";
	
	if ($category['total'] == 1) {
		echo "<h2>1 Book for Sale</h2>
</header>
";
	} else {
		echo "<h2>" . $category['total'] . " Books for Sale</h2>
</header>
";
	}
	
	echo "
<aside class=\"info\">
";

//Display the main icon for this category
	echo "<img class=\"icon\" src=\"../../data/book-exchange/icons/" . $category['id'] . "/icon_256.png\" />";
	
//Display a search form for this listing
	if ($category['total'] > 0) {
		echo "

<h2 style=\"color:" . $category['color1'] . "\">Search this Listing</h2>
<form action=\"" . $root . "book-exchange/search\" method=\"get\">
<input autocomplete=\"off\" class=\"search full\" name=\"search\" type=\"text\" />
<input type=\"hidden\" name=\"category\" value=\"" . $_GET['id'] . "\" />
<span class=\"expand\">Advanced Search Options</span>

<div class=\"controls hidden\">
<span class=\"step\">Search by:</span>
<ul class=\"dropdown\" data-name=\"searchBy\">
<li class=\"selected\">Title</li>
<li>Author</li>
<li>ISBN</li>
</ul>

<br>
<span class=\"step\">In: <strong>" . $category['name'] . "</strong></span>
</div>
<input type=\"submit\" value=\"Search\" />
</form>";
	}
	
//Display a listing of featured books in this category
	$featuredList = "";
	$featuredGrabber = mysql_query("SELECT ISBN, title, author, imageURL, COUNT(DISTINCT linkID) AS repeats FROM books WHERE course = '" . $_GET['id'] . "' GROUP BY ISBN HAVING repeats > 1 ORDER BY repeats DESC LIMIT 7", $connDBA);
		
	while ($featured = mysql_fetch_assoc($featuredGrabber)) {
		 $featuredList .= "
<li>
<a href=\"../search/?search=" . $featured['ISBN'] . "&category=" . $_GET['id'] . "&searchBy=ISBN&options=false\"><img src=\"" . $featured['imageURL'] . "\" /></a>
<a href=\"../search/?search=" . $featured['ISBN'] . "&category=" . $_GET['id'] . "&searchBy=ISBN&options=false\" class=\"title\" title=\"" . $featured['title'] . "\">" . $featured['title'] . "</a>
<span class=\"details\">Author: " . $featured['author'] . "</span>
<a href=\"../search/?search=" . $featured['ISBN'] . "&category=" . $_GET['id'] . "&searchBy=ISBN&options=false\" class=\"buttonLink\"><span>Browse from " . $featured['repeats'] . " Sellers</span></a>
</li>
";
	}
	
//If $featuredList is not empty, then the while() loop filled it with values, and at least one value exists
	if (!empty($featuredList)) {
		echo "
		
<h2 style=\"color:" . $category['color1'] . "\">Featured Books</h2>
<ul>";
		echo $featuredList;
		echo "</ul>";
	}
	
//Display a listing of recent additions to this category
	$recentList = "";
	$recentGrabber = mysql_query("SELECT books.*, users.id AS userTableID, users.firstName, users.lastName, users.emailAddress1 FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE books.course = '" . $_GET['id'] . "' GROUP BY books.linkID ORDER BY books.upload DESC LIMIT 7", $connDBA);
		
	while ($recent = mysql_fetch_assoc($recentGrabber)) {
		 $recentList .= "
<li>
<a href=\"../book/?id=" . $recent['id'] . "\"><img src=\"" . $recent['imageURL'] . "\" /></a>
<a href=\"../book/?id=" . $recent['id'] . "\" class=\"title\" title=\"" . $recent['title'] . "\">" . $recent['title'] . "</a>
<span class=\"details\">Author: " . $recent['author'] . "</span>
<span class=\"details\">Seller: " . $recent['firstName'] . " " . $recent['lastName'] . "</span>
<a href=\"javascript:;\" class=\"buttonLink buy\" data-fetch=\"" . $recent['id'] . "\"><span>\$" . $recent['price'] . "</span></a>
</li>
";
	}
	
//If $recentList is not empty, then the while() loop filled it with values, and at least one value exists
	if (!empty($recentList)) {
		echo "
		
<h2 style=\"color:" . $category['color1'] . "\">Recent Additions</h2>
<ul>";
		echo $recentList;
		echo "</ul>";
	}
	
//Display a list of other categories that the user can browse
	$allCatGrabber = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);
	
	echo "
	
<h2 style=\"color:" . $category['color1'] . "\">More Book Listings</h2>
<ul class=\"moreListings\">";
	
	while ($allCat = mysql_fetch_array($allCatGrabber)) {
		if ($allCat['id'] == $_GET['id']) {
			echo "
<li><a href=\"view-listing.php?id=" . $allCat['id'] . "\" style=\"color: " . $category['color1'] . "; font-weight: bold;\">" . $allCat['name'] . " <span class=\"arrow\">&raquo;</span></a></li>";
		} else {
			echo "
<li><a href=\"view-listing.php?id=" . $allCat['id'] . "\">" . $allCat['name'] . " <span class=\"arrow\" style=\"color: " . $category['color1'] . ";\">&raquo;</span></a></li>";
		}
	}
	
	echo "
</ul>
</aside>

<section class=\"listing\">
";

//Display a Wikipedia article introduction at the top of the main content
//Client-side code will fetch the article, so just provide the container
	echo "<article class=\"description\">
<section class=\"article loading\"></section>
<a href=\"javascript:;\" class=\"buttonLink\" style=\"display: none;\"><span>Read More</span></a>
<section class=\"disclaimer hidden\">The entry was extracted from <a class=\"highlight\" href=\"http://en.wikipedia.org/\" target=\"_blank\">Wikipedia</a>, which is licensed under the <a class=\"highlight\" href=\"http://creativecommons.org/licenses/by-sa/3.0/\" target=\"_blank\">CC BY-SA 3.0</a> license. The contents of the entry above reflect the views of the Wikipedia contributors, not the views of this site's owner, maintenance staff, or parent organization.</section>
</article>";

//Fetch and display a listing of books by course ID and futhermore course ID and section letter
	$currentNumber = "0";
	$currentSection = "0";
	$firstInSection = false;
	$counter = 0;
	$booksGrabber = mysql_query("SELECT books.*, users.id AS userTableID, users.firstName, users.lastName, users.emailAddress1 FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE books.course = '" . $_GET['id'] . "' ORDER BY books.number, books.section, books.title ASC");
	
	echo "
	
<section class=\"books\">
";
	
	while ($books = mysql_fetch_array($booksGrabber)) {
	//If this is a our first iteration or first iteration through a course number, save the number as a marker, and print a new <section>
		if ($currentNumber == "0" || $currentNumber != $books['number']) {
			if ($currentNumber != "0") {
				echo "</ul>
</section>

<section class=\"courses\">
<h2><a href=\"#\" style=\"color: " . $category['color1'] .";\">" . $category['course'] . " " . $books['number'] . " &raquo;</a></h2>
";
			} else {
				echo "<section class=\"courses\">
<h2><a href=\"#\" style=\"color: " . $category['color1'] .";\">" . $category['course'] . " " . $books['number'] . " &raquo;</a></h2>
";
			}
			
			$currentNumber = $books['number'];
			$firstInSection = true; //We have started a new section, so make sure the nested <ul> knows which is the first item!
		}
		
	//If this is a our first iteration or first iteration through a course letter, save the letter as a marker, and print a new <ul>
		if ($currentSection == "0" || $currentSection != $books['section']) {
			if (!$firstInSection) {
				echo "</ul>

<ul>
<li>" . $books['section'] . "</li>
";
			} else {
				echo "<ul>
<li>" . $books['section'] . "</li>
";
			}
		}
			
		echo "<li>
<img src=\"" . $books['imageURL'] . "\" />
<span class=\"title\" title=\"" . htmlentities($books['title']) . "\">" . $books['title'] . "</span>
<span class=\"details\">Author: " . $books['author'] . "</span>
<span class=\"details\">Seller: " . $books['firstName'] . " " . $books['lastName'] . "</span>
<a href=\"javascript:;\" class=\"buttonLink buy\" data-fetch=\"" . $books['id'] . "\"><span>\$" . $books['price'] . "</span></a>
</li>
";
		$currentSection = $books['section'];
		$firstInSection = false; //We've already gone at least once through section, so make sure the nested <ul> knows that!
		
	//Keep track of the iterations, if any were done at all
		$counter ++;
	}
	
//Print the closing tags, if any books were listed in this category
	if ($counter > 0) {
		echo "</li>
</ul>
</div>
</section>";
	} else {
		echo "<section class=\"empty\">
<p>We don't have any books for sale in " . $category['name'] . " right now. Come back later, and we'll be sure to have some!</p>
</section>";
	}

//Include the footer from the administration template
	echo "
</section>
</section>
</section>";

	footer("public");
?>