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
	echo "<p>Enter the ISBN number of the book which you like to sell. If a record of your book is already in the database, we will attempt automatically fill in the book cover, title, author, edition, and its associated course.</p>
<p>If these fields don't automatically populate for you, then either this is a new book in our database or the ISBN was entered incorrectly. Please note that if this book does not exist in our database, be sure to check that the suggested book cover is correct. You can use the arrows underneith the image to browse through a selection of avaliable images. Please choose a product image that looks best.</p>";

//Include the book's information section
	echo "<table>
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
</table>";

//Include the footer from the administration template
	echo "
</section>
</section>";

	footer("public");
?>