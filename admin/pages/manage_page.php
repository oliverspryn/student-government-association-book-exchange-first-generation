<?php
//Header functions
	require_once('../../Connections/connDBA.php');

//Check access to this page
	$page = access("staffpages", "StaffPage", "index.php");
	
//Process the form
	process("staffpages", "StaffPage", "index.php", "page");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	if (isset ($page)) {
		$title = "Edit the " . $page['title'] . " Staff Page";
	} else {
		$title =  "Create a New Staff Page";
	}
	
	title($title); 
?>
<?php headers(); ?>
<?php tinyMCEAdvanced(); ?>
<?php validate(); ?>
<script src="../../javascripts/common/popupConfirm.js" type="text/javascript"></script>
<script src="../../javascripts/common/goToURL.js" type="text/javascript"></script>
<script src="../../javascripts/common/openWindow.js" type="text/javascript"></script>
</head>
<body<?php bodyClass(); ?>>
<?php toolTip(); ?>
<?php topPage(); ?>
      
    <h2>
      <?php if (isset ($page)) {echo "Edit the \"" . $page['title'] . "\" Staff Page";} else {echo "Create New Staff Page";} ?>
    </h2>
<p>Use this page to <?php if (isset ($page)) {echo "edit the content of \"<strong>" . $page['title'] . "</strong>\"";} else {echo "create a new staff page";} ?>.</p>
<?php
//Let users know an update is pending if one is pending
	if (isset ($page) && !isset($_GET['content'])) {
		if (($page['published'] == "1" || $page['published'] == "0") && privileges("publishStaffPage") != "true" && empty($page['message'])) {
			alert("<p>This page is awaiting approval.</p>");
		} elseif (($page['published'] == "1" || $page['published'] == "0") && privileges("publishStaffPage") == "true" && empty($page['message'])) {
			alert("<p>This page is awaiting approval. You may <a href=\"index.php\" onclick=\"MM_openBrWindow('approve.php?id=" . $_GET['id'] . "','','status=yes,scrollbars=yes,resizable=yes,fullscreen=yes')\">approve this version</a> if you do not have any changes to make. Changes made to this version will be published.</p>");
		} else {
			echo "<p>&nbsp;</p>";
		}
		
		if (!empty($page['message'])) {
			alert($page['message']);
		}
	} else {
		echo "<p>&nbsp;</p>";
	}
?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="managePage" id="validate" onsubmit="return errorsOnSubmit(this);">
      <div class="catDivider one">Content</div>
      <div class="stepContent">
      <blockquote>
        <p>Title<span class="require">*</span>: <img src="../../images/admin_icons/help.png" alt="Help" width="17" height="17" onmouseover="Tip('The text that will display in big letters on the top-left of each page &lt;br /&gt;and at the top of the browser window')" onmouseout="UnTip()" /></p>
        <blockquote>
          <p>
            <input name="title" type="text" id="title" size="50" autocomplete="off" class="validate[required]"<?php
            	if (isset ($page)) {
					echo " value=\"" . htmlentities($page['title']) . "\"";
				}
			?> />
          </p>
        </blockquote>
        <p>Content<span class="require">*</span>: <img src="../../images/admin_icons/help.png" alt="Help" width="17" height="17" onmouseover="Tip('The main content or body of the webpage')" onmouseout="UnTip()" /> </p>
        <blockquote>
        <p>
            <textarea name="content" id="content1" cols="45" rows="5" style="width:640px; height:320px;" class="validate[required]" /><?php 
				if (isset ($page)) {
					echo stripslashes($page['content']);
				}
			?></textarea>
          </p>
        </blockquote>
      </blockquote>
      </div>
      <div class="catDivider two">Settings</div>
      <div class="stepContent">
      	<blockquote>
        	<p>Allow Comments:</p>
            <blockquote>
            	<p>
                	<label><input type="radio" name="comments" id="comments_1" class="validate[required]" value="1"<?php 
						if (isset ($page)) {
							if ($page['comments'] == "1") {
								echo " checked=\"checked\"";
							}
						}
					?> />Yes</label>
                    <label><input type="radio" name="comments" id="comments_0" class="validate[required]" value="0"<?php 
						if (isset ($page)) {
							if ($page['comments'] == "0") {
								echo " checked=\"checked\"";
							}
						} else {
							echo " checked=\"checked\"";
						}
					?> />No</label>
                </p>
            </blockquote>
        </blockquote>
      </div>
      <div class="catDivider three">Finish</div>
      <div class="stepContent">
	  <blockquote>
      	<p>
          <?php submit("submit", "Submit"); ?>
			<input name="reset" type="reset" id="reset" onclick="GP_popupConfirmMsg('Are you sure you wish to clear the content in this form? \rPress \&quot;cancel\&quot; to keep current content.');return document.MM_returnValue" value="Reset" />
            <input name="cancel" type="button" id="cancel" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="Cancel" />
        </p>
          <?php formErrors(); ?>
      </blockquote>
      </div>
    </form>
<?php footer(); ?>
</body>
</html>
