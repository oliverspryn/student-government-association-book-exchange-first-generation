<?php
//Include the system's core
	require_once("../../Connections/connDBA.php");

//Include the top of the page from the administration template
	topPage("admin", "Question of the Week", "question", array("question", 1), "<link href=\"system/stylesheets/admin.css\" rel=\"stylesheet\" />");
	
//Add a toolbar for administrative access other features of this plugin
	echo "<nav class=\"toolbar\">
<button class=\"button blue\" onclick=\"javascript: document.location.href='manage_question.php'\">New Question</button>
<button class=\"button\" onclick=\"javascript: document.location.href='statistics.php'\">Response Statistics</button>
</nav>

";

//Fetch the questions and divide them into three categories: past, current, and future
	$now = strtotime("now");
	$questions = mysql_query("SELECT * FROM question ORDER BY timeStart ASC", $connDBA);
	$past = array();
	$current = "";
	$future = array();
	
	while($question = mysql_fetch_array($questions)) {
	//These questions have yet to be displayed
		if ($question['timeStart'] > $now) {
			array_push($future, $question);
	//These questions have already expired
		} elseif ($question['timeEnd'] <= $now) {
			array_push($past, $question);
	//This question is set to display right now
		} else {
			$current = $question;
		}
	}
	
//Display the current question of the week
	if ($current != "") {
	//Extract the response count
		$responses = unserialize(stripslashes($current['responseValue']));
		
		if ($responses['total'] == 1) {
			$responseText = "1 response";
		} else {
			$responseText = $responses['total'] . " responses";
		}
		
		echo "<h2 class=\"current\">Current Question</h2>\n";
		echo "<section class=\"question current\">
<div class=\"tools\">
<span class=\"data time\">Expires on " . date("F jS, Y \a\\t h:i:s A", $current['timeEnd']) . "</span>
<a href=\"question.php?id=" . $current['id'] . "\" class=\"data responses\">" . $responseText . "</a>
</div>

<div class=\"content\">
<h2>" . $current['title'] . "</h2>

" . $current['question'] . "
</div>
</section>

";
	}
	
//Display future questions
	if (is_array($future) && !empty($future)) {
		echo "<h2 class=\"future\">Future Questions</h2>";
		
		foreach($future as $futureQuestion) {
			echo "<section class=\"question future\">
<div class=\"tools\">
<span class=\"data time\">Shows on " . date("F jS, Y \a\\t h:i:s A", $futureQuestion['timeStart']) . "</span>
</div>

<div class=\"content\">
<h2>" . $futureQuestion['title'] . "</h2>

" . $futureQuestion['question'] . "
</div>
</section>

";
		}
	}
	
//Display past questions
	if (is_array($past) && !empty($past)) {		
		echo "<h2 class=\"past\">Past Questions</h2>";
		
		foreach($past as $pastQuestion) {
		//Extract the response count
			$responses = unserialize(stripslashes($pastQuestion['responseValue']));
			
			if ($responses['total'] == 1) {
				$responseText = "1 response";
			} else {
				$responseText = $responses['total'] . " responses";
			}
			
		//Print out the results
			echo "<section class=\"question past\">
<div class=\"tools\">
<span class=\"data time\">Expired on " . date("F jS, Y \a\\t h:i:s A", $pastQuestion['timeEnd']) . "</span>
<a href=\"question.php?id=" . $pastQuestion['id'] . "\" class=\"data responses\">" . $responseText . "</a>
</div>

<div class=\"content\">
<h2>" . $pastQuestion['title'] . "</h2>

" . $pastQuestion['question'] . "
</div>
</section>

";
		}
	}
		
//Include the footer from the administration template
	footer("admin");
?>