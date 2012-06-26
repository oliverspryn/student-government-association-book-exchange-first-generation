<?php
//Include the system's core
	require_once("Connections/connDBA.php");
	require_once("Connections/Validate.php");

//Activate a user's account
	if (!loggedIn() && isset($_GET['id']) && isset($_GET['email'])) {
		$id = mysql_real_escape_string(Validate::required($_GET['id'], false, false, false, 15));
		$email = mysql_real_escape_string(Validate::isEmail(urldecode($_GET['email'])));
		$activateCheck = mysql_query("UPDATE users SET activation = '' WHERE activation LIKE '{$id}' AND emailAddress1 LIKE '{$email}'", $connDBA);
		
		if ($activateCheck && mysql_affected_rows($connDBA) != 0) {
			redirect("login.php?activated=true");
		} else {
			redirect("login.php?activated=false");
		}
	} else {
		redirect("login.php");
	}
?>