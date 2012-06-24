<?php
//Include the system's core
	require_once("../../../Connections/connDBA.php");
	require_once("../../../Connections/PHPMailer/class.phpmailer.php");
	
//Is this user logged in?
	if (!loggedIn()) {
		die("You are not logged in");
	}
	
//Have we been given the proper parameters?
	if (!isset($_GET['id'])) {
		die("What book do you want to buy?");
	}
	
//SMTP logon information
	$username = "no-reply@forwardfour.com";
	$password = "n*O^]z%]|c44Q~3";
	
//Grab the buyer's information
	$fromEamil = $userData['emailAddress1'];
	$fromName = $userData['firstName'] . " " . $userData['lastName'];
	
//Grab the seller's information
	$sellerData = mysql_query("SELECT * FROM users WHERE id = (SELECT userID FROM books WHERE id = '{$_GET['id']}')", $connDBA);
	
	if ($sellerData && mysql_num_rows($sellerData)) {
		$seller = mysql_fetch_array($sellerData);
		$toEmail = $seller['emailAddress1'];
		$toName = $seller['firstName'] . " " . $seller['lastName'];
	} else {
		die("We cannot find a user for this book or the book is unavaliable");
	}
	
//Don't let the buyer buy from themself!
	if ($userData['id'] == $seller['id']) {
		die("Wait... you can't buy from yourself!");
	}
	
//Grab the book information
	$now = strtotime("now");
	$bookData = mysql_query("SELECT exchangesettings.expires, books.*, bookcategories.* FROM books RIGHT JOIN (bookcategories) ON books.course = bookcategories.id RIGHT JOIN(exchangesettings) ON books.id WHERE books.id = '{$_GET['id']}' AND books.sold = '0' AND books.userID != '0' AND books.upload + exchangesettings.expires > {$now}", $connDBA);
	
	if ($bookData && mysql_num_rows($bookData)) {
		$book = mysql_fetch_array($bookData);
	} else {
		die("This book does not exist");
	}
	
//Generate the body of the email
	$subject = "Purchase Request for " . stripslashes($book['title']);
	$bodyHTML = "<!DOCTYPE html>
<html lang=\"en-US\">
<head>
<meta charset=\"utf-8\">
<title>" . $subject . "</title>
</head>

<body>
<table border=\"0\" style=\"background: url(" . $root . "themes/public/student_government/images/ribbon.png) repeat-x; font-family: Arial, Helvetica, sans-serif; font-size: 16px; padding-top: 15px;\" width=\"100%\">
<tr>
<td rowspan=\"2\" style=\"padding-right: 15px;\" valign=\"top\" width=\"250\">
<div align=\"center\"><img alt=\"" . htmlentities(stripslashes($book['title'])) . " Cover - Please enable viewing images to see this picture\" height=\"200\" src=\"" . htmlentities(stripslashes($book['imageURL'])) . "\" style=\"max-height: 200px;\"></div>
<h2 style=\"margin-bottom: 0px;\">" . stripslashes($book['title']) . "</h2>
<div style=\"margin-bottom: 15px;\"><span style=\"background-color: #3D3D3D; border: 1px solid #FFFFFF; color: #FFFFFF; display: inline-block; font-size: 15px; margin: 5px 0px 5px 0px; max-width: 187px; padding: 4px 1px 4px 1px; vertical-align: top; white-space: no-wrap; width: auto;\"><span style=\"background: #42B6C9; border: 1px solid #FFFFFF; padding: 2px 7px 2px 7px;\">\$" . stripslashes($book['price']) . "</span></span></div>
<div><span style=\"display: block; font-size: 14px; max-width: 240px; overflow: hidden; padding-top: 5px; text-overflow: ellipsis; white-space: nowrap;\" title=\"ISBN: " . htmlentities(stripslashes($book['ISBN'])) . "\"><strong style=\"display: inline-block; width: 55px;\">ISBN:</strong> " . stripslashes($book['ISBN']) . "</span></div>
<div><span style=\"display: block; font-size: 14px; max-width: 240px; overflow: hidden; padding-top: 5px; text-overflow: ellipsis; white-space: nowrap;\" title=\"Author: " . htmlentities(stripslashes($book['author'])) . "\"><strong style=\"display: inline-block; width: 55px;\">Author:</strong> " . stripslashes($book['author']) . "</span></div>" . (!empty($book['edition']) ? "
<div><span style=\"display: block; font-size: 14px; max-width: 240px; overflow: hidden; padding-top: 5px; text-overflow: ellipsis; white-space: nowrap;\" title=\"Edition: " . htmlentities(stripslashes($book['edition'])) . "\"><strong style=\"display: inline-block; width: 55px;\">Edition:</strong> " . stripslashes($book['edition']) . "</span></div>" : "") . "
</td>

<td style=\"font-size: 18px; padding-bottom: 30px;\">
<strong>" . stripslashes($userData['firstName']) . " " . stripslashes($userData['lastName']) . "</strong> would like to purchase your book <strong>" . stripslashes($book['title']) . "</strong>.
<div style=\"font-size: 16px; padding-top: 5px;\">" . stripslashes($userData['firstName']) . "'s email: <a href=\"mailto:" . stripslashes($userData['emailAddress1']) . "\" style=\"color: #4BF; text-decoration: none;\">" . stripslashes($userData['emailAddress1']) . "</a></div>
</td>
</tr>

<tr>
<td class=\"content\" valign=\"top\">
<p>Congratulations! You are just two steps away from selling your book:</p>
<ol>
<li>Reply to this email with a <strong>time and location</strong> to meet with " . stripslashes($userData['firstName']) . " to <strong>exchange</strong> the book and funds <strong>in person</strong>.</li>
<li>Go and get your cash!</li>
</ol>

<div style=\"background: #FFCCCD; border: 3px solid #FF9999; margin: 30px 10% 0px 10%; padding: 7px; width: 80%;\">This book is now considered sold and has been automatically removed from the book exchange. If you choose to not sell this book to " . stripslashes($userData['firstName']) . ", you may login at any time and restore this book to the exchange with one click under the &quot;My Account&quot; tab.</div>
</td>
</tr>

<tr>
<td colspan=\"2\" style=\"text-align: right;\"><hr>
<table border=\"0\" width=\"100%\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 16px;\">
<tr>
<td>
<div align=\"right\">
<div>Thank you, we hope that was easy!</div>
<br>
<div style=\"font-size: 12px; padding-top: 10px;\">~ The Student Government Association</div>
</div>
</td>

<td width=\"150\"><img alt=\"SGA Logo - Please enable viewing images to see this picture\" src=\"" . $root . "images/banner.png\"></td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>";
	
	$altBody = stripslashes($userData['firstName']) . " " . stripslashes($userData['lastName']) . " would like to purchase your book " . stripslashes($book['title']) . ".
	
" . stripslashes($userData['firstName']) . "'s email: " . stripslashes($userData['emailAddress1']) . "
	
|**************************************************
|  BOOK INFORMATION
|
|  Title:    " . stripslashes($book['title']) . "
|  Price:     \$" . stripslashes($book['price']) . "
|  ISBN:     " . stripslashes($book['ISBN']) . "
|  Author:   " . stripslashes($book['author']) . (!empty($book['edition']) ? "
|  Edition:  " . stripslashes($book['edition']) . "
|**************************************************" : "
|**************************************************") . "
	
Congratulations! You are just two steps away from selling your book:
 
 - 1. Reply to this email with a time and location to meet with " . stripslashes($userData['firstName']) . " to exchange the book and funds in person.
 - 2. Go and get your cash!
 
|**************************************************
|  This book is now considered sold and has been automatically removed from the book exchange. If you choose
|  to not sell this book to " . stripslashes($userData['firstName']) . ", you may login at any time and restore this
|  book to the exchange with one click under the \"My Account\" tab.
|**************************************************

Thank you, we hope that was easy!
~ The Student Government Association";
	
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
		$mail->Subject = $subject;
		$mail->AltBody = $altBody;
		$mail->MsgHTML($bodyHTML);
		$mail->Send();
		
		echo "success";
	} catch (phpmailerException $e) {
		echo $e->errorMessage();
		exit;
	} catch (Exception $e) {
		echo $e->getMessage();
		exit;
	}
	
//Mark the book as sold
	mysql_query("UPDATE books SET sold = '1' WHERE linkID = '{$book['linkID']}'", $connDBA);
	
//Log this purchase in the purchases database
	$buyerID = $userData['id'];
	$sellerID = $seller['id'];
	$bookID = $_GET['id'];
	$time = strtotime("now");
	
	mysql_query("INSERT INTO purchases (
				 	id, buyerID, sellerID, bookID, time
				 ) VALUES (
				 	NULL, '{$buyerID}', '{$sellerID}', '{$bookID}', '{$time}'
				 )", $connDBA);
?>