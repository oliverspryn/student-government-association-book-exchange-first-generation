<?php
//Include the system's core
	require_once("../../../Connections/connDBA.php");
	require_once("../../../Connections/PHPMailer/class.phpmailer.php");
	
//Is this user logged in?
	if (!loggedIn()) {
		die("failed");
	}
	
//SMTP logon information
	$username = "no-reply@forwardfour.com";
	$password = "n*O^]z%]|c44Q~3";
	
//Grab the buyer's information
	$fromEamil = $userData['emailAddress1'];
	$fromName = $userData['firstName'] . " " . $userData['lastName'];
	
//Grab the seller's information
	$sellerData = mysql_query("SELECT * FROM users WHERE id = (SELECT userID FROM books WHERE id = '{$_GET['id']}' AND avaliable = '1')", $connDBA);
	
	if ($sellerData) {
		$seller = mysql_fetch_array($sellerData);
		$toEmail = $seller['emailAddress1'];
		$toName = $seller['firstName'] . " " . $seller['lastName'];
	} else {
		die("failed");
	}
	
//Grab the book information
	
	
//Send a notification email
	try {
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->Username = $username;
		$mail->Password = $password;
		$mail->AddAddress($toEmail, $toName);
		$mail->SetFrom($toEmail, $toName);
		$mail->AddReplyTo($fromEamil, $fromName);
		$mail->Subject = "This came through!";
		$mail->AltBody = "This is an alternate body";
		$mail->MsgHTML("<p>Hi there! Again!!! :D");
		$mail->Send();
		
		echo "success";
	} catch (phpmailerException $e) {
		echo $e->errorMessage();
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>