<?php
//Include the system core
	require_once('Connections/connDBA.php'); 
	
//Check to see if any pages exist
	$settingsGrabber = mysql_query("SELECT * FROM `privileges` WHERE `id` = '1'", $connDBA);
	$settings = mysql_fetch_array($settingsGrabber);
	$pagesExistGrabber = mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA);
	
	$pagesExistArray = mysql_fetch_array($pagesExistGrabber);
	$pagesExistResult = $pagesExistArray['position'];
	
	if (isset ($pagesExistResult)) {
		$pagesExist = 1;
	} else {
		$pagesExist = 0;
	}
	
//Block access to unpublished pages
	if (isset ($_GET['page'])) {
		$pageAccessGrabber = mysql_query("SELECT * FROM pages WHERE `id` = '{$_GET['page']}'");
		$pageAccess = mysql_fetch_array($pageAccessGrabber);
		
		if ($pageAccess['published'] == "0") {
			header("Location: index.php");
			exit;
		}
	}
	
//If no page URL variable is defined, then choose the home page
	if (!isset ($_GET['page'])) {
	//Grab the page data
		$pageInfoPrep = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE position = '1' AND `published` != '0'", $connDBA));
		$pageInfo = unserialize($pageInfoPrep['content' . $pageInfoPrep['display']]);
		
	//Hide the admin menu if an incorrect page displays		
		if ($pagesExist == "1") {
			$privilegesCheckGrabber = mysql_query("SELECT * FROM privileges WHERE id = '1'", $connDBA);
			$privilegesCheck = mysql_fetch_array($privilegesCheckGrabber);
			
			if ($pageInfoPrep['published'] == "0") {
				$pageCheck = 0;
			} else {
				$pageCheck = 1;
			}
		} else {
			$pageCheck = 0;
		}
		
	} elseif (isset ($_GET['page']) && ($_GET['page'] == "" || !is_numeric($_GET['page']))) {
		header("Location:index.php");
		exit;
	} else {		
	//Grab the page data
		$getPageID = $_GET['page'];
		$pageInfoPrep = mysql_fetch_array(mysql_query("SELECT * FROM pages WHERE id = {$getPageID}", $connDBA));
		$pageInfo = unserialize($pageInfoPrep['content' . $pageInfoPrep['display']]);
		
	//Hide the admin menu if an incorrect page displays
		$pageCheckGrabber = mysql_query("SELECT * FROM pages WHERE id = {$getPageID}", $connDBA);
		$pageCheckArray = mysql_fetch_array($pageCheckGrabber);
		$pageCheckResult = $pageCheckArray['position'];
		
		if (isset ($pageCheckResult)) {
			$privilegesCheckGrabber = mysql_query("SELECT * FROM privileges WHERE id = '1'", $connDBA);
			$privilegesCheck = mysql_fetch_array($privilegesCheckGrabber);
			
			if ($pageCheckArray['published'] == "0") {
				$pageCheck = 0;
			} else {
				$pageCheck = 1;
			}
		} else {
			$pageCheck = 0;
		}	
	}
	
//Grab the sidebar	
	$sideBarCheck = mysql_query("SELECT * FROM sidebar WHERE visible = 'on' AND published != '0'", $connDBA);
	$sideBarResult = mysql_fetch_array($sideBarCheck);
?>
<?php
	if ($pageInfoPrep == 0 && $pagesExist == 0) {
		$title = "Setup Required";
		
		if (!isset($_SESSION['MM_Username'])) {
			$content = "Please <a href=\"login.php\">login</a> to create your first page.";
		} else {
			$content = "Please <a href=\"admin/cms/manage_page.php\">create your first page</a>.";
		}
	} elseif ($pageInfoPrep == 0 && $pagesExist == 1) {
		$title = "Page Not Found";
		$content = "<p>The page you are looking for was not found on our system</p><p>&nbsp;</p><p align=\"center\"><input type=\"button\" name=\"continue\" id=\"continue\" value=\"Continue\" onclick=\"history.go(-1)\" /></p>";
	} else {
		$title = $pageInfo['title'];
		$content = $pageInfo['content'];
		$commentsDisplay = $pageInfo['comments'];
	}
	
//Build the dynamic breadcrumb :(
	$breadcrumbGrabber = mysql_query("SELECT * FROM pages", $connDBA);
	$pagesArray = array();
	
//Assign the ID of each page to its own key of the array for the algorithm after this step
	while($breadcrumb = mysql_fetch_array($breadcrumbGrabber)) {
		$pagesArray[$breadcrumb['id']] = $breadcrumb;
	}
	
/**
 * This algorithm uses the array, was generated in the previous step,
 * to create a breadcrumb navigator. The previous step extraced every
 * page from the database and placed it in an array, each having a key
 * whose value is the same as the page ID in the database.
 * 
 * Here is the process used to generate the breadcrumb navigator:
 *  [1] Start with the array element whose key is the same as the
 *      "page" parameter in the URL.
 *  [2] Generate the HTML for the list item, containing the text of
 *      the current page's title. Do not generate a link for this 
 *      list item since this is the current page. Push this generated
 *      value onto the $breadcrumbContainer array.
 *  [3] Check and see if this page has a "parentPage" (i.e.: if this
 *      value is not 0). If so, navigate to the array element whose key
 *      equals the value of "parentPage".
 *  [4] Generate the HTML for the list item, containing the text of
 *      the current page's title and a link to this page. Push this 
 *      generated value onto the $breadcrumbContainer array.
 *  [5] Repeat steps 3 and 4 until "parentPage" has a value of 0, when
 *      no parentPage exists.
 *  [6] Reverse the $breadcrumbContainer array, since it was generated
 *      in reverse of how it should display.
 *  [7] Display the output of the $breadcrumbContainer array.
*/
	
	$counter = 1;
	$breadcrumbContainer = array();
	
//Set the initial value for the page ID tracker
	if(!isset($_GET['page'])) {
		$pageID = $pageInfoPrep['id'];
	} else {
		$pageID = $_GET['page'];
	}
	
	do {		
	//Extract the title
		$rowContent = unserialize($pagesArray[$pageID]['content' . $pagesArray[$pageID]['display']]);
		
	//Generate the list item
		if ($counter == 1 && $pagesArray[$pageID]['parentPage'] == 0) {
			array_push($breadcrumbContainer, "\n<li class=\"noLink\">" . $rowContent['title'] . "</li>\n");
		} elseif ($counter == 1) {
			array_push($breadcrumbContainer, "\n<li>" . $rowContent['title'] . "</li>\n");
		} else {
			array_push($breadcrumbContainer, "\n<li><a href=\"index.php?page=" . $pagesArray[$pageID]['id'] . "\">" . $rowContent['title'] . "</a></li>");
		}
		
	//Does a parent page exist?
		if ($pagesArray[$pageID]['parentPage'] == 0) {
			break;
		} else {
			$pageID = $pagesArray[$pageID]['parentPage'];
			$counter ++;
		}
	} while(true);
	
//Reverse the array
	$breadcrumbContainer = array_reverse($breadcrumbContainer);
	
//Convert the array to a string
	$breadcrumb = "";
	
	foreach($breadcrumbContainer as $item) {
		$breadcrumb .= $item;
	}
?>
<?php
	topPage("public", $title, "", "", "", $breadcrumb);
?>
<?php
//Display the title
	echo "<header>\n<h1 class=\"title\">" . $title . "</h1>\n</header>\n\n";

//Use the layout control if the page is displaying a sidebar
	$sideBarLocationGrabber = mysql_query("SELECT * FROM siteprofiles WHERE id = '1'", $connDBA);
	$sideBarLocation = mysql_fetch_array($sideBarLocationGrabber);
	
	if (!isset($_GET['page']) || empty($_GET['page'])) {
		$idPrep = query("SELECT * FROM `pages` WHERE `position` = '1'");
		$id = $idPrep['id'];
	} else {
		$id = $_GET['page'];
	}
	
//Create a function to test for navigation needs
	function hasParents() {
		global $id;
		
		$parentPage = query("SELECT * FROM `pages` WHERE `id` = '{$id}'");
		
		if (query("SELECT * FROM `pages` WHERE `id` = '{$parentPage['parentPage']}' AND `visible` = 'on' AND `published` != '0'")) {
			return true;
		} else {
			return false;
		}
	}
	
	function hasChildren() {
		global $id;
		
		if (query("SELECT * FROM `pages` WHERE `parentPage` = '{$id}' AND `visible` = 'on' AND `published` != '0'")) {
			return true;
		} else {
			return false;
		}
	}
	
	if ($sideBarResult || hasChildren() || hasParents() && $pageInfoPrep !== 0 && $pagesExist == 1) {
		if ($sideBarLocation['sideBar'] == "Left") {
			$sideBarLoc = "left";
			$bodyLoc = " right";
		} else {
			$sideBarLoc = "right";
			$bodyLoc = " left";
		}
	} else {
		$bodyLoc = "";
	}
	
//Display the page content	
	echo "<section class=\"body" . $bodyLoc . "\">\n" . stripslashes($content) . "\n</section>\n";
	
//Display the sidebar	
	if ($sideBarResult || hasChildren() || hasParents() && $pageInfoPrep !== 0 && $pagesExist == 1) {
		$sideBarCheck = mysql_query("SELECT * FROM sidebar WHERE visible = 'on' AND published != '0' ORDER BY `position` ASC", $connDBA);
		
		echo "\n<aside class=\"sidebar ";
		
		if ($sideBarLocation['sideBar'] == "Left") {
			echo "left";
		} else {
			echo "right";
		}
		
		echo "\">\n";
		
		if (hasChildren() || hasParents() && $pageInfoPrep !== 0 && $pagesExist == 1) {			
			echo "<section class=\"menu\">\n<ul>\n";
			
			$pagesGrabber = query("SELECT * FROM `pages` WHERE `id` = '{$id}'");
			$topLevel = query("SELECT * FROM `pages` WHERE `id` = '{$pagesGrabber['parentPage']}'");
			$parentLevel = query("SELECT * FROM `pages` WHERE `parentPage` = '{$pagesGrabber['parentPage']}'");
			$childPagesGrabber = query("SELECT * FROM `pages` WHERE `parentPage` = '{$pagesGrabber['id']}' AND `visible` = 'on' AND `published` != '0' ORDER BY `subPosition` ASC", "raw");
			
			if ($pagesGrabber['parentPage'] !== "0") {
				$topTitle = unserialize($topLevel['content' . $topLevel['display']]);
				
				echo "<li class=\"up\"><a href=\"index.php?page=" . $pagesGrabber['parentPage'] . "\">Back up to &quot;" . prepare($topTitle['title']) . "&quot;</a></li>\n";
			}
			
			if (query("SELECT * FROM `pages` WHERE `parentPage` = '{$pagesGrabber['id']}' AND `visible` = 'on' AND `published` != '0'")) {
				while ($childPages = mysql_fetch_array($childPagesGrabber)) {
					$childTitle = unserialize($childPages['content' . $childPages['display']]);
					
					if ($id == $childPages['id']) {
						echo "<li><strong><a href=\"index.php?page=" . $childPages['id'] . "\">" . prepare($childTitle['title']) . "</a></strong></li>\n";
					} else {
						echo "<li><a href=\"index.php?page=" . $childPages['id'] . "\">" . prepare($childTitle['title']) . "</a></li>\n";
					}
				}
			}
			
			echo "</ul>\n</section>\n";
		}
		
		$counter = 1;
		
		while ($sideBarPrep = mysql_fetch_array($sideBarCheck)) {
			$sideBar = unserialize($sideBarPrep['content' . $sideBarPrep['display']]);
						
			if (!isset($_SESSION['MM_Username']) || (isset($_SESSION['MM_Username']) && privileges("editSideBar") != "true")) {
				echo "\n<section class=\"item" . $counter . "\">\n<h2>" . stripslashes($sideBar['title']) . "</h2>\n" . stripslashes($sideBar['content']) . "\n</section>\n";
			} else {
				echo "\n<section class=\"item" . $counter . "\">\n<h2>" . stripslashes($sideBar['title']) . "&nbsp;<a class=\"smallEdit\" href=\"admin/cms/sidebar/manage_sidebar.php?id=" . $sideBarPrep['id'] . "\"></a></h2>\n" . stripslashes($sideBar['content']) . "\n</section>\n";
			}
			
			$counter ++;
		}
		
		echo "</aside>";
	}
?>
<?php
	stats("true");
	footer("public");
?>