<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<?php echo $HTML; ?>
<link href="<?php echo $root; ?>themes/student_government/stylesheets/style.min.css" rel="stylesheet" />
<script src="<?php echo $root; ?>themes/student_government/javascripts/login_panel.min.js"></script>
</head>

<body>
<?php
//Include the login bar only if the user is logged out
	if (!loggedIn()) {
?>
<section class="login">
<div class="left">
<p>Log into your account or register today to gain access to special member-only features, such as our newly redesigned student book exchange!</p>
</div>
<div class="center">
<h2>Sign Up</h2>
<p>First and last name:</p>
<input type="text"/>
<p>Email address:</p>
<input type="email"/>
<p>Password:</p>
<input type="password"/>
<br /><br />
<input type="submit" value="Sign Up" />
</div>
<div class="right">
<h2>Login</h2>
<p>Email address:</p>
<input type="email"/>
<p>Password:</p>
<input type="password"/>
<br /><br />
<input type="submit" value="Login" />
</div>
</section>

<?php
//Finish the login bar condition
	}
?>
<nav class="main">
<ul>
<li class="logo"><a href="<?php echo $root; ?>"><img src="<?php echo $root; ?>images/banner.png" /></a></li>
<?php echo $navigation; ?>
</ul>

<section>
<h2><a class="highlight" href="<?php echo $root; ?>question-of-the-week">Question of the Week</a></h2>
<p>Our question for this week concerns certain...
<br /><a class="highlight" href="<?php echo $root; ?>question-of-the-week">Read more &amp; answer</a> &gt;&gt;</p>
<img class="tag" src="<?php echo $root; ?>themes/student_government/images/login.png" />
</section>
</nav>

