<?php
//Include the system's core
	require_once("Connections/connDBA.php");
	require_once("Connections/Validate.php");

//Activate a user's account
	if (!loggedIn() && isset($_GET['id']) && isset($_GET['email'])) {
		$id = Validate::required($_GET['id'], false, false, false, 15);
		$email = Validate::isEmail(urldecode($_GET['email']));
		$statement = odbc_prepare($connDBA, "UPDATE users SET activation = '' WHERE activation LIKE ? AND emailAddress1 LIKE ?");
		$activateCheck = odbc_exec($statement, array($id, $email));
		
		if ($activateCheck && odbc_num_rows($statement) != 0) {
			redirect("login.php?activated=true");
		} else {
			redirect("login.php?activated=false");
		}
	} else {
		redirect("login.php");
	}
?>