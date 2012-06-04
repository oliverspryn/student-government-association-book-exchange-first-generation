<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	require_once("../system/server/Validate.php");
	
/**
 * Process the form
 *
 * This information will likely need to be processed several times,
 * in order to allow a given book to be searchable for each class
 * that it belongs.
 *
 * There is a set of information which will remain constant for
 * each of the processes (represented by the book image and steps
 * one and three in the form) and there is a set which will change 
 * for each process (represented by step two in the form).
 *
 * The data which will be processed several times will contain 
 * information which will need to be discarded. The first piece of
 * data from the class name and section is unneeded, as they only
 * served as they were only templates of dynmaic datafor jQuery to 
 * copy whenever a new row was added to the class table. They were
 * never filled out by the user, and only served technical purposes.
 *
 * The first values for className and classSec will be discarded.
*/
	if (isset($_POST) && !empty($_POST) && is_array($_POST) && isset($_POST['ISBN'])) {
	//Generate the server-side data needed to store a book
		$userID = $userData['id'];
		$upload = strtotime("now");
		$linkID = md5($upload + "_" + $userID);
		
	//Validate the constant data provided by the user
		$imageURL = mysql_real_escape_string(Validate::required($_POST['imageURL']));
		$ISBN = preg_replace('/[^0-9]/', '', $_POST['ISBN']);
		
		if (strlen($ISBN) == 10 || strlen($ISBN) == 13) {
			//Do nothing
		} else {
			redirect("index.php");
		}
		
		$ISBN = mysql_real_escape_string($ISBN);
		$title = mysql_real_escape_string(Validate::required($_POST['title']));
		$author = mysql_real_escape_string(Validate::required($_POST['author']));
		$edition = mysql_real_escape_string($_POST['edition']);
		$price = mysql_real_escape_string(Validate::numeric($_POST['price'], 0, 999.99));
		$condition = mysql_real_escape_string(Validate::required($_POST['condition'], array("Excellent", "Very Good", "Good", "Fair", "Poor")));
		$written = mysql_real_escape_string(Validate::required($_POST['written'], array("Yes", "No")));
		$comments = mysql_real_escape_string($_POST['comments']);
		
	//Process this data multiple times, see above description for more details
		for ($i = 0; $i <= sizeof($_POST['classNum']) - 1; $i++) {
		//Validate the dynamic data provided by the user
			$className = mysql_real_escape_string(Validate::required($_POST['className'][$i + 1]));
			$classNum = mysql_real_escape_string(Validate::numeric($_POST['classNum'][$i], 101, 499));
			$classSec = mysql_real_escape_string(Validate::required($_POST['classSec'][$i + 1], false, false, false, 1));
			
		//Execute the data on the database
			mysql_query("INSERT INTO books (
					`id`, `userID`, `upload`, `linkID`, `ISBN`, `title`, `author`, `edition`, `course`, `number`, `section`, `price`, `condition`, `written`, `comments`, `imageURL`
				 ) VALUES (
					NULL, '{$userID}', '{$upload}', '{$linkID}', '{$ISBN}', '{$title}', '{$author}', '{$edition}', '{$className}', '{$classNum}', '{$classSec}', '{$price}', '{$condition}', '{$written}', '{$comments}', '{$imageURL}'
				 )", $connDBA);
		}
		
	//Determine where to redirect the user
		if ($_POST['redirect'] == "1") {
			redirect("index.php?message=added");
		} else {
			redirect("../account");
		}
	}

//Include the top of the page from the administration template
	topPage("public", "Sell Books", "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"../../styles/jQuery/validationEngine.jquery.min.css\" rel=\"stylesheet\" />
<script src=\"../system/javascripts/interface.js\"></script>
<script src=\"../system/javascripts/sell_wizard.min.js\"></script>
<script src=\"http://cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js\"></script>
<script src=\"../../tiny_mce/tiny_mce.js\"></script>
<script src=\"../../tiny_mce/jquery.tinymce.js\"></script>
<script src=\"../../javascripts/common/tiny_mce_simple.php\"></script>
<script src=\"../../javascripts/jQuery/jquery.validationEngine.min.js\"></script>");
	echo "<section class=\"body\">
";

//Display any needed success messages
	if (isset($_GET['message']) && $_GET['message'] == "added") {
		echo "<div class=\"center\"><div class=\"success\">Your book is now up for sale</div></div>
		
";
	}

//Display the page header
	echo "<form action=\"index.php\" method=\"post\">
<header class=\"styled sell\"><h1>Sell Your Books</h1></header>

<aside class=\"preview\">
";
	
//Include a book preview box, the double <div> around the text input is a lazy fix for a positioning bug in the jQuery validator
	echo "<section class=\"bookPreview\">
<div style=\"height: 0px;\"><div><input class=\"imageURL noMod collapse validate[required,funcCall[checkImage]]\" name=\"imageURL\" type=\"text\" /></div></div>

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
<span class=\"editionPreview details\" style=\"display: none;\">Edition: </span>
<br>
<span class=\"buttonLink pricePreview\"><span>$0.00</span></span>
</section>";

	echo "
</aside>

<section class=\"sell\">
";

//Include the book's information section
	echo "<div class=\"bookInformationSection\">
<h2>Enter the book's information</h2>

<table>
<tbody>
<tr>
<td>ISBN:</td>
<td><input autocomplete=\"off\" class=\"ISBN noIcon validate[required,funcCall[checkISBN]]\" name=\"ISBN\" title=\"Enter the book's ISBN.<br><br>This is a 10 or 13 digit number, seperated by dashes, that can usually be found printed on the back of the book. This number is usually located by the barcode, but is <strong>NOT</strong> the barcode number itself.<br><br>If we have a record of this ISBN in our database, we will attempt automatically fill in the book cover, title, author, edition, and its associated courses.<br><br>If these fields don't automatically populate, then this is a new book in our database and we can only try to suggest an appropriate book cover.\" type=\"text\" /></td>
</tr>

<tr>
<td>Title:</td>
<td><input autocomplete=\"off\" class=\"noIcon titleInput validate[required]\" name=\"title\" title=\"Enter the full title of the book\" type=\"text\" /></td>
</tr>

<tr>
<td>Author:</td>
<td><input autocomplete=\"off\" class=\"noIcon authorInput validate[required]\" name=\"author\" title=\"last name, first name; last name, first name<br><br>Enter the last name, first name of author or authors of this book. If there are multiple authors seperate them with a semicolon and a space.<br><br>For example, if John Smith and Jane Smith were the authors of a particular book, then enter: Smith, John; Smith, Jane\" type=\"text\" /></td>
</tr>

<tr>
<td>Edition:</td>
<td><input autocomplete=\"off\" class=\"editionInput noIcon\" name=\"edition\" title=\"[Optional]<br><br>Enter the edition of this book, such as &quot;Second Edition&quot; or &quot;Revised Edition&quot;.\" type=\"text\" /></td>
</tr>
</tbody>
</table>
</div>

";

//Generate the course information section
	echo "<div class=\"courseInformationSection\">
<h2>In which classes did you use this book?</h2>

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
	
//The double <div> around the text input is a lazy fix for a positioning bug in the jQuery validator
	$courseFlyout = "<div class=\"menuWrapper\">
<div style=\"height: 0px;\"><div><input class=\"collapse noMod validate[required]\" name=\"className[]\" type=\"text\" /></div></div>
	
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
<li class=\"all selected\" data-value=\"0\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('../system/images/icons/all.png');\">Select a Discipline</span></span></li>";

			//Since we inserted a "free" item, add one to the counter
				$counter++;
			} else {
				$courseFlyout .= "
<li>
<ul>";
			}
		}
		
		$courseFlyout .= "
<li data-value=\"" . $category['id'] . "\"><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";

		if ($counter % 10 == 0) {
			$courseFlyout .= "
</ul>
</li>
";
		}

		$counter++;
	}
	
	$courseFlyout .= "</ul>
</div>";

//Generate the course section dropdown
	$section = "<ul class=\"dropdown\" data-name=\"classSec[]\">
<li class=\"selected\">A</li>
<li>B</li>
<li>C</li>
<li>D</li>
<li>E</li>
<li>F</li>
<li>G</li>
<li>H</li>
<li>I</li>
<li>J</li>
<li>K</li>
<li>L</li>
<li>M</li>
<li>N</li>
<li>O</li>
<li>P</li>
</ul>";

//Include a hidden <div> which will contain a copy of the flyout menu for jQuery to copy when additional menus are needed
	echo "<div class=\"flyoutTemplate hidden\">
" . $courseFlyout . "
</div>

";

//Include another hidden <div> which will contain a copy of the section letter menu for jQuery to copy when additional menus are needed
	echo "<div class=\"sectionTemplate hidden\">
" . $section . "
</div>

";

//Finally display the rest of the portion of the class information step
	echo "<div class=\"classTableHeader\">
<span class=\"className\">Class Name</span>
<span class=\"classNum\">Class Number</span>
<span class=\"classSec\">Class Section</span>
</div>
	
<div class=\"classUsed\">
" . $courseFlyout . "

<input autocomplete=\"off\" class=\"noIcon validate[required,custom[integer],min[101],max[499]]\" name=\"classNum[]\" maxlength=\"3\" type=\"text\" />

" . $section . "

<span class=\"delete\" title=\"Delete this class\"></span>
</div>

<span class=\"add\">Add Another Class</span>
</div>

";

//Include the book's information section
	echo "<div class=\"userInformationSection\">
<h2>It's all up to you</h2>

<table>
<tbody>
<tr>
<td>Price:</td>
<td class=\"price\">
<span class=\"align\">\$</span>
<input autocomplete=\"off\" class=\"priceInput noIcon validate[required,funcCall[checkPrice]]\" maxlength=\"6\" name=\"price\" title=\"<strong>Tips for setting a price:</strong> <ul><li>How good of condition is this book?</li><li>Did you get it new or used?</li><li>How much did you buy it for?</li><li>Is this book the current edition?</li></ul><br>Valid prices range from \$0.00 to \$999.99.\" type=\"text\" />
</td>
</tr>

<tr>
<td>Condition:</td>
<td class=\"containsMenu\">
<ul class=\"dropdown\" data-name=\"condition\">
<li>Excellent</li>
<li class=\"selected\">Very Good</li>
<li>Good</li>
<li>Fair</li>
<li>Poor</li>
</ul>
</td>
</tr>

<tr>
<td>Written in:</td>
<td class=\"containsMenu\">
<ul class=\"dropdown\" data-name=\"written\">
<li class=\"selected\">No</li>
<li>Yes</li>
</ul>
</td>
</tr>

<tr class=\"editor\">
<td class=\"description\">Comments:</td>
<td><textarea name=\"comments\"></textarea></td>
</tr>
</tbody>
</table>
</div>

<br>

";

//Include the submit and cancel buttons
	echo "<input class=\"redirect\" name=\"redirect\" type=\"hidden\" value=\"0\" />
<input class=\"again blue\" type=\"submit\" value=\"Submit and Add Another Book\" />
<input class=\"blue finish\" type=\"submit\" value=\"Submit and Finish\" />
<input class=\"cancel\" type=\"button\" value=\"Cancel\" />";

//Include the footer from the administration template
	echo "
</section>
</form>
</section>";

	footer("public");
?>