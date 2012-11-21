<?php
//Include the system's core
	require_once("Connections/connDBA.php");
	require_once("Connections/Validate.php");
	require_once("Connections/PHPMailer/class.phpmailer.php");
	
//Don't allow access from logged in users!
	if (loggedIn()) {
		//Remove comments when administration section is ready
		//if ($userData['role'] == "Administrator") {
		//	redirect("admin/index.php");
		//} else {
			redirect("book-exchange");
		//}
	}

//Process a login request
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action'] == "login") {
	//Can this user log in, or have they maxed out their login attempts?
		$yesterday = strtotime("-1 day");
		$computerName = mysql_real_escape_string(gethostbyaddr($_SERVER['REMOTE_ADDR']));
		$loginCheck = mysql_query("SELECT failedlogins.*, siteprofiles.failedLogins AS max, COUNT(failedlogins.id) AS total FROM failedlogins RIGHT JOIN (siteprofiles) ON failedlogins WHERE computerName = '{$computerName}' AND timeStamp > '{$yesterday}' GROUP BY computerName", $connDBA);
		
		if ($loginCheck && mysql_num_rows($loginCheck)) {
			$loginTries = mysql_fetch_assoc($loginCheck);
			$failed = $loginTries['total'];
			$total = $loginTries['max'];
			
			if ($failed >= $total) {
				redirect("login.php?expired=true");
			}
		} else {
			$totalGrabber = mysql_fetch_assoc(mysql_query("SELECT failedLogins FROM siteprofiles WHERE id = '1'", $connDBA));
			
			$failed = "0";
			$total = $totalGrabber['failedLogins'];
		}
		
	//Process the login
		$hash = "+y4hn&T/'K";
		$email = mysql_real_escape_string(Validate::required($_POST['username']));
		$password = md5(Validate::required($_POST['password']) . "_" . $hash);
		
	//Does a user with this username/password combination exist?
		$check = mysql_query("SELECT * FROM users WHERE emailAddress1 LIKE '{$email}' AND passWord LIKE PASSWORD('{$password}')", $connDBA);
		
		if ($check && mysql_num_rows($check) == 1) {
			$userData = mysql_fetch_assoc($check);
			
		//Did the user activate his or her account?
			if ($userData['activation'] != "") {
				redirect("login.php?notActivated=true");
			}
			
		//Establish the user's session
			$_SESSION['MM_Username'] = $userData['emailAddress1'];
			$_SESSION['MM_UserGroup'] = $userData['role'];

			setcookie("UID", $userData['id']);
			
		//Determine where to redirect the user
			if (isset($_GET['accesscheck']) && $_GET['accesscheck'] != "") {
				redirect(urldecode($_GET['accesscheck']));
			} elseif (isset($_POST['redirect']) && $_POST['redirect'] != "") {
				redirect($_POST['redirect']);
				
			} else {
				//Remove comments when administration section is ready
				//if ($userData['role'] == "Administrator") {
				//	redirect("admin/index.php");
				//} else {
					redirect("book-exchange");
				//}
			}
	//No? Then log this fail and redirect
		} else {
			$timestamp = strtotime("now");
			$failed++;
			
			mysql_query("INSERT INTO failedlogins (
						 	id, timeStamp, computerName, userName
						 ) VALUES (
						 	NULL, '{$timestamp}', '{$computerName}', '{$email}'
						 )", $connDBA);
			
		//Determine where to redirect this user
			if ($failed >= $total) {
				redirect("login.php?expired=true");
			} else {
				$remaining = $total - $failed;
				
				if (isset($_GET['accesscheck'])) {
					redirect("login.php?failed=true&remaining=" . $remaining . "&accesscheck=" . $_GET['accesscheck']);
				} else {
					redirect("login.php?failed=true&remaining=" . $remaining);
				}
			}
		}
	}
	
//Process a registration request
	if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action'] == "register") {
		$hash = "+y4hn&T/'K";
		$time = strtotime("now");
		$activation = randomValue("15");
		$name = explode(" ", $_POST['name']);
		$firstName = mysql_real_escape_string(Validate::required($name[0]));
		$lastName = mysql_real_escape_string(Validate::required($name[1]));
		$email = mysql_real_escape_string(Validate::isEmail($_POST['username']));
		$password = md5(Validate::required($_POST['password']) . "_" . $hash);
		
	//Is this email from the gcc.edu email domain?
		$emailSplit = explode("@", $email);
		
	//Has the email already been used?
		$usedCheck = mysql_query("SELECT * FROM users WHERE emailAddress1 = '{$email}'", $connDBA);
		
		if ($usedCheck && mysql_num_rows($usedCheck) != 0) {
			redirect($defaultRoot . "login.php?used=true");
		}
		
		if ($emailSplit[1] == "gcc.edu") {
		//Add the user to the database
			mysql_query("INSERT INTO users (
						 	id, active, activation, firstName, lastName, passWord, changePassword, emailAddress1, emailAddress2, emailAddress3, role
						 ) VALUES (
						 	NULL, '{$time}', '{$activation}', '{$firstName}', '{$lastName}', PASSWORD('{$password}'), '', '{$email}', '', '', 'User'
						 )", $connDBA);
			
		//Send the user an activation email
		//SMTP logon information
			$username = "no-reply@forwardfour.com";
			$password = "431fc9b9-b977-4bfd-ab55-1472f0687a40";
			
		//Generate a subject and message
			$subject = "Student Government Association Book Exchange Activation";
			$bodyHTML = "<!DOCTYPE html>
<html lang=\"en-US\">
<head>
<meta charset=\"utf-8\">
<title>" . $subject . "</title>
</head>

<body>
<h2>Student Government Association Book Exchange Activation</h2>
<p>Welcome aboard " . $firstName . "!</p>
<p>To get started, click <a href=\"" . $defaultRoot . "activate.php?id=" . urlencode($activation) . "&email=" . urlencode($_POST['username']) . "\" style=\"color: #4BF; text-decoration: none;\">here</a> to activate your account.</p>
<br><br>
<p>~ The Student Government Association</p>			
</body>
</html>";
			
			$altBody = "STUDENT GOVERNMENT ASSOCIATION BOOK EXCHANGE ACTIVATION
			
Welcome aboard " . $firstName . "!
To get started, copy and paste the link below into your web browser to activate your account:

" . $defaultRoot . "activate.php?id=" . urlencode($activation) . "&email=" . urlencode($_POST['username']) . "

Happy selling!
~ The Student Government Association";
	
		//Send a notification email
			email($_POST['username'], $name[0] . " " . $name[1], "no-reply@forwardfour.com", "No-Reply", $subject, $bodyHTML, $altBody);			
			redirect($defaultRoot . "login.php?registered=true");
		} else {
			redirect($defaultRoot . "login.php?domain=true");
		}
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . stripslashes($title['title']) . "</a></li>
<li>Login</li>\n";
	
//Include the top of the page from the administration template
	topPage("public", "Login", "" , "", "<link href=\"styles/common/login.css\" rel=\"stylesheet\" />", $breadcrumb);
	echo "<section class=\"body\">
";
	
//Display a login failed alert
	if (isset($_GET['failed']) && isset($_GET['remaining'])) {
		if ($_GET['remaining'] == 1) {
			$more = "more time";
		} else {
			$more = "more times";
		}
		
		echo "<div class=\"center\"><div class=\"error\">Your user name or password is incorrect.</div></div>
		
";
		
		//echo "<div class=\"center\"><div class=\"error\">Your user name or password is incorrect. You may try logging in <strong>" . $_GET['remaining'] . "</strong> " . $more . ".</div></div>
		//
//";
	}
	
	if (isset($_GET['expired'])) {
		echo "<div class=\"center\"><div class=\"error\">You have exceeded the maxmium number of failed logins allowed for a 24 hour period. Please wait 24 hours before trying again.</div></div>
		
";
	}
	
	if (isset($_GET['reset'])) {
		echo "<div class=\"center\"><div class=\"success\">If the email address you entered existed in our database, then we have emailed you a temporary password</div></div>
		
";
	}
	
	if (isset($_GET['used'])) {
		echo "<div class=\"center\"><div class=\"error\">The email address you entered is already registered. Do you already have an account here? Perhaps you <a href=\"forgot_password.php\">forgot your password</a>.</div></div>
		
";
	}
	
	if (isset($_GET['domain'])) {
		echo "<div class=\"center\"><div class=\"error\">Sorry, but we can only accept sign ups from people whose email address ends in &quot;gcc.edu&quot;</div></div>
		
";
	}
	
	if (isset($_GET['registered'])) {
		echo "<div class=\"center\"><div class=\"success\">Your account has been created. Please check your email within a few minutes for an email from us with an activation link inside.</div></div>
		
";
	}
	
	if (isset($_GET['activated']) && $_GET['activated'] == "true") {
		echo "<div class=\"center\"><div class=\"success\">Your account has been activated. Thanks for signing up! Now you may login to start using your account.</div></div>
		
";
	}
	
	if (isset($_GET['activated']) && $_GET['activated'] == "false") {
		echo "<div class=\"center\"><div class=\"error\">We could not activate your account. Try clicking on or copying and pasting the link from the email again.</div></div>
		
";
	}
	
	if (isset($_GET['notActivated'])) {
		echo "<div class=\"center\"><div class=\"error\">Your account has not been activated. Please click on the link within the email we sent before accessing your account.</div></div>
		
";
	}
	
	if ((isset($_GET['accesscheck']) && !isset($_GET['expired']) && !isset($_GET['reset']) && !isset($_GET['failed']) && !isset($_GET['remaining']) && !isset($_GET['used']) && !isset($_GET['domain']) && !isset($_GET['registered']) && !isset($_GET['activated']) && !isset($_GET['notActivated'])) || (isset($_GET['message']) && $_GET['message'] == "required")) {
		echo "<div class=\"center\"><div class=\"error\">You'll need to login before you can do this</div></div>
		
";
	}
	
//Display the login form
	echo "<div class=\"wrapper\">
<div class=\"login\">
<h2>Login</h2>

<form action=\"login.php\" method=\"post\">
<p>Email address:</p><input autocomplete=\"off\" name=\"username\" type=\"text\" />
<p>Password: </p><input autocomplete=\"off\" name=\"password\" type=\"password\" />
<input name=\"action\" type=\"hidden\" value=\"login\" />
<br><br>
<input class=\"red\" type=\"submit\" value=\"Login\" />
<p><a href=\"forgot_password.php\">Forgot your password?</a></p>
</form>
</div>

<span class=\"toggle\"></span>

<div class=\"register\">
<form action=\"" . $mailerRoot . "login.php\" method=\"post\">
<h2>Register</h2>
<p>First and last name:</p><input autocomplete=\"off\" name=\"name\" type=\"text\">
<p>Email address:</p><input autocomplete=\"off\" name=\"username\" type=\"email\">
<p>Password:</p><input autocomplete=\"off\" name=\"password\" type=\"password\">
<input name=\"action\" type=\"hidden\" value=\"register\" />
<br><br>
<input class=\"green\" type=\"submit\" value=\"Register\">
</form>
</div>
</div>";

//Include the footer from the public template
	echo "
</section>";

	footer("public");
?>