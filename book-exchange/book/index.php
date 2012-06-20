<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Grab the book's information
	if (isset($_GET['id'])) {
		$bookData = mysql_query("SELECT books.*, bookcategories.*, users.*, books.course AS courseID, GROUP_CONCAT(books.course) AS classIDs, GROUP_CONCAT(bookcategories.course) AS classShort, GROUP_CONCAT(bookcategories.name) AS classes, GROUP_CONCAT(books.section) AS classSec, GROUP_CONCAT(books.number) AS classNum FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id RIGHT JOIN (users) ON books.userID = users.ID WHERE books.linkID = (SELECT linkID FROM books WHERE id = '{$_GET['id']}') GROUP BY books.linkID", $connDBA);
		
		if ($bookData) {
			$book = mysql_fetch_array($bookData);
		}
	} else {
		redirect("../listings");
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . $title['title'] . "</a></li>
<li><a href=\"../\">Book Exchange</a></li>
<li><a href=\"../listings\">All Books Listings</a></li>
<li><a href=\"../listings/view-listing.php?id=" . $book['courseID'] . "\">" . $book['name'] . "</a></li>
<li>" . $book['title'] . "</li>\n";

//Include the top of the page from the administration template
	topPage("public", $book['title'], "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"../system/stylesheets/book.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>

<meta property=\"og:title\" content=\"" . $book['title'] . "\" />
<meta property=\"og:description\" content=\"" . $book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!\" />
<meta property=\"og:image\" content=\"" . $book['imageURL'] . "\" />
<meta itemprop=\"name\" content=\"" . $book['title'] . "\">
<meta itemprop=\"description\" content=\"" . $book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!\">
<meta itemprop=\"image\" content=\"" . $book['imageURL'] . "\">
<script src=\"http://static.ak.fbcdn.net/connect.php/js/FB.Share\"></script>
<script src=\"https://platform.twitter.com/widgets.js\"></script>
<script src=\"https://apis.google.com/js/plusone.js\"></script>
<script src=\"https://assets.pinterest.com/js/pinit.js\"></script>", $breadcrumb);
	echo "<section class=\"body\">
";
	
//Include the page header
	echo "<header class=\"styled\" style=\"border-top-color: " . $book['color1'] . "\">
<h1 style=\"background-color: " . $book['color3'] . "; border-color: " . $book['color2'] . ";\">" . $book['title'] . "</h1>
</header>

";
	
//Include the sidebar
	echo "<aside class=\"info\">
";
	
//Display the book cover, price, and social networking links
	echo "<section class=\"cover\">
<img src=\"" . $book['imageURL'] . "\" />
<div class=\"facebookContainer\"><a name=\"fb_share\" type=\"button\"></a></div>
<div class=\"twitterContainer\"><a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-related=\"sgaatgcc\" data-text=\"" . htmlentities($book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!") . "\">Tweet</a></div>
<div class=\"gplusContainer\"><div class=\"g-plusone\"></div></div>
<div class=\"pinContainer\"><a href=\"http://pinterest.com/pin/create/button/?url=" . urlencode("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . "&media=" . urlencode($book['imageURL']) . "&description=" . urlencode($book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!") . "\" class=\"pin-it-button\" count-layout=\"horizontal\" target=\"_blank\"><img src=\"https://assets.pinterest.com/images/PinExt.png\" title=\"Pin It\" /></a></div>
<a class=\"buttonLink buyDirect\" href=\"javascript:;\"><span>\$" . $book['price'] . " Buy</span></a>
</section>

";
	
	//Display a list of other categories that the user can browse
			$allCatGrabber = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);
			
			echo "<section class=\"categories\">
<h2 style=\"color:" . $book['color1'] . "\">More Book Listings</h2>
<ul class=\"moreListings\">";
			
			while ($allCat = mysql_fetch_array($allCatGrabber)) {
				echo "
<li><a href=\"../listings/view-listing.php?id=" . $allCat['id'] . "\">" . $allCat['name'] . " <span class=\"arrow\" style=\"color: " . $book['color1'] . "\">&raquo;</span></a></li>";
			}
			
			echo "
</ul>
</section>
</aside>

";
	
	echo "<section class=\"allInfo\">
";
	
//Display the book's general information
	echo "<section class=\"general\">
<h2>General Information</h2>
<span class=\"details\"><strong>Author:</strong> " . $book['author'] . "</span>
";
	
	if ($book['edition'] != "") {
		echo "<span class=\"details\"><strong>Edition:</strong> " . $book['edition'] . "</span>
";
	}

	echo "<span class=\"details\"><strong>ISBN:</strong> " . $book['ISBN'] . "</span>

";
	
	//Conditionally format the condition of the book
		switch($book['condition']) {
			case "Excellent" : 
				echo "<span class=\"excellent\">Excellent Condition</span>
";
				break;
				
			case "Very Good" : 
				echo "<span class=\"veryGood\">Very Good Condition</span>
";
				break;
				
			case "Good" : 
				echo "<span class=\"good\">Good Condition</span>
";
				break;
				
			case "Fair" : 
				echo "<span class=\"fair\">Fair Condition</span>
";
				break;
				
			case "Poor" : 
				echo "<span class=\"poor\">Poor Condition</span>
";
				break;
		}
	
	//Conditionally format whether or not the book has been written in
		if ($book['written'] == "Yes") {
			echo "<span class=\"marks\">Has Writing or Markings</span>
";
		} else {
			echo "<span class=\"noMarks\">No Writing or Markings</span>
";
		}
	
	echo "
</section>

";
	
//Display any comments associated with this book
	if ($book['comments'] != "") {
		echo "<section class=\"comments\">
<h2>Seller Comments</h2>
" . $book['comments'] . "
</section>

";
	}
	
//Display a list of classes that used this book
	echo "<section class=\"classes\">
<h2>Classes That Use This Book</h2>
<ul>";
	
	$classIDs = explode(",", $book['classIDs']);
	$classes = explode(",", $book['classes']);
	$classNum = explode(",", $book['classNum']);
	$classSec = explode(",", $book['classSec']);
	
	for ($i = 0; $i <= sizeof($classIDs) - 1; $i ++) {
		echo "
<li>
<img src=\"../../data/book-exchange/icons/" . $classIDs[$i] . "/icon_128.png\" title=\"" . $classes[$i] . "\" />
<span class=\"classDetails\">" . $classNum[$i] . " " . $classSec[$i] . "</span>
</li>";
	}
	
	echo "
</ul>
</section>

";
	
//Display the seller's profile
	if ($book['emailAddress2'] != "" || $book['emailAddress3'] != "") {
		$class = " class=\"extended\"";
	} else {
		$class = "";
	}
	
	echo "<section class=\"seller\">
<h2>Seller Information</h2>
<span class=\"details\"><strong" . $class . ">Name:</strong> " . $book['firstName'] . " " . $book['lastName'] . "</span>
<span class=\"details\"><strong" . $class . ">Email:</strong> <a href=\"mailto:" . $book['emailAddress1'] . "\">" . $book['emailAddress1'] . "</a></span>
";
	
	if ($book['emailAddress2'] != "") {
		echo "<span class=\"details\"><strong class=\"extended\">Alternate email:</strong> <a href=\"mailto:" . $book['emailAddress2'] . "\">" . $book['emailAddress2'] . "</a></span>
";
	}
	
	if ($book['emailAddress3'] != "") {
		echo "<span class=\"details\"><strong class=\"extended\">Alternate email:</strong> <a href=\"mailto:" . $book['emailAddress3'] . "\">" . $book['emailAddress3'] . "</a></span>
";
	}

	echo "</section>

";
	
//Include other books by this seller
	$sellerOtherGrabber = mysql_query("SELECT books.*, bookcategories.*, users.*, books.id AS bookID, books.course AS courseID FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id RIGHT JOIN (users) ON books.userID = users.ID WHERE books.userID = (SELECT userID FROM books WHERE id = '{$_GET['id']}') AND books.id != '{$_GET['id']}' GROUP BY books.linkID ORDER BY RAND() LIMIT 4", $connDBA);
	
	if (mysql_num_rows($sellerOtherGrabber)) {
		echo "<section class=\"more\">
<h2 style=\"color: " . $book['color1'] . ";\">Other Books for Sale by " . $book['firstName'] . "</h2>
<ul>";
		
		while($sellerOther = mysql_fetch_array($sellerOtherGrabber)) {
			echo "
<li>
<a class=\"title\" href=\"../book/?id=" . $sellerOther['bookID'] . "\"><img src=\"" . $sellerOther['imageURL'] . "\"></a>
<a class=\"title\" href=\"../book/?id=" . $sellerOther['bookID'] . "\" title=\"" . $sellerOther['title'] . "\">" . $sellerOther['title'] . "</a>
<span class=\"details\" title=\"Author: " . $sellerOther['author'] . "\">Author: " . $sellerOther['author'] . "</span>
<a class=\"buttonLink buy\" href=\"javascript:;\" data-fetch=\"" . $sellerOther['bookID'] . "\"><span>\$" . $sellerOther['price'] . "</span></a>
</li>
";
		}
		
		echo "</ul>
	
<a class=\"more\" href=\"../search/?search=" . $book['firstName'] . " " . $book['lastName'] . "&searchBy=seller&category=0&options=false\">See More <span class=\"arrow\" style=\"color: " . $book['color1'] . ";\">&raquo;</span></a>
</section>

";
	}
	
//Include other books for sale within the sections that this book is listed
	$SQL = "";
	$title = "";
	$seeMore = "";
	$classIDs = explode(",", $book['classIDs']);
	$classNames = explode(",", $book['classShort']);
	$classNum = explode(",", $book['classNum']);
	$classSec = explode(",", $book['classSec']);
	
//If there only one section that this class is listed in, then we only need a "See More" link, otherwise
//generate a "See More" link for each specific class
	if (sizeof($classIDs) == 1) {
		$seeMore = "<a class=\"more\" href=\"../search/?search=" . $classNum['0'] . " " . $classSec['0'] . "&category=" . $classIDs['0'] . "&searchBy=course\">See More <span class=\"arrow\" style=\"color: " . $book['color1'] . ";\">&raquo;</span></a>
";
	}
	
//Generate a dynamic SQL query, title for the "Other Book" section, and listing of "See More" links for
//each class section
	for ($i = 0; $i <= sizeof($classIDs) - 1; $i ++) {
	//Generate the SQL
		$SQL .= " OR (books.course = '" . $classIDs[$i] . "' AND books.number = '" . $classNum[$i] . "' AND books.section = '" . $classSec[$i] . "')";
		
	//Generate the title
	//Add an "and" before the last class in the list, only if the list has more than 1 value
		if ($i == sizeof($classIDs) - 1 && $title != "") {
		//The list will need to be comma seperated if there are more than 2 items
			if (sizeof($classIDs) > 2) {
				$title .= ", and " . $classNames[$i] . " " . $classNum[$i] . " " . $classSec[$i];
			} else {
				$title .= " and " . $classNames[$i] . " " . $classNum[$i] . " " . $classSec[$i];
			}
		} else {
		//The list will need to be comma seperated if there are more than 2 items
			if (sizeof($classIDs) > 2) {
				$title .= ", " . $classNames[$i] . " " . $classNum[$i] . " " . $classSec[$i];
			} else {
				$title .= " " . $classNames[$i] . " " . $classNum[$i] . " " . $classSec[$i];
			}
		}
		
	//Generate the "See More" links
		if (sizeof($classIDs) > 1) {
			$seeMore .= "<a class=\"more\" href=\"../search/?search=" . $classNum[$i] . " " . $classSec[$i] . "&category=" . $classIDs[$i] . "&searchBy=course\">See More in " . $classNames[$i] . " " . $classNum[$i] . " " . $classSec[$i] . " <span class=\"arrow\" style=\"color: " . $book['color1'] . ";\">&raquo;</span></a>
";
		}
	}
	
	$SQL = ltrim($SQL, " OR ");
	$title = ltrim($title, ", ");
	$catOtherGrabber = mysql_query("SELECT books.*, bookcategories.*, users.*, books.id AS bookID, books.course AS courseID FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id RIGHT JOIN (users) ON books.userID = users.ID WHERE {$SQL} GROUP BY books.linkID ORDER BY RAND() LIMIT 4", $connDBA);
	
	if (mysql_num_rows($catOtherGrabber)) {
		echo "<section class=\"other\">
<h2 style=\"color: " . $book['color1'] . ";\">Other Books For Sale in " . $title . "</h2>
<ul>";
		
		while($catOther = mysql_fetch_array($catOtherGrabber)) {
			echo "
<li>
<a class=\"title\" href=\"../book/?id=" . $catOther['bookID'] . "\"><img src=\"" . $catOther['imageURL'] . "\"></a>
<a class=\"title\" href=\"../book/?id=" . $catOther['bookID'] . "\" title=\"" . $catOther['title'] . "\">" . $catOther['title'] . "</a>
<span class=\"details\" title=\"Author: " . $catOther['author'] . "\">Author: " . $catOther['author'] . "</span>
<a class=\"buttonLink buy\" href=\"javascript:;\" data-fetch=\"" . $catOther['bookID'] . "\"><span>\$" . $catOther['price'] . "</span></a>
</li>
";
		}
		
		echo "</ul>
		
" . $seeMore . "</section>";
	}
	
//Include the footer from the public template
	echo "
</section>
</section>";

	footer("public");
?>