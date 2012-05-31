<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Sell Books", "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>
<script src=\"../system/javascripts/sell_wizard.js\"></script>
<script src=\"http://cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js\"></script>");
	echo "<section class=\"body\">
";

//Display the page header
	echo "<header class=\"styled sell\"><h1>Sell Your Books</h1></header>
	
<aside class=\"preview\">
";
	
//Include a book preview box
	echo "<section class=\"bookPreview\">
<div class=\"imageContainer\">
<p>Enter the book's ISBN and we'll show the book cover here</p>
</div>

<div class=\"imageBrowser hidden\">
<span class=\"back disabled\"></span>
<span class=\"forward\"></span>
</div>

<span class=\"titlePreview\">&lt;Book Title&gt;</span>
<span class=\"authorPreview details\">Author: &lt;Book Author&gt;</span>
<span class=\"details\">Seller: " . $userData['firstName'] . " " . $userData['lastName'] . "</span>
<br>
<span class=\"buttonLink\"><span>$0.00</span></span>
</section>";

	echo "
</aside>

<section class=\"sell\">
";

//Include directions on how to sell a book
	echo "<p>Enter the ISBN number of the book which you would like to sell. If a record of your book is already in our database, we will attempt automatically fill in the book cover, title, author, edition, and its associated courses.</p>
<p>If these fields don't automatically populate for you, then either this is a new book in our database or the ISBN was entered incorrectly.</p>

";

//Include the book's information section
	echo "<div class=\"bookInformationSection\">
<h2>Book Information</h2>
<table>
<tbody>
<tr>
<td>ISBN:</td>
<td><input class=\"ISBN\" name=\"ISBN\" type=\"text\" /></td>
</tr>

<tr>
<td>Title:</td>
<td><input class=\"titleInput\" name=\"title\" type=\"text\" /></td>
</tr>

<tr>
<td>Author:</td>
<td><input class=\"authorInput\" name=\"author\" type=\"text\" /></td>
</tr>

<tr>
<td>Edition:</td>
<td><input class=\"editionInput\"  name=\"edition\" type=\"text\" /></td>
</tr>
</tbody>
</table>
</div>

";

//Generate the course information section
	echo "<div class=\"courseInformationSection\">
<h2>Which classes did you use this book?</h2>";

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
	
	$courseFlyout = "<div class=\"menuWrapper\">
<ul class=\"categoryFly\">";

//Generate the category dropdown menu
	$counter = 1;

	foreach($categories as $category) {
	//Break up this "dropdown" list into columns every 10 items
		if ($counter % 10 == 1) {
		//Include an "all" menu item if this is the first item
			if ($counter == 1) {
				$courseFlyout .= "
<li>
<ul>
<li class=\"all selected\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('../system/images/icons/all.png');\">Select a Discipline</span></span></li>";

			//Since we inserted a "free" item, add one to the counter
				$counter++;
			} else {
				$courseFlyout .= "
<li>
<ul>";
			}
		}
		
		$courseFlyout .= "
<li><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";

		if ($counter % 10 == 0) {
			$courseFlyout .= "
</ul>
</li>
";
		}

		$counter++;
	}
	
	$courseFlyout .= "</ul>
</li>
</ul>
</div>";

//Finally display the rest of the portion of the class information step
	echo "<div>
" . $courseFlyout . "
<input name=\"classNum[]\" type=\"text\" />
<ul class=\"dropdown\" data-name=\"classSec[]\">
<li class=\"selected\">A</li>
<li>B</li>
<li>C</li>
<li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li><li>D is the last poor guy</li>
</ul>
</div>";

//Include the footer from the administration template
	echo "
</section>
</section>";

	footer("public");
?>