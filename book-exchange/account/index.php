<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . $title['title'] . "</a></li>
<li><a href=\"../\">Book Exchange</a></li>
<li>My Account</li>\n";
	
//Include the top of the page from the administration template
	topPage("public", "All Book Listings", "" , "", "<link href=\"../system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"../system/stylesheets/account.css\" rel=\"stylesheet\" />", $breadcrumb);
	echo "<section class=\"body\">
";

//Display the user account information
	echo "<section class=\"profile\">
<h2>My Profile</h2>
<span class=\"row\">
<strong>Name:</strong>
" . $userData['firstName'] . " " . $userData['lastName'] . "
</span>

<span class=\"row\">
<strong>Primary email address:</strong>
<a href=\"mailto:" . $userData['emailAddress1'] .  "\">" . $userData['emailAddress1'] . "</a>
</span>

";
	
	if ($userData['emailAddress2'] != "") {
		echo "<span class=\"row\">
<strong>Secondary email address:</strong>
<a href=\"mailto:" . $userData['emailAddress2'] .  "\">" . $userData['emailAddress2'] . "</a>
</span>

";
	} else {
		echo "<span class=\"row\">
<strong>Secondary email address:</strong>
<span class=\"none\">None given</span>
</span>

";
	}
	
	if ($userData['emailAddress3'] != "") {
		echo "<span class=\"row\">
<strong>Tertiary email address:</strong>
<a href=\"mailto:" . $userData['emailAddress3'] .  "\">" . $userData['emailAddress3'] . "</a>
</span>

";
	} else {
		echo "<span class=\"row\">
<strong>Tertiary email address:</strong>
<span class=\"none\">None given</span>
</span>

";
	}
	
	echo "<span class=\"row\">
<strong>Password:</strong>
<span>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</span>
</span>

<button class=\"blue updateProfile\">Update Profile</button>
</section>

";
	
//Include a list of books that the user has listed for sale
	$booksGrabber = mysql_query("SELECT books.*, bookcategories.*, books.id AS bookID, books.course AS courseID FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id WHERE books.id IS NOT NULL GROUP BY books.linkID ORDER BY books.upload DESC", $connDBA);
	$exchangeSettings = mysql_fetch_assoc(mysql_query("SELECT * FROM exchangesettings WHERE id = '1'", $connDBA));
	
	echo "<section class=\"books\">
<h2>My Books</h2>
<ul>";
	
	if (mysql_num_rows($booksGrabber)) {
		$now = strtotime("now");
		$week = strtotime("+1 week");
		
		while ($book = mysql_fetch_assoc($booksGrabber)) {
		//Has this book expired, been sold, or will it expire within the next week?
			if ($book['sold'] == "0" && ($book['upload'] + $exchangeSettings['expires']) < $now) {
				$class = " expired";
				$expireRenew = "<span class=\"action renew\" data-id=\"" . $book['bookID'] . "\" title=\"Restore to the Exchange\"><img src=\"../system/images/icons/renew.png\" /></span>
";
				$expire = "<span class=\"expire\">Expired: " . date("F jS, Y \a\\t h:i A", ($book['upload'] + $exchangeSettings['expires'])) . "</span>
";
				$status = "<span class=\"expired\">Expired</span>
";
			} elseif ($book['sold'] == "0" && ($book['upload'] + $exchangeSettings['expires']) < ($week) && ($book['upload'] + $exchangeSettings['expires']) > ($now)) {
				$class = " soon";
				$expireRenew = "<span class=\"action renew\" data-id=\"" . $book['bookID'] . "\" title=\"Restore to the Exchange\"><img src=\"../system/images/icons/renew.png\" /></span>
";
				$expire = "<span class=\"expire\">Expires: " . date("F jS, Y \a\\t h:i A", ($book['upload'] + $exchangeSettings['expires'])) . "</span>
";
				$status = "<span class=\"expiring\">Expiring Soon, Click the Renew Button to Prevent Expiration</span>
";
			} elseif ($book['sold'] == "1") {
				$class = " sold";
				$expireRenew = "<span class=\"action renew\" data-id=\"" . $book['bookID'] . "\" title=\"Restore to the Exchange\"><img src=\"../system/images/icons/renew.png\" /></span>
";
				$expire = "";
				$status = "<span class=\"sold\">Sold</span>
";
			} else {
				$class = "";
				$expireRenew = "";
				$expire = "<span class=\"expire\">Expires: " . date("F jS, Y \a\\t h:i A", ($book['upload'] + $exchangeSettings['expires'])) . "</span>
";
				$status = "";
			}
			
			echo "
<li class=\"book\">
<div class=\"alert" . $class . "\">
<a name=\"book_" . $book['bookID'] . "\"></a>
<a href=\"../book/?id=" . $book['bookID'] . "\"><img src=\"" . $book['imageURL'] . "\" /></a>
<a class=\"title\" href=\"../book/?id=" . $book['bookID'] . "\">" . $book['title'] . "</a>
<span class=\"details\"><strong>Author</strong>: " . $book['author'] . "</span>
<span class=\"details\"><strong>ISBN</strong>: " . $book['ISBN'] . "</span>
" . $expireRenew . "<a class=\"action edit\" href=\"../sell-books/?id=" . $book['bookID'] . "\" title=\"Edit this Book\"><img src=\"../system/images/icons/edit.png\" /></a>
<a class=\"action delete\" href=\"../account/?delete=" . $book['bookID'] . "\" title=\"Delete this Book\"><img src=\"../system/images/icons/delete.png\" /></a>
" . $expire . $status . "</div>
</li>
";
		}
	}
	
	echo "</ul>
</section>

";
	
//Include a list of books that the user has purchased
	$purchasedGrabber = mysql_query("SELECT books.*, purchases.*, users.*, books.id AS bookID FROM books RIGHT JOIN (purchases) ON books.id = purchases.bookID RIGHT JOIN (users) ON purchases.sellerID = users.id WHERE purchases.buyerID = '{$userData['id']}' AND books.id IS NOT NULL GROUP BY books.linkID ORDER BY purchases.time DESC", $connDBA);
	
	
	echo "<section class=\"purchases\">
<h2>My Purchases</h2>
<ul>";
	
	if (mysql_num_rows($booksGrabber)) {
		while ($purchase = mysql_fetch_assoc($purchasedGrabber)) {
			echo "
<li class=\"book\">
<img src=\"" . $purchase['imageURL'] . "\" />
<span class=\"title\">" . $purchase['title'] . "</span>
<span class=\"details\"><strong>Seller</strong>: " . $purchase['firstName'] . " " . $purchase['lastName'] . "</span>
<span class=\"details\"><strong>Purchased</strong>: " . date("F jS, Y", $purchase['time']) . "</span>
<span class=\"buttonLink\"><span>\$" . $purchase['price'] . "</span></span>
</li>
";
		}
	}
	
	echo "</ul>
</section>

";
	
//Include the footer from the public template
	echo "
</section>";

	footer("public");
?>