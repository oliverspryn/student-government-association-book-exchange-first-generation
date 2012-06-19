<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Grab the book's information
	if (isset($_GET['id'])) {
		$bookData = mysql_query("SELECT books.*, bookcategories.*, users.*, books.course AS courseID, GROUP_CONCAT(books.course) AS classIDs, GROUP_CONCAT(bookcategories.name) AS classes, GROUP_CONCAT(books.section) AS classSec, GROUP_CONCAT(books.number) AS classNum FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id RIGHT JOIN (users) ON books.userID = users.ID WHERE books.linkID = (SELECT linkID FROM books WHERE id = '{$_GET['id']}') GROUP BY books.linkID", $connDBA);
		
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

<meta property=\"og:title\" content=\"" . $book['title'] . "\" />
<meta property=\"og:description\" content=\"" . $book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!\" />
<meta property=\"og:image\" content=\"" . $book['imageURL'] . "\" />
<meta itemprop=\"name\" content=\"" . $book['title'] . "\">
<meta itemprop=\"description\" content=\"" . $book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!\">
<meta itemprop=\"image\" content=\"" . $book['imageURL'] . "\">
<script src=\"http://static.ak.fbcdn.net/connect.php/js/FB.Share\"></script>
<script src=\"https://apis.google.com/js/plusone.js\"></script>
<script src=\"https://platform.twitter.com/widgets.js\"></script>
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
<div class=\"pinContainer\"><a href=\"http://pinterest.com/pin/create/button/?url=" . urlencode("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . "&media=" . urlencode($book['imageURL']) . "&description=" . urlencode($book['firstName'] . " " . $book['lastName'] . " is selling &quot;" . $book['title'] . "&quot; on the Grove City College Student Government Association book exchange for only \$" . $book['price'] . "!") . "\" class=\"pin-it-button\" count-layout=\"horizontal\"><img src=\"https://assets.pinterest.com/images/PinExt.png\" title=\"Pin It\" /></a></div>
<a class=\"buttonLink buyDirect\" href=\"javascript:;\"><span>\$" . $book['price'] . " Buy</span></a>
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
<h2>User Comments</h2>
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
</section>";
	
//Include the footer from the public template
	echo "
</section>
</section>";

	footer("public");
?>