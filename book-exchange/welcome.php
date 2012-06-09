<?php
//Include the system's core
	require_once("../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("public", "Book Exchange", "" , "", "<link href=\"system/stylesheets/style.css\" rel=\"stylesheet\" />
<link href=\"system/stylesheets/welcome.css\" rel=\"stylesheet\" />
<link href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css\" rel=\"stylesheet\" />
<script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js\"></script>
<script src=\"system/javascripts/interface.js\"></script>
<script>
$(document).ready(function() {
	var requestURL = 'system/server/suggestions.php';
	
	$('input.search.full').autocomplete({
		'source' : requestURL,
		'minLength' : 2,
		'select' : function(event, ui) {
			$(this).val(ui.item.label).parent().parent().submit();
		}, 'search' : function(event, ui) {
			var searchBy = $(this).parent().parent().children('div.controls').find('div.dropdownWrapper ul li.selected').text();
			var searchIn = $(this).parent().parent().children('div.controls').find('div.menuWrapper ul li ul li.selected').attr('data\-value');
			$(this).autocomplete('option', 'source', requestURL + '?searchBy=' + searchBy + '&category=' + searchIn);
		}
	});
	
	$['ui']['autocomplete'].prototype['_renderItem'] = function(ul, item) {
		return $('<li />').data('item.autocomplete', item).append($('<a title=\"' + item.label + '\"></a>').html('<img src=\"' + item.image + '\" /><span class=\"title\">' + item.label + '</span><span class=\"author details\">Author: ' + item.author + '</span><span class=\"details total\">Total: ' + item.total + '</span>')).appendTo(ul);
	};

});
</script>");
	echo "<section class=\"body\">
";

//Include section one
	echo "<section class=\"welcome\">
<div class=\"design\">
<h1>Book Exchange</h1>

<div class=\"mask\">
<div class=\"sell\">
<button class=\"blue large openLogin\">Sell Books</button>
</div>

<span class=\"divider\"></span>

<div class=\"search\">
<form action=\"search\" method=\"get\">
<h2 class=\"search\">Search for Books:</h2>
<input autocomplete=\"off\" class=\"search full\" name=\"search\" type=\"text\" />
<span class=\"expand\">Advanced Search Options</span>

<div class=\"controls hidden\">
<span class=\"searchStep\">Search by:</span>
<ul class=\"dropdown\" data-name=\"searchBy\">
<li class=\"selected\">Title</li>
<li>Author</li>
<li>ISBN</li>
</ul>

<br>

<div class=\"menuWrapper\">
<div style=\"height: 0px;\"><div><input class=\"collapse noMod\" name=\"category\" type=\"text\" value=\"0\" /></div></div>

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
<li class=\"all selected\" data-value=\"0\"><span class=\"band\" style=\"border-left-color: #FFFFFF;\"><span class=\"icon\" style=\"background-image: url('system/images/icons/all.png');\">All Disciplines</span></span></li>";

			//Since we inserted a "free" item, add one to the counter
				$counter++;
			} else {
				echo "
<li>
<ul>";
			}
		}
		
		echo "
<li data-value=\"" . $category['id'] . "\"><span class=\"band\" style=\"border-left-color: " . $category['color1'] . ";\"><span class=\"icon\" style=\"background-image: url('../data/book-exchange/icons/" . $category['id'] . "/icon_032.png');\">" . $category['name'] . "</span></span></li>";

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

<input class=\"yellow submit\" type=\"submit\" value=\"Search\" />
</form>
</div>
</div>
</div>
</section>

<img class=\"shadow\" src=\"system/images/welcome/paper_shadow.png\" />

";

//Include section two
	echo "<section class=\"introduction\">
<section class=\"video\">
<object width=\"100%\" height=\"600\">
<param name=\"allowfullscreen\" value=\"true\" />
<param name=\"allowscriptaccess\" value=\"always\" />
<param name=\"wmode\" value=\"transparent\" />
<param name=\"movie\" value=\"http://vimeo.com/moogaloop.swf?clip_id=18851690&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=c9ff23&amp;fullscreen=1&amp;autoplay=0&amp;loop=0\" />
<embed src=\"http://vimeo.com/moogaloop.swf?clip_id=18851690&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=c9ff23&amp;fullscreen=1&amp;autoplay=0&amp;loop=0\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" allowscriptaccess=\"always\" width=\"100%\" height=\"600\"></embed>
</object>
</section>

<section class=\"description\">
<h2>Welcome to the new book exchange!</h2>
<p>The SGA has been hard at work and is proud to bring you a new and improved student book exchange.</p>
<p>We have made so many enchancements to boost your experience, that it's hard to know where to begin! Would you like to learn more about it? Sure you would! Scroll down to start exploring.</p>
</section>
</section>

";

//Include section three
	echo "<section class=\"screenshots\">
<img src=\"system/images/welcome/view_categories.png\" />

<h2>Built By Students, For Students</h2>
<p>The semiannual book exchange ritual doesn't have to be a drag. From its captivating start to a satisfying end, this service has been designed to <strong>think the way you think</strong>. Here at SGA, we make it a point to <strong>sell your books fast</strong> by giving each of them the attention they deserve. Our new searching and cataloguing systems provide a unique and intuitive interface to help you <strong>quickly find the books you need</strong> for that next class.</p>
<h2>Old Ideas Reimagined</h2>
<p>This new release contains all of the <strong>same tools</strong> that you enjoyed in the previous exchange. However, we've <strong>improved and expanded</strong> on these old ideas and introduced a whole <strong>new set of tools and capibilities</strong> which are designed to make the book exchanging process as pain free (and enjoyable) as possible.</p>
</section>

";

//Include section four
	echo "<section class=\"tiles\">
<div class=\"design\">
<h2>Something New: Exchange Tiles</h2>
<p>Life in college is hard enough, but exchanging your books shouldn't be. That's why we've introduced the exchange titles. They are a colorful feature of our cataloguing system which are designed to <strong>catch your eye</strong> and <strong>trigger your memory</strong> whenever you see one of them.</p>
<p>These tiles show up all through out the site, from browsing and searching our database, to selling books of your own. Each discipline of study is assigned a <strong>unique color and pair of letters</strong> to help set them apart from others. You'll learn to <strong>quickly spot</strong> them on a page for your <strong>areas of interest</strong>.</p>
<a class=\"explore highlight\" href=\"listings\">Start Exploring</a>
</div>
</section>

";

//Include section five
	echo "<section class=\"features\">
<div class=\"sell\">
<h2>Sell Your Book in 17.5 Seconds</h2>
<p>Yes, we actually counted. We've engineered this exchange to be as easy as possible. With lots of <strong>integrated tools</strong> that are desgined to <strong>enhance your speed and productivity</strong>, you'll be able to buy and sell books fast so you can get back to what is really important.</p>
</div>

<div class=\"search\">
<h2>Get Answers As You Type</h2>
<p>Yes, we actually counted. We've engineered this exchange to be as easy as possible. With lots of <strong>integrated tools</strong> that are desgined to <strong>enhance your speed and productivity</strong>, you'll be able to buy and sell books fast, so you can get back to what is really important.</p>
</div>
</section>

";


//Include the footer from the administration template
	echo "
</section>";

	footer("public");
?>