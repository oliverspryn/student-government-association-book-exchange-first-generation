<?php
	require_once("Connections/connDBA.php");

	if (isset($_GET['accessCode']) && urldecode($_GET['accessCode']) == "rootintootin_1402516701057871581555") {
		$booksGrabber = mysql_query("SELECT * FROM books WHERE awaitingImage != '' GROUP BY imageID", $connDBA);
		
	//Process the form
		if (isset($_POST['verify'])) {
			$SQL = "";
			
			foreach($_POST['verify'] as $cover) {
				$SQL .= " OR `imageID` = '{$cover}'";
			}
			
			$SQL = ltrim($SQL, " OR ");
			
			mysql_query("UPDATE books SET imageURL = awaitingImage WHERE {$SQL}", $connDBA);
			mysql_query("UPDATE books SET awaitingImage = '' WHERE {$SQL}", $connDBA);
			redirect($_SERVER['REQUEST_URI']);
		}
		
		if (isset($_POST['inappropriate'])) {
			$SQL = "";
			$URL = $root . "book-exchange/system/images/icons/inappropriate_book.png";
			
			foreach($_POST['inappropriate'] as $cover) {
				$SQL .= " OR `imageID` = '{$cover}'";
			}
			
			$SQL = ltrim($SQL, " OR ");
			
			mysql_query("UPDATE books SET imageURL = '{$URL}' WHERE {$SQL}", $connDBA);
			mysql_query("UPDATE books SET awaitingImage = '' WHERE {$SQL}", $connDBA);
		}
		
		if (isset($_POST['none'])) {
			$SQL = "";
			$URL = $root . "book-exchange/system/images/icons/no_cover.png";
			
			foreach($_POST['none'] as $cover) {
				$SQL .= " OR `imageID` = '{$cover}'";
			}
			
			$SQL = ltrim($SQL, " OR ");
			
			mysql_query("UPDATE books SET imageURL = '{$URL}' WHERE {$SQL}", $connDBA);
			mysql_query("UPDATE books SET awaitingImage = '' WHERE {$SQL}", $connDBA);
		}
		
		if (isset($_POST['new']) && isset($_POST['id'])) {
			$id = $_POST['id'];
			$URL = $_POST['new'];
			
			for ($i = 0; $i <= count($id) - 1; $i++) {
				if ($URL[$i] != "") {
					mysql_query("UPDATE books SET imageURL = '{$URL[$i]}' WHERE `imageID` = '{$id[$i]}'", $connDBA);
					mysql_query("UPDATE books SET awaitingImage = '' WHERE `imageID` = '{$id[$i]}'", $connDBA);
				}
			}
		}
		
		if (isset($_POST['verify']) || isset($_POST['inappropriate']) || isset($_POST['none']) || isset($_POST['new'])) {
			redirect($_SERVER['REQUEST_URI']);
		}
	} else {
		die("failsauce");	
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Verify Book Cover</title>
</head>

<body>
<h1>Verify Book Cover</h1>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<table>
<tbody>
<?php
	while($book = mysql_fetch_assoc($booksGrabber)) {
		echo "
<tr>
<td style=\"padding: 10px;\" valign=\"top\">
<strong><label for=\"" . $book['imageID'] . "_approve\">" . stripslashes($book['title']) . "<br>ISBN: " . $book['ISBN'] . "</label></strong>
<br><br>

<label><input id=\"" . $book['imageID'] . "_approve\" type=\"checkbox\" name=\"verify[]\" value=\"" . $book['imageID'] . "\" /> Accept</label>
<br>
<label><input id=\"" . $book['imageID'] . "_inappropriate\" type=\"checkbox\" name=\"inappropriate[]\" value=\"" . $book['imageID'] . "\" /> Inappropriate</label>
<br>
<label><input id=\"" . $book['imageID'] . "_none\" type=\"checkbox\" name=\"none[]\" value=\"" . $book['imageID'] . "\" /> No Cover Avalilable</label>
<br>
Suggest new cover: <input id=\"" . $book['imageID'] . "_new\" type=\"text\" name=\"new[]\" />
<input name=\"id[]\" type=\"hidden\" value=\"" . $book['imageID'] . "\" />
</td>

<td style=\"padding: 10px;\"><label for=\"" . $book['imageID'] . "_approve\"><img src=\"" . $book['awaitingImage'] . "\" /></label></td>
</tr>
";
	}
?>
</tbody>
</table>

<input type="submit" />
</form>
</body>
</html>