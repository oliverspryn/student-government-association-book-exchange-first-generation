<?php
//Include the system's core and JSON encoding library for older versions of PHP
	require_once("../../Connections/connDBA.php");
	require_once("../../Connections/jsonwrapper/jsonwrapper.php");
	
//Get the data from the supplied question ID
	if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && $data = exist("question", "id", $_GET['id'])) {
		$title = $data['title'] . " Data";
	} else {
		header("Location: index.php");
		exit;
	}

//Include the top of the page from the administration template
	topPage("admin", $title, "question", array("question", 0), "<link href=\"system/stylesheets/admin.css\" rel=\"stylesheet\" />
<script src=\"http://code.highcharts.com/highcharts.js\"></script>
<script src=\"http://code.highcharts.com/modules/exporting.js\"></script>");
	
//Generate the custom time stamp
	$now = strtotime("now");
	
	if ($data['timeStart'] > $now) {
		$date = date("F jS, Y", $data['timeStart']);
		$dateType = "Displays on";
	} elseif ($data['timeEnd'] <= $now) {
		$date = date("F jS, Y", $data['timeEnd']);
		$dateType = "Expired on";
	} else {
		$date = date("F jS, Y", $data['timeEnd']);
		$dateType = "Expires on";
	}
	
//Extract the number of comments
	$commentsData = unserialize(stripslashes($data['responseValue']));
	$comments = $commentsData['total'];
	
//Generate the number of days which have comments
	$secondsPerDay = 86400;
	$days = array();
	
//Add a new day for each of the of series recorded comments, since they are stored by day
	foreach($commentsData as $key => $value) {
	//Ignore the index which contains the total number of entries
		if ($key != "total") {
			array_push($days, date("F jS", $data['timeStart'] + ($key * $secondsPerDay)));
		}
	}
	
	$days = json_encode($days);
	
//Generate the breakdown of comments by day
	array_shift($commentsData); //Shift the "total" value off the beginning of the array
	$commentsByDay = str_replace('"', "", json_encode($commentsData)); //Quotes in the JSON array won't work with the charts
	
//Generate the JavaScript for the chart
	echo "<script>
$(document).ready(function() {
	var chart = new Highcharts.Chart({
		chart: {
			backgroundColor : null,
			renderTo : 'chart',
			width : 640
		},
		
		title : {
			text : ''
		},
		
		credits: {
			enabled : false
		},
		
		exporting : {
			enabled : false
		},
		
		legend : {
			enabled : false
		},
		
		xAxis: {
			title : {
				text : 'Days'
			},
			
			categories : " . $days . "
		},
		
		yAxis : {
			title : {
				text : 'Comments'
			},
			
			allowDecimals : false,
			endOnTick : true,
			gridLineWidth : 2,
			min : 0,
			showFirstLabel : true,
 			startOnTick : true
		},
		
		tooltip : {
			formatter : function() {
				return '<strong>' + this.x + '</strong><br>' + this.y + ' comments';
			}
		},
				
		series : [{
			data : " . $commentsByDay . "
		}]
	});
});
</script>

";

//Display an overview of the statistics
	echo "<section class=\"stats\">
<div class=\"overview\">
<span class=\"comments\">" . $comments . "</span>
<span class=\"subText\">Comments</span>
<span class=\"date\">" . $date . "</span>
<span class=\"subText\">" . $dateType . "</span>
</div>

<div class=\"chart\" id=\"chart\"></div>
</section>

";

//Display the question, with buttons to edit or delete this question
	echo "<article class=\"question\">
" . $data['question'] . "

<div class=\"tools\">
<h2>" . $data['title'] . "</h2>

<div class=\"buttons\">
<button class=\"button blue\" onclick=\"javascript: document.location.href='manage_question.php?id=" . $data['id'] . "'\">Edit Question</button>
<button class=\"button red\">Delete Question</button>
</div>
</article>

";

//Display the comments
	echo "<article class=\"comments\">";

	$comments = unserialize(stripslashes($data['responses']));
	
	foreach($comments as $comment) {
		echo "
<div class=\"comment\">
<span class=\"arrow\"></span>

<div class=\"content\">
" . $comment['3'] . "
</div>

<div class=\"info\">
<span class=\"user\">" . $comment['0'] . " - <a href=\"mailto:" . $comment['1'] . "\">" . $comment['1'] . "</a></span>
<span class=\"date\">" . date("F jS, Y \a\\t h:i:s A", $comment['2']) . "</span>
</div>
</div>
";
	}
	
	echo "</article>";
	
//Include the footer from the administration template
	footer("admin");
?>