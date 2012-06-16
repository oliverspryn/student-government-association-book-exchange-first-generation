<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Grab the information about a certain book category
	if (exist("bookcategories", "id", $_GET['id'])) {
		if (isset($_GET['number']) && isset($_GET['section'])) {
			$categoryGrabber = mysql_query("SELECT bookcategories.*, COUNT(DISTINCT books.linkID) as total FROM `bookcategories` LEFT JOIN (books) ON bookcategories.id = books.course WHERE bookcategories.id = '{$_GET['id']}' AND books.number = '{$_GET['number']}' AND books.section = '{$_GET['section']}' GROUP BY bookcategories.name ORDER BY name ASC", $connDBA);
		} elseif (isset($_GET['number']) && !isset($_GET['section'])) {
			$categoryGrabber = mysql_query("SELECT bookcategories.*, COUNT(DISTINCT books.linkID) as total FROM `bookcategories` LEFT JOIN (books) ON bookcategories.id = books.course WHERE bookcategories.id = '{$_GET['id']}' AND books.number = '{$_GET['number']}' GROUP BY bookcategories.name ORDER BY name ASC", $connDBA);
		} else {
			$categoryGrabber = mysql_query("SELECT bookcategories.*, COUNT(DISTINCT books.linkID) as total FROM `bookcategories` LEFT JOIN (books) ON bookcategories.id = books.course WHERE bookcategories.id = '{$_GET['id']}' GROUP BY bookcategories.name ORDER BY name ASC", $connDBA);
		}
		
		$category = mysql_fetch_array($categoryGrabber);
	} else {
		redirect("index.php");
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . $title['title'] . "</a></li>
<li><a href=\"../\">Book Exchange</a></li>
<li><a href=\"../listings\">All Book Listings</a></li>\n";
	
//Generate the title for the page and <header> as well as any specific class names that are needed for the header
	if (isset($_GET['number']) && isset($_GET['section'])) {
		$title = $category['name'] . " " . $_GET['number'] . " " . $_GET['section'];
		$class = " noSide";
	} elseif (isset($_GET['number']) && !isset($_GET['section'])) {
		$title = $category['name'] . " " . $_GET['number'];
		$class = " noSide";
	} else {
		$title = $category['name'];
		$class = "";
	}
	
//If the user has drilled down into class numbers and sections, add more to the breadcrumb
	if (isset($_GET['number']) && isset($_GET['section'])) {
		$breadcrumb .= "<li><a href=\"view-listing.php?id=" . $_GET['id'] . "\">" . $category['name'] . "</a></li>
<li><a href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $_GET['number'] . "\">" . $_GET['number'] . "</a></li>
<li>" . $_GET['section'] . "</li>\n";
	} elseif (isset($_GET['number']) && !isset($_GET['section'])) {
		$breadcrumb .= "<li><a href=\"view-listing.php?id=" . $_GET['id'] . "\">" . $category['name'] . "</a></li>
<li>" . $_GET['number'] . "</li>\n";
	} else {
		$breadcrumb .= "<li>" . $category['name'] . "</li>\n";
	}
	
//Include the top of the page from the administration template
	topPage("public", $title, "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"../system/stylesheets/view-listing.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>", $breadcrumb);
	echo "<section class=\"body\">
";

//Include the page header
	echo "<header class=\"styled" . $class . "\" style=\"border-top-color: " . $category['color1'] . "\">
<h1 style=\"background-color: " . $category['color3'] . "; border-color: " . $category['color2'] . ";\">" . $title . "</h1>
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
	
//Display a sort by dropdown menu whenever the user has drilled down to section level
	if (isset($_GET['section'])) {
		if (isset($_GET['sort'])) {
			$sortSelected = $_GET['sort'];
		} else {
			$sortSelected = "titleASC";
		}
		
		echo "<div class=\"sort\">
<span>Sort by:</span>

<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"get\">
<input name=\"id\" type=\"hidden\" value=\"" . $_GET['id'] . "\" />
<input name=\"number\" type=\"hidden\" value=\"" . $_GET['number'] . "\" />
<input name=\"section\" type=\"hidden\" value=\"" . $_GET['section'] . "\" />

<select name=\"sort\">
<option value=\"titleASC\"" . ($sortSelected == "titleASC" ? " selected" : "") . ">Title A-Z</option>
<option value=\"titleDESC\"" . ($sortSelected == "titleDESC" ? " selected" : "") . ">Title Z-A</option>
<option value=\"priceASC\"" . ($sortSelected == "priceASC" ? " selected" : "") . ">Price Low to High</option>
<option value=\"priceDESC\"" . ($sortSelected == "priceDESC" ? " selected" : "") . ">Price High to Low</option>
<option value=\"authorASC\"" . ($sortSelected == "authorASC" ? " selected" : "") . ">Author A-Z</option>
<option value=\"authorDESC\"" . ($sortSelected == "authorDESC" ? " selected" : "") . ">Author Z-A</option>
</select>

<input class=\"blue\" type=\"submit\" value=\"Go\" />
</form>
</div>

";
	}
	
//Only display the sidebar whenever the user hasn't drilled down
	if (!isset($_GET['number'])) {
		echo "<aside class=\"info\">
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

";
	}
	
//The style of the main container will need modified if the sidebar isn't there
	if (!isset($_GET['number'])) {
		echo "<section class=\"listing\">
";
	} else {
		echo "<section class=\"listing noSide\">
";
	}
	

//Display a Wikipedia article introduction at the top of the main content
//Client-side code will fetch the article, so just provide the container
	if (!isset($_GET['number'])) {
		echo "<article class=\"description\">
<section class=\"article loading\"></section>
<a href=\"javascript:;\" class=\"buttonLink\" style=\"display: none;\"><span>Read More</span></a>
<section class=\"disclaimer hidden\">The entry was extracted from <a class=\"highlight\" href=\"http://en.wikipedia.org/\" target=\"_blank\">Wikipedia</a>, which is licensed under the <a class=\"highlight\" href=\"http://creativecommons.org/licenses/by-sa/3.0/\" target=\"_blank\">CC BY-SA 3.0</a> license. The contents of the entry above reflect the views of the Wikipedia contributors, not the views of this site's owner, maintenance staff, or parent organization.</section>
</article>

";
	}

//Fetch and display a listing of books by course ID and futhermore course ID and section letter
	$currentNumber = "0";
	$currentSection = "0";
	$firstInSection = false;
	$counter = 0;
	$sectionCounter = 1;
	
	if (isset($_GET['number']) && isset($_GET['section'])) {
		if (isset($_GET['sort'])) {
			switch($_GET['sort']) {
				case "titleASC" : 
					$sort = "books.title ASC, books.price ASC";
					break;
					
				case "titleDESC" : 
					$sort = "books.title DESC, books.price ASC";
					break;
					
				case "priceASC" : 
					$sort = "books.price ASC, books.title ASC";
					break;
					
					
				case "priceDESC" : 
					$sort = "books.price DESC, books.title ASC";
					break;
					
					
				case "authorASC" : 
					$sort = "books.author ASC, books.title ASC";
					break;
					
					
				case "authorDESC" : 
					$sort = "books.author DESC, books.title ASC";
					break;
					
				default : 
					$sort = "books.title ASC";
					break;
			}
		} else {
			$sort = "books.title ASC";
		}
		
		$booksGrabber = mysql_query("SELECT books.*, users.id AS userTableID, users.firstName, users.lastName, users.emailAddress1 FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE books.course = '" . $_GET['id'] . "' AND books.number = '{$_GET['number']}' AND books.section = '{$_GET['section']}' ORDER BY books.number ASC, books.section ASC, " . $sort);
	} elseif (isset($_GET['number']) && !isset($_GET['section'])) {
		$booksGrabber = mysql_query("SELECT books.*, users.id AS userTableID, users.firstName, users.lastName, users.emailAddress1 FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE books.course = '" . $_GET['id'] . "' AND books.number = '{$_GET['number']}' ORDER BY books.number ASC, books.section ASC, books.title ASC");
	} else {
		$booksGrabber = mysql_query("SELECT books.*, users.id AS userTableID, users.firstName, users.lastName, users.emailAddress1 FROM books RIGHT JOIN (users) ON books.userID = users.id WHERE books.course = '" . $_GET['id'] . "' ORDER BY books.number ASC, books.section ASC, books.title ASC");
	}
	
	echo "<section class=\"books\">
";
	
	while ($books = mysql_fetch_array($booksGrabber)) {
	//If this is a our first iteration or first iteration through a course number, save the number as a marker, and print a new <section>
		if ($currentNumber == "0" || $currentNumber != $books['number']) {
			if ($currentNumber != "0") {
				echo "</ul>
";
				if (!isset($_GET['section'])) {
					echo "
<a class=\"more\" href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $currentNumber . "&section=" . $currentSection . "\">See more <span class=\"arrow\" style=\"color: " . $category['color1'] . ";\">&raquo;</span></a>
";
				}

				echo "</section>

<section class=\"courses\">
";

				if (!isset($_GET['number'])) {
					echo "<h2><a href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $books['number'] . "\" style=\"color: " . $category['color1'] .";\">" . $category['course'] . " " . $books['number'] . " &raquo;</a></h2>
";
				}
				
			//We are now in a new section, so reset the section counter
				$sectionCounter = 1;
			} else {
				echo "<section class=\"courses\">
";
				if (!isset($_GET['number'])) {
					echo "<h2><a href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $books['number'] . "\" style=\"color: " . $category['color1'] .";\">" . $category['course'] . " " . $books['number'] . " &raquo;</a></h2>
";
				}
			}
			
			$currentNumber = $books['number'];
			$firstInSection = true; //We have started a new section, so make sure the nested <ul> knows which is the first item!
		}
		
	//If this is a our first iteration or first iteration through a course letter, save the letter as a marker, and print a new <ul>
		if ($currentSection == "0" || $currentSection != $books['section']) {
			if (!$firstInSection) {
				echo "</ul>

";
				
				if (!isset($_GET['section'])) {
					echo "<a class=\"more\" href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $currentNumber . "&section=" . $currentSection . "\">See more <span class=\"arrow\" style=\"color: " . $category['color1'] . ";\">&raquo;</span></a>

";
				}
		
			//Display a section letter if the user is viewing the class numbers...
				if (isset($_GET['number'])) {
					echo "<h2><a href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $books['number'] . "&section=" . $books['section'] . "\" style=\"color: " . $category['color1'] .";\">" . $category['course'] . " " . $books['number'] . " " . $books['section'] . " &raquo;</a></h2>
";
				}

				echo "<ul>";
			
			//... otherwise include the section letter inline with the book titles
				if (!isset($_GET['number'])) {
					echo "
<li class=\"section\">" . $books['section'] . "</li>
";
				}
				
			//We are now in a new section, so reset the section counter
				$sectionCounter = 1;
			} else {
			//Display a section letter if the user is viewing the class numbers...
				if (isset($_GET['number']) && !isset($_GET['section'])) {
					echo "<h2><a href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $books['number'] . "&section=" . $books['section'] . "\" style=\"color: " . $category['color1'] .";\">" . $category['course'] . " " . $books['number'] . " " . $books['section'] . " &raquo;</a></h2>
";
				}
				
			//This unordered list will display if the user is viewing a section, which will require a special class
				if (isset($_GET['section'])) {
					echo "<ul class=\"viewAll\">";
				} else {
					echo "<ul>";
				}
		
			//... otherwise include the section letter inline with the book titles
				if (!isset($_GET['number'])) {
					echo "
<li class=\"section\">" . $books['section'] . "</li>
";
				}
			}
		}
		
	//Only display four books if this is the main page, but display up to 6 if we are looking within a class number
		if ((!isset($_GET['number']) && $sectionCounter <= 4) || (isset($_GET['number']) && !isset($_GET['section']) && $sectionCounter <= 7) || (isset($_GET['number']) && isset($_GET['section']))) {
			echo "
<li>
<a href=\"../book/?id=" . $books['id'] . "\"><img src=\"" . $books['imageURL'] . "\" /></a>
<a class=\"title\" href=\"../book/?id=" . $books['id'] . "\" title=\"" . htmlentities($books['title']) . "\">" . $books['title'] . "</a>
<span class=\"details\" title=\"Author: " . htmlentities($books['author']) . "\">Author: " . $books['author'] . "</span>
<span class=\"details\" title=\"Seller: " . $books['firstName'] . " " . $books['lastName'] . "\">Seller: " . $books['firstName'] . " " . $books['lastName'] . "</span>
<a href=\"javascript:;\" class=\"buttonLink buy\" data-fetch=\"" . $books['id'] . "\"><span>\$" . $books['price'] . "</span></a>
</li>
";
		}
		
		$currentSection = $books['section'];
		$firstInSection = false; //We've already gone at least once through section, so make sure the nested <ul> knows that!
		$sectionCounter ++;
		
	//Keep track of the iterations, if any were done at all
		$counter ++;
	}
	
//Print the closing tags, if any books were listed in this category
	if ($counter > 0) {
		echo "</li>
</ul>
";
		
	//Don't show the see more whenever the user has drilled down to a class section
		if (!isset($_GET['section'])) {
			echo "
<a class=\"more\" href=\"view-listing.php?id=" . $_GET['id'] . "&number=" . $currentNumber . "&section=" . $currentSection . "\">See more <span class=\"arrow\" style=\"color: " . $category['color1'] . ";\">&raquo;</span></a>
";
		}
 
		echo "</section>";
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