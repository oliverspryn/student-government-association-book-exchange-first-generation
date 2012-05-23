<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Grab the categories from the database and count the total number of books for sale
	if (exist("book-categories")) {
		$categories = array();
		$total = 0;
		$categoryGrabber = mysql_query("SELECT * FROM `book-categories` ORDER BY name ASC", $connDBA);
		
		while($category = mysql_fetch_array($categoryGrabber)) {
			array_push($categories, $category);
			$total += $category['total'];
		}
	} else {
		$categories = false;
	}

//Include the top of the page from the administration template
	topPage("public", "All Book Listings", "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>");
	echo "<section class=\"body\">
";

//Include the page header
	echo "<header class=\"styled all\">
<h1>All Book Listings</h1>
";
	
	if ($total == 1) {
		echo "<h2>1 Book for Sale</h2>
</header>
";
	} else {
			echo "<h2>" . $total . " Books for Sale</h2>
</header>
";
	}
	
//Display the categories
	if (exist("book-categories")) {
		echo "<ul class=\"listing\">";
		
		foreach($categories as $category) {
			echo "
<li>
<a href=\"view-listing.php?id=" . $category['id'] . "\"><img src=\"../../data/book-exchange/icons/" . $category['id'] . "/icon_128.png\" /></a>
<a href=\"view-listing.php?id=" . $category['id'] . "\" class=\"title\">" . $category['name'] . "</a>
<span class=\"description\">" . $category['description'] . "</span>
";
	
			
			switch($category['total']) {
				case "0" : 
					echo "<span class=\"buttonLink\"><span>No Books Avaliable... yet</span></span>
</li>";
					break;
					
				case "1" : 
					echo "<a class=\"buttonLink\" href=\"view-listing.php?id=" . $category['id'] . "\"><span>Browse 1 Book</span></a>
</li>";
					break;
					
				default : 
					echo "<a class=\"buttonLink\" href=\"view-listing.php?id=" . $category['id'] . "\"><span>Browse " . $category['total'] . " Books</span></a>
</li>";
					break;
			}
		}
		
		echo "
</ul>";
	} else {
		$categories = false;
	}

//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>