<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	require_once("../system/server/Validate.php");
	
//Perform a search operation on the database
	if (isset($_GET['search']) && $_GET['search'] != "") {
		$query = mysql_real_escape_string($_GET['search']);
		$category = mysql_real_escape_string(Validate::numeric($_GET['category']));
		$searchBy = mysql_real_escape_string(Validate::required($_GET['searchBy'], array("title", "author", "ISBN", "course")));
		
	//Search by a specific category
		if ($category != 0) {
			$category = " AND books.course = '" . $category . "'";
		} else {
			$category = "";
		}
		
	//Is there a sort criteria?
		if (isset($_GET['sortBy'])) {
			$sortBy = Validate::required($_GET['sortBy'], array("titleASC", "titleDESC", "priceASC", "priceDESC", "authorASC", "authorDESC"));
			
			switch($sortBy) {
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
		
	//Only display a given number of queries		
		if (isset($_GET['display'])) {
			$limit = Validate::numeric($_GET['display'], 1);
		} else {
			$limit = 25;
		}
		
		if (isset($_GET['page'])) {
			$start = $limit * (Validate::numeric($_GET['page'], 1) - 1);
		} else {
			$start = 0;
		}
		
	//Different search methods will vary the query that is executed on the database
		switch($searchBy) {
			case "title" : 
				$searchGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE) AS score, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE){$category} GROUP BY linkID ORDER BY score DESC, " . $sort . " LIMIT " . $start . ", " . $limit, $connDBA);
				$lengthGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE) AS score, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE MATCH(title) AGAINST('{$query}' IN BOOLEAN MODE){$category} GROUP BY linkID ORDER BY score DESC, " . $sort, $connDBA);
				break;
				
			case "author" : 
				$searchGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, MATCH(author) AGAINST('{$query}' IN BOOLEAN MODE) AS score, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE MATCH(author) AGAINST('{$query}' IN BOOLEAN MODE){$category} GROUP BY linkID ORDER BY score DESC, " . $sort . " LIMIT " . $start . ", " . $limit, $connDBA);
				$lengthGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, MATCH(author) AGAINST('{$query}' IN BOOLEAN MODE) AS score, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE MATCH(author) AGAINST('{$query}' IN BOOLEAN MODE){$category} GROUP BY linkID ORDER BY score DESC, " . $sort, $connDBA);
				break;
				
			case "ISBN" : 
				$searchGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE ISBN = '{$query}'{$category} GROUP BY linkID ORDER BY ISBN ASC, " . $sort . " LIMIT " . $start . ", " . $limit, $connDBA);
				$lengthGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE ISBN = '{$query}'{$category} GROUP BY linkID ORDER BY ISBN ASC, " . $sort, $connDBA);
				break;
				
			case "course" : 
				$number = substr($query, strlen($query) - 5, strlen($query) - 2);
				$section = substr($query, strlen($query) - 1, strlen($query));
				
				$searchGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE number = '{$number}' AND section = '{$section}'{$category} GROUP BY linkID ORDER BY ISBN ASC, " . $sort . " LIMIT " . $start . ", " . $limit, $connDBA);
				$lengthGrabber = mysql_query("SELECT books.*, users.firstName, users.lastName, GROUP_CONCAT(books.course) AS listedInID, GROUP_CONCAT(bookcategories.name) AS listedIn, GROUP_CONCAT(books.number) AS listedInNumber, GROUP_CONCAT(books.section) AS listedInSection FROM books RIGHT JOIN (users) ON books.userID = users.id RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE number = '{$number}' AND section = '{$section}'{$category} GROUP BY linkID ORDER BY ISBN ASC, " . $sort, $connDBA);
				break;
				
			default : 
				redirect("../search/");
				break;
		}
			
	//Is a paginator necessary?
		if ($lengthGrabber) {
			$length = mysql_num_rows($lengthGrabber);
			
			if ($length == 0) {
				redirect("../search/?message=none");
			}
	//Or did the query fail altogether?
		} else {
			redirect("../search/?message=none");
		}
	} else if (isset($_GET['search']) && $_GET['search'] == "") {
		redirect("../search/");
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . $title['title'] . "</a></li>
<li><a href=\"../\">Book Exchange</a></li>
";
	
//The breadcrumb and title will requrie some specialization depending if a search query is entered
	if (isset($_GET['search'])) {
		$breadcrumb .= "<li><a href=\"../search\">Search</a></li>
<li>" . $_GET['search'] . "</li>\n";
		
		if ($_GET['searchBy'] == "ISBN") {
			$title = "ISBN: " . $_GET['search'];
		} else {
			$title = $_GET['search'];
		}
	} else {
		$breadcrumb .= "<li>Search</li>\n";
		$title = "Search";
	}

//Include the top of the page from the administration template
	topPage("public", $title, "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"../system/stylesheets/search.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>", $breadcrumb);
	echo "<section class=\"body\">
";
	
//Display a page header
	if (isset($_GET['search'])) {
	//Is the sidebar present?
		if (!isset($_GET['options']) || (!isset($_GET['options']) && $_GET['options'] != "false")) {
			$class = "";
		} else {
			$class = " noSide";
		}
		
	//Properly format the results string
		if ($length == 1) {
			$total = "1 Result";
		} else {
			$total = $length . " Results";
		}
		
		echo "<header class=\"styled search" . $class . "\">
<h1>" . $title . "</h1>
<h2>" . $total . "</h2>
</header>

";
	}

//Display the results of the search...
	if (isset($_GET['search'])) {
	//Display the tools sidebar, if the options are turn on
		if (!isset($_GET['options']) || (!isset($_GET['options']) && $_GET['options'] != "false")) {
			echo "<aside class=\"tools\">
<section class=\"options\">
<form action=\".\" method=\"get\">
<h2>Search for Books:</h2>
<input autocomplete=\"off\" class=\"search full\" name=\"search\" type=\"text\" value=\"" . htmlentities($_GET['search']) . "\" />

<div class=\"controls\">
<span class=\"step\">Search by:</span>
<ul class=\"dropdown\" data-name=\"searchBy\">
<li" . ($_GET['searchBy'] == "title" ? " class=\"selected\"" : "") . " data-value=\"title\">Title</li>
<li" . ($_GET['searchBy'] == "author" ? " class=\"selected\"" : "") . " data-value=\"author\">Author</li>
<li" . ($_GET['searchBy'] == "ISBN" ? " class=\"selected\"" : "") . ">ISBN</li>
<li" . ($_GET['searchBy'] == "course" ? " class=\"selected\"" : "") . " data-value=\"course\">Course</li>
</ul>

<br>

<span class=\"step\">Sort by:</span>
<ul class=\"dropdown\" data-name=\"sortBy\">
<li" . ((isset($_GET['sortBy']) && $_GET['sortBy'] == "titleASC") || !isset($_GET['sortBy']) ? " class=\"selected\"" : "") . " data-value=\"titleASC\">Title A-Z</li>
<li" . (isset($_GET['sortBy']) && $_GET['sortBy'] == "titleDESC" ? " class=\"selected\"" : "") . " data-value=\"titleDESC\">Title Z-A</li>
<li" . (isset($_GET['sortBy']) && $_GET['sortBy'] == "priceASC" ? " class=\"selected\"" : "") . " data-value=\"priceASC\">Price Low to High</li>
<li" . (isset($_GET['sortBy']) && $_GET['sortBy'] == "priceDESC" ? " class=\"selected\"" : "") . " data-value=\"priceDESC\">Price High to Low</li>
<li" . (isset($_GET['sortBy']) && $_GET['sortBy'] == "authorASC" ? " class=\"selected\"" : "") . " data-value=\"authorASC\">Author A-Z</li>
<li" . (isset($_GET['sortBy']) && $_GET['sortBy'] == "authorDESC" ? " class=\"selected\"" : "") . " data-value=\"authorDESC\">Author Z-A</li>
</ul>

<br>

<span class=\"step\">Display:</span>
<ul class=\"dropdown\" data-name=\"display\">
<li" . (isset($_GET['display']) && $_GET['display'] == "10" || (isset($_GET['display']) && $_GET['display'] != "10" && $_GET['display'] != "25" && $_GET['display'] != "50" && $_GET['display'] != "75" && $_GET['display'] != "100") ? " class=\"selected\"" : "") . " data-value=\"10\">10 Results</li>
<li" . ((isset($_GET['display']) && $_GET['display'] == "25") || !isset($_GET['display']) ? " class=\"selected\"" : "") . " data-value=\"25\">25 Results</li>
<li" . (isset($_GET['display']) && $_GET['display'] == "50" ? " class=\"selected\"" : "") . " data-value=\"50\">50 Results</li>
<li" . (isset($_GET['display']) && $_GET['display'] == "75" ? " class=\"selected\"" : "") . " data-value=\"75\">75 Results</li>
<li" . (isset($_GET['display']) && $_GET['display'] == "100" ? " class=\"selected\"" : "") . " data-value=\"100\">100 Results</li>
</ul>

<br>

<span class=\"step category\">Search in:</span>
<div class=\"menuWrapper\">
<input name=\"category\" type=\"hidden\" value=\"" . $_GET['category'] . "\" />

<ul class=\"categoryFly\">";
	
	//Generate the category dropdown menu
		$categoryGrabber = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);
		$counter = 1;
	
		while($category = mysql_fetch_array($categoryGrabber)) {
		//Break up this "dropdown" list into columns every 10 items
			if ($counter % 10 == 1) {
			//Include an "all" menu item if this is the first item
				if ($counter == 1) {
					echo "
<li>
<ul>
";
					
				//Should the "All Categories" be selected?
					if (!isset($_GET['category']) || (isset($_GET['category']) && $_GET['category'] == '0')) {
						echo "<li class=\"all selected\" data-value=\"0\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('../system/images/icons/all.png');\">All Disciplines</span></span></li>";
					} else {
						echo "<li class=\"all\" data-value=\"0\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('../system/images/icons/all.png');\">All Disciplines</span></span></li>";
					}
	
				//Since we inserted a "free" item, add one to the counter
					$counter++;
				} else {
					echo "
<li>
<ul>";
				}
			}
			
		//Should this category be selected?
			if (isset($_GET['category']) && $_GET['category'] == $category['id']) {
				echo "
<li class=\"selected\" data-value=\"" . $category['id'] . "\"><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";
			} else {
				echo "
<li data-value=\"" . $category['id'] . "\"><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";
			}
	
			if ($counter % 10 == 0) {
				echo "
</ul>
</li>
";
			}
	
			$counter++;
		}
		
		echo "</ul>
</div>
</div>

<input class=\"blue submit\" type=\"submit\" value=\"Search\" />
</form>
</section>

";
	
	//Display a list of other categories that the user can browse
			$allCatGrabber = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);
			
			echo "<h2 style=\"color:" . $category['color1'] . "\">More Book Listings</h2>
<ul class=\"moreListings\">";
			
			while ($allCat = mysql_fetch_array($allCatGrabber)) {
				echo "
<li><a href=\"../listings/view-listing.php?id=" . $allCat['id'] . "\">" . $allCat['name'] . " <span class=\"arrow\">&raquo;</span></a></li>";
			}
			
			echo "
</ul>
</aside>

";
		}
		
	//Is the sidebar present?
		if (!isset($_GET['options']) || (!isset($_GET['options']) && $_GET['options'] != "false")) {
			$class = "";
		} else {
			$class = " noSide";
		}
		
	//Display the search results
		echo "<section class=\"results" . $class . "\">
<ul>";
		
		while ($search = mysql_fetch_array($searchGrabber)) {
			echo "
<li class=\"result\">
<a href=\"../book/?id=" . $search['id'] . "\"><img src=\"" . $search['imageURL'] . "\" /></a>
<a class=\"title\" href=\"../book/?id=" . $search['id'] . "\" title=\"" . htmlentities($search['title']) . "\">" . $search['title'] . "</a>
<span class=\"details\"><strong>Author:</strong> <a href=\"../search/?search=" . urlencode($search['author']) . "&searchBy=author&category=0\">" . $search['author'] . "</a></span>
<span class=\"details\"><strong>Seller:</strong> " . $search['firstName'] . " " . $search['lastName'] . "</span>
<span class=\"details\"><strong>ISBN:</strong> " . $search['ISBN'] . "</span>
";
			
		//Conditionally format the condition of the book
			switch($search['condition']) {
				case "Excellent" : 
					echo "<span class=\"excellent\">Excellent Condition</span>";
					break;
					
				case "Very Good" : 
					echo "<span class=\"veryGood\">Very Good Condition</span>";
					break;
					
				case "Good" : 
					echo "<span class=\"good\">Good Condition</span>";
					break;
					
				case "Fair" : 
					echo "<span class=\"fair\">Fair Condition</span>";
					break;
					
				case "Poor" : 
					echo "<span class=\"poor\">Poor Condition</span>";
					break;
			}
			
		//Generate the list of classes that are listed for this book
			$classIDs = explode(",", $search['listedInID']);
			$classes = explode(",", $search['listedIn']);
			$classNums = explode(",", $search['listedInNumber']);
			$classSections = explode(",", $search['listedInSection']);
			
			echo "

<ul class=\"classes\">
<li><span class=\"directions\">Classes used:</span></li>";
			
			for ($i = 0; $i <= sizeof($classIDs) - 1; $i++) {
				echo "
<li>
<img src=\"../../data/book-exchange/icons/" . $classIDs[$i] . "/icon_032.png\" title=\"" . $classes[$i] . "\" />
<span class=\"courseDetails\">" . $classNums[$i] . " " . $classSections[$i] . "</span>
</li>
";
			}
			
			echo "</ul>
			
<a class=\"buttonLink buy\" data-fetch=\"" . $search['id'] . "\" href=\"javascript:;\"><span>\$" . $search['price'] . "</span></a>
</li>
";
		}
		
		echo "</ul>
";
		
	//Display a paginator, if needed
		if ($limit <= $length) {
		//The maxmium number of pages to list in the paginator at once, only works with odd numbers
			$paginatorMax = 9;
			
		//Calculate the number of needed pages
			$pagesNeeded = ceil($length / $limit);
			
		//The current page information will need validated
			if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] <= $pagesNeeded) {
				$currentPage = $_GET['page'];
			} else if (isset($_GET['page']) && (!is_numeric($_GET['page']) && $_GET['page'] > $pagesNeeded)) {
				$currentPage = 1;
			} else {
				$currentPage = 1;
			}
			
		//Generate the base URL for each of the pagination links
			$baseURL = "../search/";
			$baseURL .= "?search=" . $_GET['search'];
			$baseURL .= "&searchBy=" . $_GET['searchBy'];
			$baseURL .= "&category=" . $_GET['category'];
			
			if (isset($_GET['display'])) {
				$baseURL .= "&display=" . $_GET['display'];
			}
			
			if (isset($_GET['sortBy'])) {
				$baseURL .= "&sortBy=" . $_GET['sortBy'];
			}
			
			if (isset($_GET['options'])) {
				$baseURL .= "&options=" . $_GET['options'];
			}
			
			echo "
<ul class=\"pagination\">";
			
		//Can a back button be displayed?
			if ($currentPage != 1) {
				echo "
<li class=\"back\"><a href=\"" . $baseURL . "&page=" . ($currentPage - 1) . "\"></a></li>";
			}
				
		/**
		 * Calculuate the lower bound
		 * 
		 * This will visually balance the number of pages around the current page
		 * as the user goes higher and higher in the list. For example, if we are
		 * displaying 11 pages at a time, the user will see (26 is selected):
		 * 
		 *  1 ... 21 22 23 24 25 *26* 27 28 29 30 31 ... 100
		 *        |____________|      |____________|
		 *              |                   |
		 *           5 items + 1 item +  5 items = 11 items
		*/
			if ($paginatorMax % 2 == 1) { //Is the number odd?
				$originalPaginator = $paginatorMax; // Just make a copy, if we need it
				$paginatorMax --; //This is needed so we can calculate
			} else {
				$originalPaginator = $paginatorMax;
			}
			
			$centerBalance = $paginatorMax / 2;
			$minOutput = $currentPage - $centerBalance;
			
			if ($minOutput < 1) {
				$minOutput = 1;
			}
			
		//Calculate the upper bound
			$maxOutput = $currentPage + $centerBalance;
			
			if ($maxOutput > $pagesNeeded) {
				$maxOutput = $pagesNeeded;
			}
		/**
		 * Now for some last minute checks
		 * 
		 * Are we actually displaying all of the pages that $paginatorMax told us
		 * to display? Or is there a problem like this near the beginning and end:
		 * 
		 *   $paginatorMax = 9
		 *   
		 *   1 2 3 4 *5* ... 20 >
		 *   < 1 ... 16 17 18 19 *20*
		 *   
		 * Do some last minute calculations to adjust this problem.
		 */
			
			if ($maxOutput - $minOutput < $paginatorMax) {
			//Should more be added to the beginning?
				if ($maxOutput + ($maxOutput - $minOutput) >= $paginatorMax) {
					$minOutput -= $minOutput - ($maxOutput - $paginatorMax);
					
				//This must be greater than 0
					if ($minOutput < 1) {
						$minOutput = 1;
					}
				}
				
			//Should more be added to the end?
				if ($minOutput + ($maxOutput - $minOutput) <= $paginatorMax) {
					$maxOutput += $originalPaginator - $maxOutput;
					
				//This must be greater than $pagesNeeded
					if ($maxOutput > $pagesNeeded) {
						$maxOutput = $pagesNeeded;
					}
				}
			}
			
		//Were there beginnning pages that the paginator didn't print out to conserve space? Print the first page, if so.
			if ($minOutput != $pagesNeeded && $minOutput != 1) {
			//Don't display something like 1 ... 2
				if ($minOutput - 1 == 1) {
					echo "
<li class=\"noDot\"><a href=\"" . $baseURL . "&page=1\">1</a></li>";
			//Don't display something like 1 ... 3, just print 1 2 3
				} else if ($minOutput - 2 == 1) {
					echo "
<li class=\"noDot\"><a href=\"" . $baseURL . "&page=1\">1</a></li>
<li><a href=\"" . $baseURL . "&page=2\">2</a></li>";
				} else {
					echo "
<li class=\"noDot\"><a href=\"" . $baseURL . "&page=1\">1</a></li>
<li class=\"noDot more\">&hellip;</li>";
				}
			}
			
		//Print out the pagination list
			for ($i = $minOutput; $i <= $maxOutput; $i++) {
				$class = "";
				
			//Highlight the current page
				if ($i == $currentPage) {
					$class = " class=\"current\"";
				}
				
			/**
			 * Some page links won't need a seperator, such as the first one...
			 * 
			 * The last two conditions offset the logic for the codeblock above this 
			 * loop. Search for:
			 * 
			 *   //Don't display something like 1 ... 2
			 *   //Don't display something like 1 ... 3, just print 1 2 3
			 *  
			 * to see where these initial conditons are created.
			 */
				if ($i == $minOutput && $i - 1 != 1 && $i - 2 != 1) {
					$class = " class=\"noDot\"";
				}
				
				if ($i == $minOutput && $i == $currentPage) {
					$class = " class=\"current noDot\"";
				}
			
				
			//Display the list item
				echo "
<li" . $class . "><a href=\"" . $baseURL . "&page=" . $i . "\">" . $i . "</a></li>";
			}
			
		//Were there extra pages that the paginator didn't print out to conserve space? Print the last page, if so.
			if ($maxOutput < $pagesNeeded) {
			//Don't display something like 19 ... 20
				if ($maxOutput + 1 == $pagesNeeded) {
					echo "
<li><a href=\"" . $baseURL . "&page=" . $pagesNeeded . "\">" . $pagesNeeded . "</a></li>";
			//Don't display something like 18 ... 20, just print 18 19 20
				} else if ($maxOutput + 2 == $pagesNeeded) {
					echo "
<li><a href=\"" . $baseURL . "&page=" . ($pagesNeeded - 1) . "\">" . ($pagesNeeded - 1) . "</a></li>
<li><a href=\"" . $baseURL . "&page=" . $pagesNeeded . "\">" . $pagesNeeded . "</a></li>";
				} else {
					echo "
<li class=\"noDot more\">&hellip;</li>
<li class=\"noDot\"><a href=\"" . $baseURL . "&page=" . $pagesNeeded . "\">" . $pagesNeeded . "</a></li>";
				}
			}
			
		//Can a forward button be displayed?
			if ($currentPage + 1 <= $pagesNeeded) {
				echo "
<li class=\"forward\"><a href=\"" . $baseURL . "&page=" . ($currentPage + 1) . "\"></a></li>";
			}
			
			echo "
</ul>
";
		}	
		
		echo "</section>";
//... or show a search form
	} else {
	//Was the user redirected back here because of an error?
		if (isset($_GET['message']) && $_GET['message'] == "none") {
			echo "<div class=\"center\"><div class=\"error\">Sorry we couldn't results for your search. Did you enter it correctly?</div></div>
			
	";
		}
		
		echo "<section class=\"searchForm\">
<div class=\"mask\">
<form action=\".\" method=\"get\">
<h2 class=\"search\">Search for Books:</h2>
<input autocomplete=\"off\" class=\"search full\" name=\"search\" type=\"text\" />
<span class=\"expand\">Advanced Search Options</span>

<div class=\"controls hidden\">
<span class=\"searchStep\">Search by:</span>
<ul class=\"dropdown\" data-name=\"searchBy\">
<li class=\"selected\" data-value=\"title\">Title</li>
<li data-value=\"author\">Author</li>
<li>ISBN</li>
<li data-value=\"course\">Course</li>
</ul>

<br>

<div class=\"menuWrapper\">
<input name=\"category\" type=\"hidden\" value=\"0\" />

<ul class=\"categoryFly\">";

//Generate the category dropdown menu
	$categoryGrabber = mysql_query("SELECT * FROM `bookcategories` ORDER BY name ASC", $connDBA);
	$counter = 1;

	while($category = mysql_fetch_array($categoryGrabber)) {
	//Break up this "dropdown" list into columns every 10 items
		if ($counter % 10 == 1) {
		//Include an "all" menu item if this is the first item
			if ($counter == 1) {
				echo "
<li>
<ul>
<li class=\"all selected\" data-value=\"0\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('../system/images/icons/all.png');\">All Disciplines</span></span></li>";

			//Since we inserted a "free" item, add one to the counter
				$counter++;
			} else {
				echo "
<li>
<ul>";
			}
		}
		
		echo "
<li data-value=\"" . $category['id'] . "\"><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";

		if ($counter % 10 == 0) {
			echo "
</ul>
</li>
";
		}

		$counter++;
	}
	
	echo "</ul>
</div>
</div>

<input class=\"blue submit\" type=\"submit\" value=\"Search\" />
</form>
</div>

<img class=\"animatedSearch\" src=\"../system/images/icons/search.png\" />
</section>

<img class=\"shadow\" src=\"../system/images/welcome/paper_shadow.png\" />

";
	}
	
//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>