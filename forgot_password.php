<?php
//Include the system's core
	require_once("Connections/connDBA.php");
	require_once("Connections/Validate.php");
	require_once("Connections/PHPMailer/class.phpmailer.php");
	
//Don't allow access from logged in users!
	if (loggedIn()) {
		redirect("book-exchange");
	}
	
//Process the recovery request
	if (isset($_POST['username'])) {
		$email = mysql_real_escape_string(Validate::required($_POST['username']));
		$rawPassword = randomValue("10");
		
	//Emulate the first level of encryption which usually is done via JavaScript
		$hash1 = "(Cn%%fJV5J";
		$password1 = md5($rawPassword . "_" . $hash1);
		
	//Perform the second level of encryption, which always occurs on the server
		$hash2 = "+y4hn&T/'K";
		$password2 = md5($password1 . "_" . $hash2);
		
	//Execute the query on the database
		$affected = mysql_query("UPDATE users SET passWord = PASSWORD('{$password2}'), changePassword = 'on' WHERE emailAddress1 LIKE '{$email}'", $connDBA);
		
	//Send this user an email
		if (mysql_affected_rows($connDBA)) {
		//SMTP logon information
			$username = "no-reply@forwardfour.com";
			$password = "431fc9b9-b977-4bfd-ab55-1472f0687a40";
			
		//Generate a subject and message
			$subject = "Password Recovery Request";
			$bodyHTML = "<!DOCTYPE html>
<html lang=\"en-US\">
<head>
<meta charset=\"utf-8\">
<title>" . $subject . "</title>
</head>

<body>
<h2>Password Recovery Request</h2>
<p>We have reset your password to: <strong>" . $rawPassword . "</strong></p>
<p>Once you <a href=\"" . $defaultRoot . "login\" style=\"color: #4BF; text-decoration: none;\">login</a>, you will be asked to change it to a more suitable password.</p>			
</body>
</html>";
			
			$altBody = "PASSWORD RECOVERY REQUEST
			
We have reset your password to: " . $rawPassword . "
Once you login, you will be asked to change it to a more suitable password.

Login here: " . $defaultRoot . "login";
	
		//Send a notification email
			try {
				$mail = new PHPMailer(true);
				$mail->IsSMTP();
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = true;
				$mail->Host = "smtp.mandrillapp.com";
				$mail->Port = 587;
				$mail->Username = $username;
				$mail->Password = $password;
				$mail->AddAddress($_POST['username']);
				$mail->SetFrom("no-reply@forwardfour.com", "No-Reply");
				$mail->Subject = $subject;
				$mail->AltBody = $altBody;
				$mail->MsgHTML($bodyHTML);
				$mail->Send();
			} catch (phpmailerException $e) {
				//Oh well, ignore. Probably a bad email address
			} catch (Exception $e) {
				//Oh well, ignore. Probably a bad email address
			}
		}
		
	//Redirect back to the login page, without giving any signs or hints of success or failure, to protect data
		redirect($defaultRoot . "login.php?reset=true");
	}
	
//Generate the breadcrumb
	$home = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
	$title = unserialize($home['content' . $home['display']]);
	$breadcrumb = "\n<li><a href=\"" . $root . "index.php?page=" . $home['id'] . "\">" . stripslashes($title['title']) . "</a></li>
<li><a href=\"login.php\">Login</a></li>
<li>Password Recovery</li>\n";
	
//Include the top of the page from the administration template
	topPage("public", "Password Recovery", "" , "", "<link href=\"styles/common/login.css\" rel=\"stylesheet\" />", $breadcrumb);
	
	echo "<section class=\"body\">
<h2>Password Recovery</h2>
<p>Forgot your password? No problem, this happens all of the time. Just share your email with us and we can help.</p>
<br>
<form action=\"" . $mailerRoot . "forgot_password.php\" class=\"account\" method=\"post\">
<p>Email address:</p>
<input autocomplete=\"off\" name=\"username\" type=\"email\"/>
<br><br>
<input class=\"blue\" type=\"submit\" value=\"Help!\" />
<input onclick=\"javascript:document.location.href='login.php'\" type=\"button\" value=\"Cancel\" />
</form>";

	
//Include the footer from the public template
	echo "
</section>";

	footer("public");
?>