<?php require_once('../Connections/connDBA.php'); ?>
<?php loggedIn() ? true : redirect($root  . "login.php?accesscheck=" . urlencode($_SERVER['REQUEST_URI'])); ?>
<?php
//Process the agenda
	if (isset($_POST['action']) && $_POST['action'] == "setAvaliability" && !empty($_POST['id'])) {
		$id = $_POST['id'];
		$option = $_POST['option'];
		$oldValuePrep = explode("_", $id);
		$oldValue = $oldValuePrep['1'];
		
		$oldDataGrabber = mysql_query("SELECT * FROM `collaboration` WHERE `id` = '{$id}'", $connDBA);
		$oldData = mysql_fetch_array($oldDataGrabber);
		$oldCompletion = unserialize($oldData['completed']);
		
		if (is_array($oldCompletion)) {
		//If a value is being inserted
			if (!isset($oldCompletion[$oldValue])) {
				if ($oldValue > sizeof($oldCompletion) - 1) {
					for($count = sizeof($oldCompletion); $count <= $oldValue; $count++) {
						if ($count != $oldValue) {
							$oldCompletion[$count] = NULL;
						} else {
							$oldCompletion[$count] = "true";
						}
					}
				} else {
					$oldCompletion[$oldValue] = "true";
				}
				
				$status = mysql_real_escape_string(serialize($oldCompletion));
		//If a value is being removed
			} else {
				$oldCompletion[$oldValue] = NULL;
				$status = mysql_real_escape_string(serialize($oldCompletion));
			}
	//If a value is being inserted	
		} else {
			$newArray = array();
			
			for($count = 0; $count <= $oldValue; $count++) {
				if ($count != $oldValue) {
					$newArray[$count] = NULL;
				} else {
					$newArray[$count] = "true";
				}
			}
			
			$status = mysql_real_escape_string(serialize($newArray));
		}
		
		mysql_query("UPDATE `collaboration` SET `completed` = '{$status}' WHERE `id` = '{$id}'", $connDBA);
		exit;
	}
	
//Delete a file
	if (privileges("deleteFile") == "true") {
		if (isset($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['directory']) && !empty($_GET['name'])) {
			$directory = $_GET['directory'];
			$file = urldecode($_GET['name']);
			
			unlink("files/" . $directory . "/" . $file);
			
			header("Location: index.php?message=deleted");
			exit;
		}
	}
	
//Upload a file
	if (privileges("uploadFile") == "true") {
		if (isset($_POST['submit']) && !empty($_FILES['file']) && !empty($_POST['category'])) {
			$tempFile = $_FILES['file'] ['tmp_name'];
			$uploadDir = "files/" . $_POST['category'];
			
			$fileArray = explode(".", basename($_FILES['file'] ['name']));
			$fileExtension = end($fileArray);
			$arraySize = sizeof($fileArray) - 1;
			$targetFile = "";
			
			for ($count = 0; $count <= $arraySize; $count++) {
				if ($count != $arraySize) {
					$targetFile .= $fileArray[$count];
				} else {
					$targetFile .= "_" . randomValue(10, "alphanum") . "." . $fileExtension;
				}
			}
			
			if (extension($targetFile)) {
				move_uploaded_file($tempFile, $uploadDir . "/" . stripslashes($targetFile));
				
				header("Location: index.php?message=uploaded");
				exit;
			}
		}
	}
	
//Process the poll
	if (isset($_POST['poll'])) {
		if (isset($_POST['poll_' . $_POST['poll']]) && isset($_POST['submit_' . $_POST['poll']])) {
			$userData = userData();
			$pollData = query("SELECT * FROM `collaboration` WHERE `id` = '{$_POST['poll']}'");
			$response = unserialize($pollData['responses']);
			
			if (is_array($response) && !empty($response)) {
				if ($_POST['poll_' . $_POST['poll']] > count($response) - 1) {
					for($count = sizeof($response); $count <= $_POST['poll_' . $_POST['poll']]; $count++) {
						if ($count != $_POST['poll_' . $_POST['poll']]) {
							$response[$count] = NULL;
						} else {
							$response[$count] = array('response' => "1", 'participant' => $userData['id']);
						}
					}
				} else {
					if (empty($response[$_POST['poll_' . $_POST['poll']]])) {
						$response[$_POST['poll_' . $_POST['poll']]] = array('response' => "1", 'participant' => $userData['id']);
					} else {
						$response[$_POST['poll_' . $_POST['poll']]]['response'] = sprintf($response[$_POST['poll_' . $_POST['poll']]]['response'] + 1);
						$response[$_POST['poll_' . $_POST['poll']]]['participant'] = $response[$_POST['poll_' . $_POST['poll']]]['participant'] . "," . $userData['id'];
					}
				}
			} else {
				$response = array();
				
				for($count = 0; $count <= $_POST['poll_' . $_POST['poll']]; $count++) {
					if ($count != $_POST['poll_' . $_POST['poll']]) {
						$response[$count] = NULL;
					} else {
						$response[$count] = array('response' => "1", 'participant' => $userData['id']);
					}
				}
			}
			
			$return = serialize($response);
			
			query("UPDATE `collaboration` SET `responses` = '{$return}' WHERE `id` = '{$_POST['poll']}'");
			redirect("index.php?message=poll");
		}
	}
	
//Process the comments
	if (isset($_POST['submit']) && !empty($_POST['id']) && !empty($_POST['itemID']) && !empty($_POST['comment_' . $_POST['itemID']])) {
		$id = $_POST['id'];
		$itemID = $_POST['itemID'];
		$comment = $_POST['comment_' . $itemID];
		$date = strtotime("now");
		$oldDataGrabber = mysql_query("SELECT * FROM `collaboration` WHERE `id` = '{$itemID}'", $connDBA);
		$oldData = mysql_fetch_array($oldDataGrabber);
		$oldComments = unserialize($oldData['comment']);
		$oldNames = unserialize($oldData['name']);
		$oldDates = unserialize($oldData['date']);

		if (is_array($oldComments)) {
			array_push($oldComments, $comment);
			array_push($oldNames, $id);
			array_push($oldDates, $date);
				
			$comments = mysql_real_escape_string(serialize($oldComments));
			$names = mysql_real_escape_string(serialize($oldNames));
			$dates = mysql_real_escape_string(serialize($oldDates));
		} else {
			$comments = mysql_real_escape_string(serialize(array($comment)));
			$names = mysql_real_escape_string(serialize(array($id)));
			$dates = mysql_real_escape_string(serialize(array($date)));
		}
		
		mysql_query("UPDATE `collaboration` SET `name` = '{$names}', `date` = '{$dates}', `comment` = '{$comments}' WHERE `id` = '{$itemID}'", $connDBA);
		header("Location: index.php?message=comment");
		exit;
	}
	
//Delete a comment
	if (privileges("deleteForumComments") == "true") {
		if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "delete" && isset($_GET['comment'])) {
			$id = $_GET['id'];
			$comment = $_GET['comment'];
			
		//If only a single comment is deleted
			if (is_numeric($comment)) {
				$oldDataGrabber = mysql_query("SELECT * FROM `collaboration` WHERE `id` = '{$id}'", $connDBA);
				$oldData = mysql_fetch_array($oldDataGrabber);
				$values = sizeof(unserialize($oldData['date'])) - 1;
				$oldComments = unserialize($oldData['comment']);
				$oldNames = unserialize($oldData['name']);
				$oldDates = unserialize($oldData['date']);
				
				for ($count = 0; $count <= $values; $count++) {
					if ($count == $comment - 1) {
						unset($oldComments[$count]);
						unset($oldNames[$count]);
						unset($oldDates[$count]);
					}
				}
				
				$comments = mysql_real_escape_string(serialize(array_merge($oldComments)));
				$names = mysql_real_escape_string(serialize(array_merge($oldNames)));
				$dates = mysql_real_escape_string(serialize(array_merge($oldDates)));
				
				mysql_query("UPDATE `collaboration` SET `name` = '{$names}', `date` = '{$dates}', `comment` = '{$comments}' WHERE `id` = '{$id}'", $connDBA);
				
				header("Location: index.php?message=deletedComment");
				exit;
		//If all comments are deleted
			} else {
				$comments = "";
				$names = "";
				$dates = "";
				
				mysql_query("UPDATE `collaboration` SET `name` = '{$names}', `date` = '{$dates}', `comment` = '{$comments}' WHERE `id` = '{$id}'", $connDBA);
				
				header("Location: index.php?message=deletedAll");
				exit;
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php title("Staff Home Page"); ?>
<?php headers(); ?>
<?php customCheckbox(); ?>
<?php validate(); ?>
<?php tinyMCESimple(); ?>
<script src="../javascripts/jQuery/adminAssist.jquery.js" type="text/javascript"></script>
</head>
<body>
<?php tooltip(); ?>
<?php topPage(); ?>
<h1>Staff Home Page</h1>
<p>This page is the main collaboration hub of this site. Check here regularly for updates and announcements.</p>
<p>&nbsp;</p>
<?php
//Display the toolbar, if the user is an administrator
	if ($_SESSION['MM_UserGroup'] == "Administrator") {
		echo "<div class=\"toolBar\">
<a class=\"toolBarItem announcementLink\" href=\"manage_announcement.php\">Create Announcement</a>
<a class=\"toolBarItem agenda\" href=\"manage_agenda.php\">Create Agenda</a>
<a class=\"toolBarItem fileShare\" href=\"manage_files.php\">Create File Share</a>
<a class=\"toolBarItem statistics\" href=\"manage_poll.php\">Create a Poll</a>
<a class=\"toolBarItem feedback\" href=\"manage_forum.php\">Create a Forum</a>
</div>
<br />
";
	}
//Display announcements, file share, agenda, forum and polling modules
	$itemsCheck = mysql_query("SELECT * FROM `collaboration` WHERE `visible` = 'on'", $connDBA);
	
	if (mysql_fetch_array($itemsCheck)) {
		$time = getdate();
		
		if (0 < $time['minutes'] && $time['minutes'] < 9) {
			$minutes = "0" . $time['minutes'];
		} else {
			$minutes = $time['minutes'];
		}
		
		$currentTime = $time['hours'] . ":" . $minutes;
		$currentDate = strtotime($time['mon'] . "/" . $time['mday'] . "/" . $time['year'] . " " . $currentTime);
		$itemGrabber = mysql_query("SELECT * FROM `collaboration` ORDER BY `position` ASC", $connDBA);
		
		function type($type) {
			global $item;
			global $connDBA;
			
			switch ($type) {
			//If this is an agenda module
				case "Agenda" :
					$totalComplete = 0;
					$task = unserialize($item['task']);
					$description = unserialize($item['description']);
					$assignee = unserialize($item['assignee']);
					$dueDate = unserialize($item['dueDate']);
					$priority = unserialize($item['priority']);
					$completed = unserialize($item['completed']);
					
					echo "

<!-- Agenda: " . stripslashes($item['title']) . " -->
<div class=\"agendaContent\">
<p class=\"itemTitle\">" . stripslashes($item['title']) . "</p>
" . stripslashes($item['content']) . "
<div class=\"progressBar\" style=\"width:200px; height:20px;\"></div>
<span class=\"percentage\"></span>
<br />
<br />
					
<table class=\"dataTable\">
<tr>
<th class=\"tableHeader\" width=\"20\"></th>
<th class=\"tableHeader\">Task</th>
<th class=\"tableHeader\" width=\"200\">Assignees</th>
<th class=\"tableHeader\" width=\"200\">Due Date</th>
<th class=\"tableHeader\" width=\"100\">Priority</th>
<th class=\"tableHeader\" width=\"100\">Completion</th>
</tr>

";
					
					for($count = 0; $count <= sizeof($task) - 1; $count++) {
						echo "<!-- Agenda Task: " . stripslashes($task[$count]) . " -->
<tr";
						if ($count & 1) {echo " class=\"even\">\n";} else {echo " class=\"odd\">\n";}
							if (empty($description[$count])) {
								echo "<td class=\"description\">&nbsp;</td>\n";
							} else {
								echo "<td class=\"description\">
<a href=\"javascript:;\" class=\"action description\" onmouseover=\"Tip('View comments for this task');\" onmouseout=\"UnTip('');\"></a>
<div class=\"contentHide\">" . stripslashes($description[$count]) . "</div>
</td>\n";
							}
							
							echo "<td class=\"taskName\">" . stripslashes($task[$count]) . "</td>\n";
							echo "<td class=\"assignees\">" . $assignee[$count] . "</td>\n";
							echo "<td class=\"dueDate\">";
							
							if ($dueDate[$count] == "") {
								echo "<span class=\"notAssigned\">None</span>";
							} else {
								echo $dueDate[$count];
							}
							
							echo "</td>\n";
							echo "<td class=\"priority\">";
							
							switch($priority[$count]) {
								case "1" : echo "<span style=\"color:#666666\">Low</span>"; break;
								case "2" : echo "<span style=\"color:#0000FF\">Normal</span>"; break;
								case "3" : echo "<span style=\"color:#FF0000\">High</span>"; break;
							}
							
							echo "</td>\n";
							echo "<td>
<div align=\"center\">
<a href=\"javascript:;\" class=\"checkbox ";
							
							if (is_array($completed) && !empty($completed[$count])) {
								$totalComplete++;
								
								echo "checked";
							} else {
								echo "unchecked";
							}
							
							echo "\" id=\"" . $item['id'] . "_" . $count . "\"></a>
</div>
</td>
</tr>
";
					}
					
					echo "</table>
<input type=\"hidden\" class=\"totalItems\" value=\"" . (sizeof($task) - 1) . "\" />
<input type=\"hidden\" class=\"totalComplete\" value=\"" . $totalComplete . "\" />
</div>\n";
					break;	
				
			//If this is an announcement
				case "Announcement" :
					echo "

<!-- Announcement: " . stripslashes($item['title']) . " -->
<div class=\"announcementContent\">
<p class=\"itemTitle\">" . stripslashes($item['title']) . "</p>
" . stripslashes($item['content']) . "
</div>\n";
					break;
			
			//If this is a file share module
				case "File Share" :
					echo "

<!-- File Share: " . stripslashes($item['title']) . " -->
<div class=\"fileShareContent\">
<p class=\"itemTitle\">" . stripslashes($item['title']) . "</p>
" . stripslashes($item['content']) . "
";
					
					if (is_array(unserialize($item['directories']))) {
						$directories = unserialize($item['directories']);
						
						while (list($categoryKey, $categoryArray) = each($directories)) {
							$filesDirectory = scandir("files/" . $categoryKey);
							$count = 1;
							
							echo "<br />
<table class=\"dataTable\">
<tr>";
									echo "<th class=\"tableHeader\">" . $categoryArray . "</th>";
									
									if ($item["canDelete"] == "1" || $_SESSION['MM_UserGroup'] == "Administrator") {
										echo "<th width=\"75\" class=\"tableHeader\">Delete</th>";
									}
									
								echo "</tr>";
								
							sort($filesDirectory);
							
							foreach($filesDirectory as $files) {
								if ($files !== "." && $files !== "..") {
									$filesResult = "true";
									$count++;
									
									echo "<tr";
									if ($count & 1) {echo " class=\"even\">";} else {echo " class=\"odd\">";}
										$fileArray = explode(".", $files);
										$fileExtension = end($fileArray);
										$additionStrip = explode("_", $files);
										$arraySize = sizeof($additionStrip) - 1;
										$name = "";
										
										for ($i = 0; $i <= $arraySize; $i++) {
											if ($i == 0) {
												$name .= $additionStrip[$i];
											} elseif ($arraySize > $i && $i > 0) {
												$name .= "_" . $additionStrip[$i];
											} else {
												$name .= "." . $fileExtension;
											}
										}
										
										echo "<td><a href=\"gateway.php/files/" . $categoryKey . "/" . $files . "\" target=\"_blank\">" . stripslashes($name) . "</a></td>";
										
										if ($item["canDelete"] == "1" || $_SESSION['MM_UserGroup'] == "Administrator") {
											echo "<td width=\"75\"><a class=\"action smallDelete\" href=\"index.php?action=delete&directory=" . $categoryKey . "&name=" . urlencode($files) . "\" onmouseover=\"Tip('Click to delete &quot;<strong>" . addslashes($name) . "</strong>&quot;');\" onmouseout=\"UnTip();\" onclick=\"return confirm('This action cannot be undone. Continue?');\"></a></td>";
										}
										
									echo "</tr>";
								}
							}
							
							if (!isset($filesResult)) {
								echo "<tr class=\"odd\"><td colspan=\"2\"><div class=\"noResults notAssigned\">There are no files in this category</div></td></tr>";
							}
							
          					echo "</table>";
							
							unset($filesResult);
						}
						
						if ($item["canAdd"] == "1" || $_SESSION['MM_UserGroup'] == "Administrator") {
							echo "<br /><br />";
							
							if ($item["canAdd"] == "0" && $_SESSION['MM_UserGroup'] == "Administrator") {								
								echo "<span class=\"notAssigned\">Only administrators can upload files</span>";
							}
							
							echo "<form id=\"validate_" . $item['id'] . "\" action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return errorsOnSubmit(this, 'file_" . $item['id'] . "');\"><h2>Upload file</h2><blockquote><p><input type=\"file\" name=\"file\" id=\"file_" . $item['id'] . "\" size=\"50\" class=\"validate[required]\"><br />Max file size: " . ini_get('upload_max_filesize') . "</p></blockquote><h2>Select category</h2><blockquote><p><select name=\"category\" id=\"category" . $item['id'] . "\" class=\"validate[required]\"><option value=\"\">- Select -</option>";
							$directories = unserialize($item['directories']);
							
							while (list($uploadKey, $uploadArray) = each($directories)) {
								echo "<option value=\"" . $uploadKey . "\">" . stripslashes(htmlentities($uploadArray)) . "</option>";
							}
							
							echo "</select></p><p><input type=\"submit\" name=\"submit\" id=\"submit" . $item['id'] . "\" value=\"Upload File\" /></p></blockquote></form>";
						}
					} else {
						echo "<div class=\"noResults\">No categories found</div>";
					}
					
					echo "</div>";
					break;
					
			//If this is a polling module
				case "Poll" : 
				//Grab all of the necessary data
					$polled = false;
					$count = 0;
					$questions = unserialize($item['questions']);
					$responses = unserialize($item['responses']);
					$toalReplies = query("SELECT * FROM `users`", "num");
					$userData = userData();
					$keys = array_keys($questions);
					
				//Check to see if this user has already polled
					if (is_array($responses)) {
						foreach($responses as $test) {
							if (in_array($userData['id'], explode(",", $test['participant']))) {
								$polled = true;
								break;
							}
						}
					}
					
					echo "

<!-- Poll: " . stripslashes($item['title']) . " -->					
<div class=\"pollContent\">
<p class=\"itemTitle\">" . stripslashes($item['title']) . "</p>
" . stripslashes($item['content']) . "
";
					
				//If the user hasn't polled, then show the options
					if ($polled == false) {
						echo "
<br />
Select your answer:
<blockquote>
<input type=\"hidden\" name=\"poll\" value=\"" . $item['id'] . "\">
";
						
						foreach ($questions as $question) {
							echo "<!-- Poll Option: " . $question . " -->
<label><input type=\"radio\" name=\"poll_" . $item['id'] . "\" id=\"" . $item['id'] . "_" . $count . "\" value=\"" . $keys[$count] . "\" class=\"validate[required]\">" . $question . "</label>
<br />
";
							
							$count ++;
						}
						
						echo "<br />
<input type=\"submit\" name=\"submit_" . $item['id'] . "\" id=\"submit\" value=\"Submit\" />
</blockquote>
";
					}
					
					echo "<br />
<br />

<table>
";
					
				//Display the poll results
					$count = 0;
					
					foreach (array_keys($questions) as $question) {						
						if (is_array($responses)) {
							$currentValue = $responses[$count]['response'];
							
							if (!empty($currentValue)) {
								$size = 0;
								
								foreach(explode(",", $responses[$count]['participant']) as $check) {
									if (exist("users", "id", $check)) {
										$size++;
									}
								}
							} else {
								$size = "0";
							}
							
							$percent = round(sprintf(($size / $toalReplies) * 100));
							
							if ($percent > 100) {
								$percent = "100";
							}
							
							echo "<!-- Poll Result: " . prepare($questions[$question]) . " -->
<tr>
<td width=\"350\">
<span style=\"border:thin black solid; display:block; width:100%; text-decoration: none;\">
<span style=\"background-color:#090; display:block; width:" . $percent . "%; text-decoration: none;\">&nbsp;</span>
</span>
(" . $size . "/" . $toalReplies . ") " .  prepare($questions[$question]) . "
</td>
</tr>
";
						} else {
							echo "<!-- Poll Result: " . prepare($questions[$question]) . " -->
<tr>
<td width=\"350\">
<span style=\"border:thin black solid; display:block; width:100%; text-decoration: none;\">
<span style=\"background-color:#090; display:block; width:0%; text-decoration: none;\">&nbsp;</span>
</span>
(0/" . $toalReplies . ") " . prepare($questions[$question]) . "
</td>
</tr>
";
						}
						
						$count ++;
					}
					
					echo "
</table>
</div>";
					
					break;
				
			//If this is a forum module	
				case "Forum" : 
					echo "

<!-- Forum: " . stripslashes($item['title']) . " -->	
<div class=\"commentBox\">
<p class=\"itemTitle\">" . stripslashes($item['title']) . "</p>
" . stripslashes($item['content']) . "<br />";
					
					$arrayCheck = unserialize($item['comment']);
					
					if (is_array($arrayCheck) && !empty($arrayCheck)) {
						$values = sizeof(unserialize($item['date'])) - 1;
						$names = unserialize($item['name']);
						$dates = unserialize($item['date']);
						$comments = unserialize($item['comment']);
						
						if (privileges("deleteForumComments") == "true" && !empty($comments)) {							
							echo "<a class=\"action smallDelete\" href=\"index.php?id=" . $item['id'] . "&action=delete&comment=all\" onclick=\"return confirm('This action cannot be undone. Continue?')\" onmouseover=\"Tip('Delete all comments')\" onmouseout=\"UnTip()\"></a>";
						}
						
						
						for ($count = 0; $count <= $values; $count++) {
							$userID = $names[$count];
							
							if (exist("users", "id", $userID)) {
								$userGrabber = mysql_query("SELECT * FROM `users` WHERE `id` = '{$userID}'", $connDBA);
								$user = mysql_fetch_array($userGrabber);
								echo "<p class=\"commentTitle\">" . $user['firstName'] . " " . $user['lastName'] . " commented on " .  date("l, M j, Y \\a\\t h:i:s A", $dates[$count]);
							} else {
								echo "<p class=\"commentTitle\">An unknown staff member commented on " .  date("l, M j, Y \\a\\t h:i:s A", $dates[$count]);
							}
							
							if (privileges("deleteForumComments") == "true") {
								if (isset ($_GET['page'])) {
									$processor = "?page=" . $_GET['page'] . "&";
								} else {
									$processor = "?";
								}
								
								$commentID = $count + 1;
								
								echo "<a class=\"action smallDelete\" href=\"index.php?id=" . $item['id'] . "&action=delete&comment=" . $commentID . "\" onclick=\"return confirm('This action cannot be undone. Continue?')\" onmouseover=\"Tip('Delete this comment')\" onmouseout=\"UnTip()\"></a>";
							}
							
							echo "</p>";
							echo stripslashes($comments[$count]);
							unset($userGrabber);
							unset($user);
						}
					} else {
						if (privileges("deleteForumComments") == "true" && !empty($comments)) {
							echo "<a class=\"action smallDelete\" href=\"index.php?id=" . $item['id'] . "&action=delete&comment=all\" onclick=\"return confirm('This action cannot be undone. Continue?')\" onmouseover=\"Tip('Delete all comments')\" onmouseout=\"UnTip()\"></a>";
						}
						
						echo "<div class=\"noResults\">No comments yet! Be the first to comment.</div>";
					}
					
					$userName = $_SESSION['MM_Username'];
					$userGrabber = mysql_query("SELECT * FROM `users` WHERE `userName` = '{$userName}'", $connDBA);
					$user = mysql_fetch_array($userGrabber);
					
					echo "<form name=\"comments\" id=\"validate_" . $item['id'] . "\" action=\"index.php\" method=\"post\"><input type=\"hidden\" name=\"itemID\" id=\"itemID\" value=\"" . $item['id'] . "\" /><input type=\"hidden\" name=\"id\" id=\"id\" value=\"" . $user['id'] . "\" />";
					echo "<blockquote><textarea name=\"comment_" . $item['id'] . "\" id=\"comment_" . $item['id'] . "\" style=\"width:450px;\" class=\"validate[required]\"></textarea><br/><p>";
					submit("submit", "Add Comment");
					echo "</p></blockquote></form>";
					
					echo "</div>";
					
					break;
			}
		}
		
		while ($item = mysql_fetch_array($itemGrabber)) {
			if (($item['visible'] == "on" || $item['fromDate'] != "") || ($item['visible'] == "on" && $item['fromDate'] != "")) {
				$from = strtotime($item['fromDate'] . " " . $item['fromTime']);
				$to = strtotime($item['toDate'] . " " . $item['toTime']);
				
				if ($item['fromDate'] != "") {
					if ($from > $currentDate) {
						//Do nothing, this will display at a later time
					} elseif ($to <= $currentDate) {
						//Do nothing, this has expired
					} else {
						type($item['type']);
					}
				} else {
					type($item['type']);
				}
			}
		}
	}
?>
<?php footer(); ?>
</body>
</html>