<?php
//Include the system's core
	require_once("Connections/connDBA.php");
	require_once("Connections/Validate.php");
	
//Don't allow access from logged out users, or users whose password does not need reset!
	if (!loggedIn() || (loggedIn() && $userData['changePassword'] != "on")) {
		redirect("book-exchange");
	}
	
//Process the change password request
	if (isset($_POST['old']) && isset($_POST['new']) && isset($_POST['confirm'])) {
		$empty = "dff6ed62647291fa0bc5d7bbf104771b"; //If any of these encrypted values are empty, they will equal this
		$hash = "+y4hn&T/'K";
		$old = $_POST['old'];
		$new = $_POST['new'];
		$confirm = $_POST['confirm'];
		
		if ($old != $empty && $new != $empty && $new === $confirm) {
			$old = md5($_POST['old'] . "_" . $hash);
			$new = md5($_POST['new'] . "_" . $hash);
			
			$update = mysql_query("UPDATE users SET passWord = PASSWORD('{$new}'), changePassword = '' WHERE passWord LIKE PASSWORD('{$old}')");
			
			if ($update && mysql_affected_rows($update) == 0) {
				redirect("reset.php?fail=true");
			}
			
			//Remove comments when administration section is ready
			//if ($userData['role'] == "Administrator") {
			//	redirect("admin/index.php");
			//} else {
				redirect("book-exchange");
			//}
		} else {
			if ($old == $empty) {
				redirect("reset.php?empty=true");
			} else {
				redirect("reset.php?match=false");
			}
		}
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . stripslashes($title['title']) . "</a></li>
<li><a href=\"login.php\">Login</a></li>
<li>Reset Password</li>\n";
	
//Include the top of the page from the administration template
	topPage("public", "Reset Password", "" , "", "<link href=\"styles/common/login.css\" rel=\"stylesheet\" />
<script src=\"javascripts/common/md5.min.js\"></script>", $breadcrumb);
	echo "<section class=\"body\">
";

//Display any needed messages
	if (!isset($_GET['fail']) && !isset($_GET['empty']) && !isset($_GET['match'])) {
		echo "<div class=\"center\"><div class=\"error\">You'll have to reset your password before proceeding</div></div>";
	}
	
	if (isset($_GET['fail'])) {
		echo "<div class=\"center\"><div class=\"error\">That doesn't look like the password that we emailed you. Try it again.</div></div>";
	}
	
	if (isset($_GET['empty'])) {
		echo "<div class=\"center\"><div class=\"error\">Please fill out all of the fields</div></div>";
	}
	
	if (isset($_GET['match'])) {
		echo "<div class=\"center\"><div class=\"error\">Your new passwords don't match. Try them again.</div></div>";
	}
	
//Display the login form
echo "
<h2>Reset Password</h2>
<p>Enter the password that you recieved in the email in the first text box, then pick a password that you will remember and enter them in the next two.</p>
<br>

<form action=\"reset.php\" class=\"account\" method=\"post\">
<p>Password we emailed you:</p><input autocomplete=\"off\" name=\"old\" type=\"password\" />
<br><br>
<p>New password: </p><input autocomplete=\"off\" name=\"new\" type=\"password\" />
<p>New password (again): </p><input autocomplete=\"off\" name=\"confirm\" type=\"password\" />
<br><br>
<input class=\"blue\" type=\"submit\" value=\"Submit\" />
</form>";

//Include the footer from the public template
	echo "
</section>";

	footer("public");
?>