<?php 
//Include the system core
	require_once('Connections/connDBA.php'); 
	
//Logout the user
	session_destroy();
	setcookie("UID", "", time() - 3600);
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . stripslashes($title['title']) . "</a></li>
<li>Logout</li>\n";
	
//Setup the page environmental parameters
	$title = "Logout";
	$pageType = "public";
	
	if (isset($_GET['action']) && $_GET['action'] == "relogin") {
		$HTML = "<meta http-equiv=\"refresh\" content=\"8; url=login.php\">";
	} else {
		$HTML = "<meta http-equiv=\"refresh\" content=\"3; url=index.php\">";
	}
	
	topPage($pageType, $title, "", "", $HTML, $breadcrumb);

//Display a different logout message depending on the URL parameters
	if (isset($_GET['action']) && $_GET['action'] == "relogin") {
		echo "<p>&nbsp;</p>
<div align=\"center\">Your profile has been updated. Since your role in this site has changed, you must login again.</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>";
	} else {
		echo "<p>&nbsp;</p>
<div align=\"center\">
You have successfully logged out.
<br><br>
<button class=\"blue\" onclick=\"javascript:document.location.href='index.php'\">Go Home</button>
</div>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>";
	}
	
//Display the footer
	footer($pageType);
?>