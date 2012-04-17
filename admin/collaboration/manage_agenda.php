<?php require_once('../../Connections/connDBA.php'); ?>
<?php loginCheck("Administrator"); ?>
<?php
//Check to see if the agenda is being edited
	if (isset ($_GET['id'])) {
		$agenda = $_GET['id'];
		$agendaCheck = mysql_query("SELECT * FROM `collaboration` WHERE `id` = '{$agenda}'", $connDBA);
		if ($agenda = mysql_fetch_array($agendaCheck)) {
			//Do nothing
		} else {
			header ("Location: index.php");
			exit;
		}
	}
	
//Ensure this is not editing another type than it is intended to handle
	if (isset($agenda)) {
		if ($agenda['type'] != "Agenda") {
			header("Location: index.php");
			exit;
		}
	}
	
//Process the form
	if (isset($_POST['submit']) && !empty ($_POST['title']) && !empty($_POST['assignee']) && !empty($_POST['task']) && !empty($_POST['dueDate']) && !empty($_POST['priority'])) {	
		if (!isset ($agenda)) {
		//Reorder and cleanup the assignee list
			$assigneePrep = array();
			
			foreach($_POST['assignee'] as $array) {
				$array = rtrim($array, ", ");
				$array = explode(", ", $array);
				sort($array);
				array_push($assigneePrep, implode(", ", $array));
			}
			
			$assignee = mysql_real_escape_string(serialize($assigneePrep));
			
			$title = mysql_real_escape_string($_POST['title']);
			$fromDate = $_POST['from'];
			$fromTime = $_POST['fromTime'];
			$toDate = $_POST['to'];
			$toTime = $_POST['toTime'];
			$content = mysql_real_escape_string($_POST['content']);
			$task = mysql_real_escape_string(serialize($_POST['task']));
			$description = mysql_real_escape_string(serialize($_POST['description']));
			$dueDate = mysql_real_escape_string(serialize($_POST['dueDate']));
			$priority = mysql_real_escape_string(serialize($_POST['priority']));
		
		//Ensure times are not inferior, the dates are the same, and all dates are set
			if (empty($fromDate) || empty($toDate) || empty($_POST['toggleAvailability'])) {
				$fromDate = "";
				$fromTime = "";
				$toDate = "";
				$toTime = "";
			}
			
			if ($fromDate == $toDate && !empty($fromDate) && !empty($toDate)) {
				$fromTimeArray = explode(":", $fromTime);
				$toTimeArray = explode(":", $toTime);
				
				if ($fromTime == $toTime) {
					$fromDate = "";
					$fromTime = "";
					$toDate = "";
					$toTime = "";
					$redirect = "Location: manage_agenda.php?message=inferior";
				}
				
				if ($toTimeArray[0] < $fromTimeArray[0]) {
					$fromDate = "";
					$fromTime = "";
					$toDate = "";
					$toTime = "";
					$redirect = "Location: manage_agenda.php?message=inferior";
				} elseif ($toTimeArray[0] == $fromTimeArray[0]) {					
					if ($toTimeArray[1] < $fromTimeArray[1]) {
						$fromDate = "";
						$fromTime = "";
						$toDate = "";
						$toTime = "";
						$redirect = "Location: manage_agenda.php?message=inferior";
					}
				} else {
					$redirect = "Location: index.php?added=agenda";
				}
			} else {
				$redirect = "Location: index.php?added=agenda";
			}
			
			$positionGrabber = mysql_query ("SELECT * FROM `collaboration` ORDER BY position DESC", $connDBA);
			$positionArray = mysql_fetch_array($positionGrabber);
			$position = $positionArray{'position'}+1;
				
			$newAgendaQuery = "INSERT INTO collaboration (
								`id`, `position`, `visible`, `type`, `fromDate`, `fromTime`, `toDate`, `toTime`, `title`, `content`, `assignee`, `task`, `description`, `dueDate`, `priority`, `completed`, `directories`, `name`, `date`, `comment`
							) VALUES (
								NULL, '{$position}', 'on', 'Agenda', '{$fromDate}', '{$fromTime}', '{$toDate}', '{$toTime}', '{$title}', '{$content}', '{$assignee}', '{$task}', '{$description}', '{$dueDate}', '{$priority}', '', '', '', '', ''
							)";
							
			mysql_query($newAgendaQuery, $connDBA);
			
			if ($redirect == "Location: manage_agenda.php?message=inferior") {
				$redirectIDGrabber = mysql_query("SELECT * FROM `collaboration` WHERE `title` = '{$title}' AND `content` = '{$content}' AND `type` = 'Agenda' LIMIT 1", $connDBA);
				$redirectID = mysql_fetch_array($redirectIDGrabber);
				$redirect .= "&id=" . $redirectID['id'];
			}
			
			header ($redirect);
			exit;
		} else {
		//Reorder and cleanup the assignee list
			$assigneePrep = array();
			
			foreach($_POST['assignee'] as $array) {
				$array = rtrim($array, ", ");
				$array = explode(", ", $array);
				sort($array);
				array_push($assigneePrep, implode(", ", $array));
			}
			
			$assignee = mysql_real_escape_string(serialize($assigneePrep));
			
			$agenda = $_GET['id'];
			$title = mysql_real_escape_string($_POST['title']);
			$fromDate = $_POST['from'];
			$fromTime = $_POST['fromTime'];
			$toDate = $_POST['to'];
			$toTime = $_POST['toTime'];
			$content = mysql_real_escape_string($_POST['content']);
			$task = mysql_real_escape_string(serialize($_POST['task']));
			$description = mysql_real_escape_string(serialize($_POST['description']));
			$dueDate = mysql_real_escape_string(serialize($_POST['dueDate']));
			$priority = mysql_real_escape_string(serialize($_POST['priority']));
			
		//Ensure times are not inferior, the dates are the same, and all dates are set
			if (empty($fromDate) || empty($toDate) || empty($_POST['toggleAvailability'])) {
				$fromDate = "";
				$fromTime = "";
				$toDate = "";
				$toTime = "";
			}
			
			if ($fromDate == $toDate && !empty($fromDate) && !empty($toDate)) {
				$id = $_GET['id'];
				$type = $_GET['type'];
				$fromTimeArray = explode(":", $fromTime);
				$toTimeArray = explode(":", $toTime);
				
				if ($fromTime == $toTime) {
					$fromDate = "";
					$fromTime = "";
					$toDate = "";
					$toTime = "";
					$redirect = "Location: manage_agenda.php?message=inferior&id=" . $id;
				}
				
				if ($toTimeArray[0] < $fromTimeArray[0]) {
					$fromDate = "";
					$fromTime = "";
					$toDate = "";
					$toTime = "";
					$redirect = "Location: manage_agenda.php?message=inferior&id=" . $id;
				} elseif ($toTimeArray[0] == $fromTimeArray[0]) {
					if ($toTimeArray[1] < $fromTimeArray[1]) {
						$fromDate = "";
						$fromTime = "";
						$toDate = "";
						$toTime = "";
						$redirect = "Location: manage_agenda.php?message=inferior&id=" . $id;
					}
				} else {
					$redirect = "Location: index.php?updated=agenda";
				}
			} else {
				$redirect = "Location: index.php?updated=agenda";
			}
			
		//Delete old agenda statuses			
			if (!empty($_POST['removeData']) || is_numeric($_POST['removeData'])) {
				$oldAgenda = query("SELECT * FROM `collaboration` WHERE `id` = '{$agenda}'");
				$completed = unserialize($oldAgenda['completed']);
				$removeData = explode(",", $_POST['removeData']);
				sort($removeData);
				
				for($count = 0; $count <= sizeof($removeData) - 1; $count ++) {
					unset($completed[$removeData[$count]]);
				}
				
				$completed = mysql_real_escape_string(serialize(array_merge($completed)));
				$editAgendaQuery = "UPDATE collaboration SET `fromDate` = '{$fromDate}', `fromTime` = '{$fromTime}', `toDate` = '{$toDate}', `toTime` = '{$toTime}', `title` = '{$title}', `content` = '{$content}', `assignee` = '{$assignee}', `task` = '{$task}', `description` = '{$description}', `dueDate` = '{$dueDate}', `priority` = '{$priority}', `completed` = '{$completed}' WHERE `id` = '{$agenda}'";
			} else {
				$editAgendaQuery = "UPDATE collaboration SET `fromDate` = '{$fromDate}', `fromTime` = '{$fromTime}', `toDate` = '{$toDate}', `toTime` = '{$toTime}', `title` = '{$title}', `content` = '{$content}', `assignee` = '{$assignee}', `task` = '{$task}',  `description` = '{$description}', `dueDate` = '{$dueDate}', `priority` = '{$priority}' WHERE `id` = '{$agenda}'";
			}
			
			mysql_query($editAgendaQuery, $connDBA);
			
			header ($redirect);
			exit;
		}
	} 
?>
<?php 
	if (isset ($agenda)) {
		$title = "Edit " . stripslashes(htmlentities($agenda['title']));
	} else {
		$title =  "New Agenda";
	}
	
	title($title); 
?>
<?php topPage("admin", $title, "collaboration", array("collaboration", 3), "<script src=\"../../tiny_mce/tiny_mce.js\"></script>
<script src=\"../../javascripts/common/tiny_mce_simple.php\"></script>
<script src=\"../../javascripts/jQuery/agendaAssist.jquery.php\"></script>"); ?>
<?php
//Display error messages
	if (isset($_GET['message']) && $_GET['message'] == "inferior") {
		errorMessage("The start time can not be inferior to or the same as the end time");
	} else {
		echo "<p>&nbsp;</p>";
	}
?>
    <form action="manage_agenda.php<?php 
		if (isset ($agenda)) {
			echo "?id=" . $agenda['id'];
		}
	?>" method="post" name="manageAgenda" id="validate" onsubmit="return errorsOnSubmit(this);">
<table width="100%">
<tbody>
<tr>
<td class="label">Title</td>
<td><input name="title" type="text" id="title" size="50" autocomplete="off" class="validate[required]"<?php
            	if (isset ($agenda)) {
					echo " value=\"" . stripslashes(htmlentities($agenda['title'])) . "\"";
				}
			?> /></td>
</tr>
<tr>
<td class="label">Availability</td>
<td>
<input name="from" type="text" id="from" readonly="readonly"<?php
            	if (isset ($agenda)) {
					echo " value=\"" . stripslashes(htmlentities($agenda['fromDate'])) . "\"";
				}
				
				if (isset ($agenda) && $agenda['fromDate'] == "") {
					echo " disabled=\"disabled\"";
				} elseif (!isset($agenda)) {
					echo " disabled=\"disabled\"";
				}
			?> />
            <select name="fromTime" id="fromTime"<?php if (isset ($agenda) && $agenda['fromTime'] == "") {echo " disabled=\"disabled\"";} elseif (!isset($agenda)) {echo " disabled=\"disabled\"";} ?>>
            <option value="00:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "00:00") {echo " selected=\"selected\"";} ?>>12:00 am</option>
            <option value="00:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "00:30") {echo " selected=\"selected\"";} ?>>12:30 am</option>
            <option value="01:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "01:00") {echo " selected=\"selected\"";} ?>>1:00 am</option>
            <option value="01:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "01:30") {echo " selected=\"selected\"";} ?>>1:30 am</option>
            <option value="02:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "02:00") {echo " selected=\"selected\"";} ?>>2:00 am</option>
            <option value="02:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "02:30") {echo " selected=\"selected\"";} ?>>2:30 am</option>
            <option value="03:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "03:00") {echo " selected=\"selected\"";} ?>>3:00 am</option>
            <option value="03:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "03:30") {echo " selected=\"selected\"";} ?>>3:30 am</option>
            <option value="04:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "04:00") {echo " selected=\"selected\"";} ?>>4:00 am</option>
            <option value="04:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "04:30") {echo " selected=\"selected\"";} ?>>4:30 am</option>
            <option value="05:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "05:00") {echo " selected=\"selected\"";} ?>>5:00 am</option>
            <option value="05:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "05:30") {echo " selected=\"selected\"";} ?>>5:30 am</option>
            <option value="06:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "06:00") {echo " selected=\"selected\"";} ?>>6:00 am</option>
            <option value="06:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "06:30") {echo " selected=\"selected\"";} ?>>6:30 am</option>
            <option value="07:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "07:00") {echo " selected=\"selected\"";} ?>>7:00 am</option>
            <option value="07:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "07:30") {echo " selected=\"selected\"";} ?>>7:30 am</option>
            <option value="08:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "08:00") {echo " selected=\"selected\"";} ?>>8:00 am</option>
            <option value="08:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "08:30") {echo " selected=\"selected\"";} ?>>8:30 am</option>
            <option value="09:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "09:00") {echo " selected=\"selected\"";} ?>>9:00 am</option>
            <option value="09:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "09:30") {echo " selected=\"selected\"";} ?>>9:30 am</option>
            <option value="10:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "10:00") {echo " selected=\"selected\"";} ?>>10:00 am</option>
            <option value="10:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "10:30") {echo " selected=\"selected\"";} ?>>10:30 am</option>
            <option value="11:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "11:00") {echo " selected=\"selected\"";} ?>>11:00 am</option>
            <option value="11:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "11:30") {echo " selected=\"selected\"";} ?>>11:30 am</option>
            <option value="12:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "12:00") {echo " selected=\"selected\"";} elseif (!isset ($agenda)) {echo " selected=\"selected\"";} elseif ($agenda['fromTime'] == "") {echo " selected=\"selected\"";} ?>>12:00 pm</option>
            <option value="12:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "12:30") {echo " selected=\"selected\"";} ?>>12:30 pm</option>
            <option value="13:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "13:00") {echo " selected=\"selected\"";} ?>>1:00 pm</option>
            <option value="13:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "13:30") {echo " selected=\"selected\"";} ?>>1:30 pm</option>
            <option value="14:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "14:00") {echo " selected=\"selected\"";} ?>>2:00 pm</option>
            <option value="14:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "14:30") {echo " selected=\"selected\"";} ?>>2:30 pm</option>
            <option value="15:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "15:00") {echo " selected=\"selected\"";} ?>>3:00 pm</option>
            <option value="15:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "15:30") {echo " selected=\"selected\"";} ?>>3:30 pm</option>
            <option value="16:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "16:00") {echo " selected=\"selected\"";} ?>>4:00 pm</option>
            <option value="16:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "16:30") {echo " selected=\"selected\"";} ?>>4:30 pm</option>
            <option value="17:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "17:00") {echo " selected=\"selected\"";} ?>>5:00 pm</option>
            <option value="17:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "17:30") {echo " selected=\"selected\"";} ?>>5:30 pm</option>
            <option value="18:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "18:00") {echo " selected=\"selected\"";} ?>>6:00 pm</option>
            <option value="18:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "18:30") {echo " selected=\"selected\"";} ?>>6:30 pm</option>
            <option value="19:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "19:00") {echo " selected=\"selected\"";} ?>>7:00 pm</option>
            <option value="19:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "19:30") {echo " selected=\"selected\"";} ?>>7:30 pm</option>
            <option value="20:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "20:00") {echo " selected=\"selected\"";} ?>>8:00 pm</option>
            <option value="20:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "20:30") {echo " selected=\"selected\"";} ?>>8:30 pm</option>
            <option value="21:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "21:00") {echo " selected=\"selected\"";} ?>>9:00 pm</option>
            <option value="21:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "21:30") {echo " selected=\"selected\"";} ?>>9:30 pm</option>
            <option value="22:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "22:00") {echo " selected=\"selected\"";} ?>>10:00 pm</option>
            <option value="22:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "22:30") {echo " selected=\"selected\"";} ?>>10:30 pm</option>
            <option value="23:00"<?php if (isset ($agenda) && $agenda['fromTime'] == "23:00") {echo " selected=\"selected\"";} ?>>11:00 pm</option>
            <option value="23:30"<?php if (isset ($agenda) && $agenda['fromTime'] == "23:30") {echo " selected=\"selected\"";} ?>>11:30 pm</option>
          </select>
          to 
          <input type="text" name="to" id="to" readonly="readonly"<?php
            	if (isset ($agenda)) {
					echo " value=\"" . stripslashes(htmlentities($agenda['toDate'])) . "\"";
				}
				
				if (isset ($agenda) && $agenda['toDate'] == "") {
					echo " disabled=\"disabled\"";
				} elseif (!isset($agenda)) {
					echo " disabled=\"disabled\"";
				}
			?> />
          <select name="toTime" id="toTime"<?php if (isset ($agenda) && $agenda['toTime'] == "") {echo " disabled=\"disabled\"";} elseif (!isset($agenda)) {echo " disabled=\"disabled\"";} ?>>
            <option value="00:00"<?php if (isset ($agenda) && $agenda['toTime'] == "00:00") {echo " selected=\"selected\"";} ?>>12:00 am</option>
            <option value="00:30"<?php if (isset ($agenda) && $agenda['toTime'] == "00:30") {echo " selected=\"selected\"";} ?>>12:30 am</option>
            <option value="01:00"<?php if (isset ($agenda) && $agenda['toTime'] == "01:00") {echo " selected=\"selected\"";} ?>>1:00 am</option>
            <option value="01:30"<?php if (isset ($agenda) && $agenda['toTime'] == "01:30") {echo " selected=\"selected\"";} ?>>1:30 am</option>
            <option value="02:00"<?php if (isset ($agenda) && $agenda['toTime'] == "02:00") {echo " selected=\"selected\"";} ?>>2:00 am</option>
            <option value="02:30"<?php if (isset ($agenda) && $agenda['toTime'] == "02:30") {echo " selected=\"selected\"";} ?>>2:30 am</option>
            <option value="03:00"<?php if (isset ($agenda) && $agenda['toTime'] == "03:00") {echo " selected=\"selected\"";} ?>>3:00 am</option>
            <option value="03:30"<?php if (isset ($agenda) && $agenda['toTime'] == "03:30") {echo " selected=\"selected\"";} ?>>3:30 am</option>
            <option value="04:00"<?php if (isset ($agenda) && $agenda['toTime'] == "04:00") {echo " selected=\"selected\"";} ?>>4:00 am</option>
            <option value="04:30"<?php if (isset ($agenda) && $agenda['toTime'] == "04:30") {echo " selected=\"selected\"";} ?>>4:30 am</option>
            <option value="05:00"<?php if (isset ($agenda) && $agenda['toTime'] == "05:00") {echo " selected=\"selected\"";} ?>>5:00 am</option>
            <option value="05:30"<?php if (isset ($agenda) && $agenda['toTime'] == "05:30") {echo " selected=\"selected\"";} ?>>5:30 am</option>
            <option value="06:00"<?php if (isset ($agenda) && $agenda['toTime'] == "06:00") {echo " selected=\"selected\"";} ?>>6:00 am</option>
            <option value="06:30"<?php if (isset ($agenda) && $agenda['toTime'] == "06:30") {echo " selected=\"selected\"";} ?>>6:30 am</option>
            <option value="07:00"<?php if (isset ($agenda) && $agenda['toTime'] == "07:00") {echo " selected=\"selected\"";} ?>>7:00 am</option>
            <option value="07:30"<?php if (isset ($agenda) && $agenda['toTime'] == "07:30") {echo " selected=\"selected\"";} ?>>7:30 am</option>
            <option value="08:00"<?php if (isset ($agenda) && $agenda['toTime'] == "08:00") {echo " selected=\"selected\"";} ?>>8:00 am</option>
            <option value="08:30"<?php if (isset ($agenda) && $agenda['toTime'] == "08:30") {echo " selected=\"selected\"";} ?>>8:30 am</option>
            <option value="09:00"<?php if (isset ($agenda) && $agenda['toTime'] == "09:00") {echo " selected=\"selected\"";} ?>>9:00 am</option>
            <option value="09:30"<?php if (isset ($agenda) && $agenda['toTime'] == "09:30") {echo " selected=\"selected\"";} ?>>9:30 am</option>
            <option value="10:00"<?php if (isset ($agenda) && $agenda['toTime'] == "10:00") {echo " selected=\"selected\"";} ?>>10:00 am</option>
            <option value="10:30"<?php if (isset ($agenda) && $agenda['toTime'] == "10:30") {echo " selected=\"selected\"";} ?>>10:30 am</option>
            <option value="11:00"<?php if (isset ($agenda) && $agenda['toTime'] == "11:00") {echo " selected=\"selected\"";} ?>>11:00 am</option>
            <option value="11:30"<?php if (isset ($agenda) && $agenda['toTime'] == "11:30") {echo " selected=\"selected\"";} ?>>11:30 am</option>
            <option value="12:00"<?php if (isset ($agenda) && $agenda['toTime'] == "12:00") {echo " selected=\"selected\"";} ?>>12:00 pm</option>
            <option value="12:30"<?php if (isset ($agenda) && $agenda['toTime'] == "12:30") {echo " selected=\"selected\"";} ?>>12:30 pm</option>
            <option value="13:00"<?php if (isset ($agenda) && $agenda['toTime'] == "13:00") {echo " selected=\"selected\"";} elseif (!isset ($agenda)) {echo " selected=\"selected\"";} elseif ($agenda['toTime'] == "") {echo " selected=\"selected\"";} ?>>1:00 pm</option>
            <option value="13:30"<?php if (isset ($agenda) && $agenda['toTime'] == "13:30") {echo " selected=\"selected\"";} ?>>1:30 pm</option>
            <option value="14:00"<?php if (isset ($agenda) && $agenda['toTime'] == "14:00") {echo " selected=\"selected\"";} ?>>2:00 pm</option>
            <option value="14:30"<?php if (isset ($agenda) && $agenda['toTime'] == "14:30") {echo " selected=\"selected\"";} ?>>2:30 pm</option>
            <option value="15:00"<?php if (isset ($agenda) && $agenda['toTime'] == "15:00") {echo " selected=\"selected\"";} ?>>3:00 pm</option>
            <option value="15:30"<?php if (isset ($agenda) && $agenda['toTime'] == "15:30") {echo " selected=\"selected\"";} ?>>3:30 pm</option>
            <option value="16:00"<?php if (isset ($agenda) && $agenda['toTime'] == "16:00") {echo " selected=\"selected\"";} ?>>4:00 pm</option>
            <option value="16:30"<?php if (isset ($agenda) && $agenda['toTime'] == "16:30") {echo " selected=\"selected\"";} ?>>4:30 pm</option>
            <option value="17:00"<?php if (isset ($agenda) && $agenda['toTime'] == "17:00") {echo " selected=\"selected\"";} ?>>5:00 pm</option>
            <option value="17:30"<?php if (isset ($agenda) && $agenda['toTime'] == "17:30") {echo " selected=\"selected\"";} ?>>5:30 pm</option>
            <option value="18:00"<?php if (isset ($agenda) && $agenda['toTime'] == "18:00") {echo " selected=\"selected\"";} ?>>6:00 pm</option>
            <option value="18:30"<?php if (isset ($agenda) && $agenda['toTime'] == "18:30") {echo " selected=\"selected\"";} ?>>6:30 pm</option>
            <option value="19:00"<?php if (isset ($agenda) && $agenda['toTime'] == "19:00") {echo " selected=\"selected\"";} ?>>7:00 pm</option>
            <option value="19:30"<?php if (isset ($agenda) && $agenda['toTime'] == "19:30") {echo " selected=\"selected\"";} ?>>7:30 pm</option>
            <option value="20:00"<?php if (isset ($agenda) && $agenda['toTime'] == "20:00") {echo " selected=\"selected\"";} ?>>8:00 pm</option>
            <option value="20:30"<?php if (isset ($agenda) && $agenda['toTime'] == "20:30") {echo " selected=\"selected\"";} ?>>8:30 pm</option>
            <option value="21:00"<?php if (isset ($agenda) && $agenda['toTime'] == "21:00") {echo " selected=\"selected\"";} ?>>9:00 pm</option>
            <option value="21:30"<?php if (isset ($agenda) && $agenda['toTime'] == "21:30") {echo " selected=\"selected\"";} ?>>9:30 pm</option>
            <option value="22:00"<?php if (isset ($agenda) && $agenda['toTime'] == "22:00") {echo " selected=\"selected\"";} ?>>10:00 pm</option>
            <option value="22:30"<?php if (isset ($agenda) && $agenda['toTime'] == "22:30") {echo " selected=\"selected\"";} ?>>10:30 pm</option>
            <option value="23:00"<?php if (isset ($agenda) && $agenda['toTime'] == "23:00") {echo " selected=\"selected\"";} ?>>11:00 pm</option>
            <option value="23:30"<?php if (isset ($agenda) && $agenda['toTime'] == "23:30") {echo " selected=\"selected\"";} ?>>11:30 pm</option>
          </select>
          <label><input type="checkbox" name="toggleAvailability" id="toggleAvailability"<?php
            	if (isset ($agenda) && $agenda['toDate'] != "") {
					echo " checked=\"checked\"";
				}
			?> />Enable</label>
</td>
</tr>
<tr>
<td class="textarea">Comments</td>
<td><textarea name="content" id="content1" cols="45" rows="5" style="width:450px;" /><?php 
				if (isset ($agenda)) {
					echo stripslashes($agenda['content']);
				}
			?></textarea>
</td>
</tr>
<tr>
<td colspan="2"><hr /></td>     
</tr>
<tr>
<td class="label">Agenda Items</td>
<td>
 <table class="dataTable" id="agenda">
          <tr>
          		<th class="tableHeader" width="20"></th>
            	<th class="tableHeader">Task</th>
            	<th class="tableHeader" width="200">Assignees</th>
                <th class="tableHeader" width="100">Due Date</th>
            	<th class="tableHeader" width="100">Priority</th>
                <th class="tableHeader" width="50"></th>
          </tr>
            <?php
			//Display table rows according to what is going on			
				if (!isset ($agenda)) {				
					echo "<tr id=\"1\" align=\"center\">";
						echo "<td width=\"20\"><input type=\"hidden\" name=\"description[]\" id=\"description1\" /><span class=\"tip noComment loadComment\" title=\"Add comment\"></a></td>";
						echo "<td><input type=\"text\" name=\"task[]\" id=\"task1\" class=\"validate[required]\" autocomplete=\"off\" style=\"width: 100%;\"></td>";
						echo "<td width=\"200\"><input type=\"text\" name=\"assignee[]\" id=\"assignee1\" autocomplete=\"off\" style=\"width: 100%;\" class=\"assignee validate[required]\"></td>";
						echo "<td width=\"100\"><input type=\"text\" name=\"dueDate[]\" id=\"dueDate1\" class=\"dueDate\" readonly=\"readonly\" /></td>";
						echo "<td width=\"100\"><select name=\"priority[]\" id=\"priority1\"><option value=\"1\">Low</option><option value=\"2\" selected=\"selected\">Normal</option><option value=\"3\">High</option></select></td>";
						echo "<td width=\"50\"><span class=\"tip smallDelete\" title=\"Delete task\" onclick=\"deleteObject('agenda', '1')\"></span>";
					echo "</tr>";
				} else {
					$values = sizeof(unserialize($agenda['priority']));
					$tasks = unserialize($agenda['task']);
					$description = unserialize($agenda['description']);
					$assignees = unserialize($agenda['assignee']);
					$dueDates = unserialize($agenda['dueDate']);
					$priorities = unserialize($agenda['priority']);
					
					for ($count = 0; $count <= $values - 1; $count++) {						
						$rowID = $count + 1;
						
						if (empty($description[$count])) {
							$class = "noComment";
							$value = "";
							$tip = "Add comment";
						} else {
							$class = "comment";
							$value = htmlentities(stripslashes($description[$count]));
							$tip = "Edit comment";
						}
						
						echo "<tr id=\"" . $rowID . "\" align=\"center\">";
							echo "<td width=\"20\"><input type=\"hidden\" name=\"description[]\" id=\"description1\" value=\"" . $value . "\" /><span class=\"tip " . $class . " loadComment\" title=\"" . $tip . "\"></a></td>";
							echo "<td><input type=\"text\" name=\"task[]\" id=\"task" . $rowID . "\" class=\"validate[required]\" autocomplete=\"off\" style=\"width: 100%;\" value=\"" . htmlentities(stripslashes($tasks[$count])) . "\"></td>";
							echo "<td width=\"200\"><input type=\"text\" name=\"assignee[]\" id=\"assignee1\" class=\"assignee validate[required]\" autocomplete=\"off\" style=\"width: 100%;\" value=\"" . htmlentities(stripslashes($assignees[$count])) . ", \"></td>";
							echo "<td width=\"100\"><input type=\"text\" name=\"dueDate[]\" id=\"dueDate" . $rowID . "\" class=\"dueDate\" value=\"" . htmlentities(stripslashes($dueDates[$count])) . "\" readonly=\"readonly\" /></td>";
							echo "<td width=\"100\"><select name=\"priority[]\" id=\"priority" . $rowID . "\"><option value=\"1\""; if ($priorities[$count] == "1") {echo " selected=\"selected\"";} echo ">Low</option><option value=\"2\""; if ($priorities[$count] == "2") {echo " selected=\"selected\"";} echo ">Normal</option><option value=\"3\""; if ($priorities[$count] == "3") {echo " selected=\"selected\"";} echo ">High</option></select></td>";
							echo "<td width=\"50\"><span class=\"tip smallDelete\" title=\"Delete task\" onclick=\"deleteObject('agenda', '" . $rowID . "', '" . $count . "');\"></span>";
						echo "</tr>";
					}
					
					echo "<input type=\"hidden\" name=\"removeData\" id=\"removeData\"  value=\"\" />";
				}
			?>
        </table>
        <p><span class="smallAdd" onclick="addAgenda('agenda','<input type=\'hidden\' name=\'description[]\' id=\'description', '\' /><span class=\'tip noComment loadComment\' title=\'Add comment\'></a>', '<input type=\'text\' name=\'task[]\' id=\'task', '\' class=\'validate[required]\' autocomplete=\'off\' style=\'width: 100%;\'>', '<input type=\'text\' name=\'assignee[]\' id=\'assignee', '\' class=\'assignee validate[required]\' autocomplete=\'off\' style=\'width: 100%;\'>', '<input type=\'text\' name=\'dueDate[]\' id=\'dueDate', '\' class=\'dueDate\' readonly=\'readonly\' />', '<select name=\'priority[]\' id=\'priority', '\'><option value=\'1\'>Low</option><option value=\'2\' selected=\'selected\'>Normal</option><option value=\'3\'>High</option></select>'); checkAuto(); checkCalendar();">Add Another Task</span></p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>

<div class="toolbar">
<input class="button blue" type="submit" value="Submit" name="submit" onClick="tinyMCE.triggerSave();" />
<input class="button reset" type="reset" value="Reset" />
<input class="button cancel" type="button" value="Cancel" data-url="index.php" />
</div>
    </form>
<?php footer("admin"); ?>
