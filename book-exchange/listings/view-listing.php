<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Grab the information about a certain book category
	if (exist("book-categories", "id", $_GET['id'])) {
		$categoryGrabber = mysql_query("SELECT * FROM `book-categories` WHERE `id` = '{$_GET['id']}'", $connDBA);
		$category = mysql_fetch_array($categoryGrabber);
	} else {
		redirect("index.php");
	}
	
//Include the top of the page from the administration template
	topPage("public", $category['name'], "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>");
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
	
//Display a listing of featured books in this category
	$featuredList = "";
	$featuredGrabber = mysql_query("SELECT title, author, imageURL, count(id) AS repeats FROM books WHERE course = '" . $_GET['id'] . "' GROUP BY title HAVING repeats > 1 ORDER BY repeats DESC LIMIT 5", $connDBA);
		
	while ($featured = mysql_fetch_assoc($featuredGrabber)) {
		 $featuredList .= "
<li>
<a href=\"#\"><img src=\"" . $featured['imageURL'] . "\" /></a>
<a href=\"#\" class=\"title\">" . $featured['title'] . "</a>
<span class=\"author\">Author: " . $featured['author'] . "</span>
<a href=\"#\" class=\"buttonLink\"><span>Browse from " . $featured['repeats'] . " Sellers</span></a>
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
	$recentGrabber = mysql_query("SELECT * FROM books WHERE course = '" . $_GET['id'] . "' ORDER BY upload DESC LIMIT 5", $connDBA);
		
	while ($recent = mysql_fetch_assoc($recentGrabber)) {
		 $recentList .= "
<li>
<a href=\"#\"><img src=\"" . $recent['imageURL'] . "\" /></a>
<a href=\"#\" class=\"title\">" . $recent['title'] . "</a>
<span class=\"author\">Author: " . $recent['author'] . "</span>
<a href=\"#\" class=\"buttonLink\"><span>\$" . $recent['price'] . "</span></a>
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
	
	echo "
</aside>

<section class=\"listing\">
";

//Display a Wikipedia article introduction at the top of the main content
//Client-side code will fetch the article, so just provide the container
	echo "<article class=\"description\">
<section class=\"article loading\"></section>
<a href=\"\" class=\"buttonLink\" style=\"display: none;\"><span>Read More</span></a>
<section class=\"disclaimer hidden\">The entry was extracted from <a class=\"highlight\" href=\"http://en.wikipedia.org/\" target=\"_blank\">Wikipedia</a>, which is licensed under the <a class=\"highlight\" href=\"http://creativecommons.org/licenses/by-sa/3.0/\" target=\"_blank\">CC BY-SA 3.0</a> license. The contents of the entry above reflect the views of the Wikipedia contributors, not the views of this site's owner, maintenance staff, or parent organization.</section>
</article>";

//Include the footer from the administration template
	echo "
</section>
</section>";

	footer("public");
?>