<?php require_once('../../Connections/connDBA.php'); ?>
<?php
	if (privileges("sendEmail") == "true") {
		if ($_SESSION['MM_UserGroup'] == "User") {
			header("Location: email/index.php");
			exit;
		}
		
		loginCheck("Administrator");
	} else {
		loginCheck("Administrator");
	}
?>
<?php
//Check to see if items exist
	$itemCheck = mysql_query("SELECT * FROM collaboration WHERE `position` = 1", $connDBA);
	if (mysql_fetch_array($itemCheck)) {
		$itemGrabber = mysql_query("SELECT * FROM collaboration ORDER BY position ASC", $connDBA);
	} else {
		$itemGrabber = 0;
	}

//Reorder items	
	if (isset ($_GET['action']) && $_GET['action'] == "modifySettings" && isset($_GET['id']) && isset($_GET['position']) && isset($_GET['currentPosition'])) {
	//Grab all necessary data	
	  //Grab the id of the moving item
	  $id = $_GET['id'];
	  //Grab the new position of the item
	  $newPosition = $_GET['position'];
	  //Grab the old position of the item
	  $currentPosition = $_GET['currentPosition'];
		  
	  //Do not process if item does not exist
	  //Get item name by URL variable
	  $getItemID = $_GET['position'];
  
	  $itemCheckGrabber = mysql_query("SELECT * FROM items WHERE position = {$getItemID}", $connDBA);
	  $itemCheckArray = mysql_fetch_array($itemCheckGrabber);
	  $itemCheckResult = $itemCheckArray['position'];
		   if (isset ($itemCheckResult)) {
			   $itemCheck = 1;
		   } else {
			  $itemCheck = 0;
		   }
	
	//If the item is moved up...
		if ($currentPosition > $newPosition) {
		//Update the other items first, by adding a value of 1
			$otherPostionReorderQuery = "UPDATE collaboration SET position = position + 1 WHERE position >= '{$newPosition}' AND position <= '{$currentPosition}'";
			
		//Update the requested item	
			$currentItemReorderQuery = "UPDATE collaboration SET position = '{$newPosition}' WHERE id = '{$id}'";
			
		//Execute the queries
			$otherPostionReorder = mysql_query($otherPostionReorderQuery, $connDBA);
			$currentItemReorder = mysql_query ($currentItemReorderQuery, $connDBA);
	
		//No matter what happens, the user will see the updated result on the editing screen. So, just redirect back to that page when done.
			header ("Location: index.php");
			exit;
	//If the item is moved down...
		} elseif ($currentPosition < $newPosition) {
		//Update the other items first, by subtracting a value of 1
			$otherPostionReorderQuery = "UPDATE collaboration SET position = position - 1 WHERE position <= '{$newPosition}' AND position >= '{$currentPosition}'";
	
		//Update the requested item		
			$currentItemReorderQuery = "UPDATE collaboration SET position = '{$newPosition}' WHERE id = '{$id}'";
		
		//Execute the queries
			$otherPostionReorder = mysql_query($otherPostionReorderQuery, $connDBA);
			$currentItemReorder = mysql_query ($currentItemReorderQuery, $connDBA);
			
		//No matter what happens, the user will see the updated result on the editing screen. So, just redirect back to that page when done.
			header ("Location: index.php");
			exit;
		}
	}

//Set item avaliability
	if (isset($_POST['id']) && $_POST['action'] == "setAvaliability") {
		$id = $_POST['id'];
		
		if (!$_POST['option']) {
			$option = "";
		} else {
			$option = $_POST['option'];
		}
		
		$setAvaliability = "UPDATE collaboration SET `visible` = '{$option}' WHERE id = '{$id}'";
		mysql_query($setAvaliability, $connDBA);
		
		echo "success";
		exit;
	}
	
//Delete an item
	if (isset ($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['item']) && isset($_GET['id'])) {
		//Do not process if item does not exist
		//Get item name by URL variable
		$getItemID = $_GET['item'];
	
		$itemCheckGrabber = mysql_query("SELECT * FROM collaboration WHERE position = {$getItemID}", $connDBA);
		$itemCheckArray = mysql_fetch_array($itemCheckGrabber);
		$itemCheckResult = $itemCheckArray['position'];
			 if (isset ($itemCheckResult)) {
				 $itemCheck = 1;
				 $directories = unserialize($itemCheckArray['directories']);
				 
				 while (list($categoryKey, $categoryArray) = each($directories)) {
				 	deleteAll("../files/" . $categoryKey);
				 }
			 } else {
				$itemCheck = 0;
			 }
	 
		if (!isset ($_GET['id']) || $_GET['id'] == 0 || $itemCheck == 0) {
			header ("Location: index.php");
			exit;
		} else {
			$deleteItem = $_GET['id'];
			$itemLift = $_GET['item'];
			
			$itemPositionGrabber = mysql_query("SELECT * FROM collaboration WHERE position = {$itemLift}", $connDBA);
			$itemPositionFetch = mysql_fetch_array($itemPositionGrabber);
			$itemPosition = $itemPositionFetch['position'];
			
			$otherItemsUpdateQuery = "UPDATE collaboration SET position = position-1 WHERE position > '{$itemPosition}'";
			$deleteItemQueryResult = mysql_query($otherItemsUpdateQuery, $connDBA);
			
			$deleteItemQuery = "DELETE FROM collaboration WHERE id = {$deleteItem}";
			$deleteItemQueryResult = mysql_query($deleteItemQuery, $connDBA);
			
			header ("Location: index.php");
			exit;
		}
	}
?>
<?php topPage("admin", "Collaboration", "collaboration", array("collaboration", 1)); ?>
<?php 
	if (isset ($_GET['added']) && $_GET['added'] == "announcement") {successMessage("The announcement was successfully added");}
    if (isset ($_GET['updated']) && $_GET['updated'] == "announcement") {successMessage("The announcement was successfully updated");}
	if (isset ($_GET['added']) && $_GET['added'] == "agenda") {successMessage("The agenda was successfully added");}
    if (isset ($_GET['updated']) && $_GET['updated'] == "agenda") {successMessage("The agenda was successfully updated");}
	if (isset ($_GET['added']) && $_GET['added'] == "files") {successMessage("The file share was successfully added");}
    if (isset ($_GET['updated']) && $_GET['updated'] == "files") {successMessage("The file share was successfully updated");}
	if (isset ($_GET['added']) && $_GET['added'] == "poll") {successMessage("The poll was successfully added");}
    if (isset ($_GET['updated']) && $_GET['updated'] == "poll") {successMessage("The poll was successfully updated");}
	if (isset ($_GET['added']) && $_GET['added'] == "forum") {successMessage("The forum was successfully added");}
    if (isset ($_GET['updated']) && $_GET['updated'] == "forum") {successMessage("The forum was successfully updated");}
	if (isset ($_GET['email']) && $_GET['email'] == "success") {successMessage("The email was successfully sent");}
?>
<div class="toolbar">
<button class="button blue" onClick="javascript: document.location.href='manage_announcement.php'">New Announcement</button>
<button class="button blue" onClick="javascript: document.location.href='manage_agenda.php'">New Agenda</button>
<button class="button blue" onClick="javascript: document.location.href='manage_files.php'">New File Share</button>
<button class="button blue" onClick="javascript: document.location.href='manage_poll.php'">New Poll</button>
<button class="button blue" onClick="javascript: document.location.href='manage_forum.php'">New Forum</button>
<button class="button green" onClick="javascript: document.location.href='email/index.php'">Send Email</button>
</div>
<?php
//Table header, only displayed if items exist.
	if ($itemGrabber !== 0) {
	//Provide some data for the time tracker
		$time = getdate();
		
		if (0 < $time['minutes'] && $time['minutes'] < 9) {
			$minutes = "0" . $time['minutes'];
		} else {
			$minutes = $time['minutes'];
		}
		
		$currentTime = $time['hours'] . ":" . $minutes;
		$currentDate = strtotime($time['mon'] . "/" . $time['mday'] . "/" . $time['year'] . " " . $currentTime);
		
	echo "<table class=\"dataTable\">
<tbody>
<tr>
<th width=\"75\">Display</th>
<th width=\"200\">Type</th>
<th width=\"200\">Title</th>
<th>Content</th>
<th width=\"75\">Manage</th>
</tr>";
	//Loop through each item
		while($itemData = mysql_fetch_array($itemGrabber)) {
			echo "<tr";
		//Alternate the color of each row
			if ($itemData['position'] & 1) {echo " class=\"odd\">\n";} else {echo " class=\"even\">\n";}
			
			if ($itemData['fromDate'] != "") {
				$from = strtotime($itemData['fromDate'] . " " . $itemData['fromTime']);
				$to = strtotime($itemData['toDate'] . " " . $itemData['toTime']);
				$fromTimeArray = explode(":", $itemData['fromTime']);
				$toTimeArray = explode(":", $itemData['toTime']);
				
				if ($fromTimeArray['0'] == "00") {
					$showTime = "12:" . $fromTimeArray['1'] . " am";
				} elseif (01 <= $fromTimeArray['0'] &&  $fromTimeArray['0'] <= 11) {
					$showTime = $fromTimeArray['0'] . ":" . $fromTimeArray['1'] . " am";
				} elseif ($fromTimeArray['0'] == "12") {
					$showTime = "12:" . $toTimeArray['1'] . " pm";
				} else {
					$showTime = $fromTimeArray['0'] - 12 . ":" . $fromTimeArray['1'] . " pm";
				}
				
				if ($toTimeArray['0'] == "00") {
					$expiredTime = "12:" . $toTimeArray['1'] . " am";
				} elseif (01 <= $toTimeArray['0'] &&  $toTimeArray['0'] <= 11) {
					$expiredTime = $toTimeArray['0'] . ":" . $toTimeArray['1'] . " am";
				} elseif ($toTimeArray['0'] == "12") {
					$expiredTime = "12:" . $toTimeArray['1'] . " pm";
				} else {
					$expiredTime = $toTimeArray['0'] - 12 . ":" . $toTimeArray['1'] . " pm";
				}
							
				if ($from > $currentDate) {
					echo "<td width=\"75\"><span class=\"tip future\" title=\"This item will display on " . $itemData['fromDate'] . " at " . $showTime . "\"></span>";
				} elseif ($to <= $currentDate) {
					echo "<td width=\"75\"><span class=\"tip expired\" title=\"This item has expired. It was last visible on " . $itemData['toDate'] . " at " . $expiredTime . "\"></span>";
				} else {
					echo "<td width=\"75\"><span class=\"tip now\" title=\"This item is currently being displayed until " . $itemData['toDate'] . " at " . $expiredTime . "\"></span>";
				}
			} else {
				echo "<td width=\"75\">
<span id=\"" .  $itemData['id'] . "\" class=\"tip visibleToggle ";

				if ($itemData['visible'] == "on") {
					echo "display\" title=\"This item is currently being displayed\"";
				} else {
					echo "noDisplay\" title=\"This item is currently hidden\"";
				}
				
				echo "></span>";
			}
			
			echo "<input type=\"hidden\" class=\"currentPosition\" value=\"" .  $itemData['position'] .  "\">
<select class=\"position\" id=\"" . $itemData['id'] . "\">
";
			
			$itemCount = mysql_num_rows($itemGrabber);
			for ($count=1; $count <= $itemCount; $count++) {
				echo "<option value=\"{$count}\"";
				if ($itemData ['position'] == $count) {
					echo " selected=\"selected\"";
				}
				echo ">" . $count . "</option>
";
			}
			
			echo "</select>
</td>
<td width=\"200\">" . $itemData['type'] . "</td>";
			echo "<td width=\"200\">" . commentTrim(30, stripslashes($itemData['title'])) . "</td>";
			echo "<td>" . commentTrim(60, stripslashes($itemData['content'])) . "</td>";
			echo "<td align=\"center\" width=\"75\"><a class=\"edit\" href=\"manage_";
			
			switch ($itemData['type']) {
				case "Agenda" : echo "agenda"; break;
				case "Announcement" : echo "announcement"; break;
				case "File Share" : echo "files"; break;
				case "Poll" : echo "poll"; break;
				case "Forum" : echo "forum"; break;
			}
			
			echo ".php?id=" . $itemData['id'] . "\" ></a>"; 
			
			if ($itemData['type'] == "File Share") {
				echo "<a class=\"delete fileShare\" data-position=\"" . $itemData['position'] . "\" data-id=\"" . $itemData['id'] . "\"></a></td>";
			} else {
				echo "<a class=\"delete\" href=\"index.php?action=delete&item=" . $itemData['position'] . "&id=" . $itemData['id'] . "\"></a></td>";
			}
		}
		
		echo "</tr></tbody></table>";
	 } else {
		echo "<div class=\"spacer\">This site has no items. New items can be created by selecting an item from the tool bar above.</div>";
	 } 
?>
<?php footer("admin"); ?>
