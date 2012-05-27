<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<?php echo $HTML; ?>
<link href="<?php echo $root; ?>themes/public/student_government/stylesheets/style.min.css" rel="stylesheet" />
<script src="<?php echo $root; ?>themes/public/student_government/javascripts/login_panel.min.js"></script>
</head>

<body>
<?php
//Include the login bar only if the user is logged out
	if (!loggedIn()) {
?>
<section class="login">
<div class="design">
<div class="login">
<form action="#" method="post">
<h2>Login</h2>
<p>Email address:</p><input name="username" type="email" />
<p>Password:</p><input name="password" type="password"/>
<input id="redirect" name="redirect" type="hidden" />
<br /><br />
<input class="red" type="submit" value="Login" />
</form>
</div>

<span class="toggle"></span>

<div class="register">
<form action="#" method="post">
<h2>Register</h2>
<p>First and last name:</p><input name="name" type="text" />
<p>Email address:</p><input name="email" type="email" />
<p>Password:</p><input name="username" type="password" />
<br /><br />
<input class="green" type="submit" value="Register" />
</form>
</div>
</div>
</section>

<?php
//Finish the login bar condition
	}
?>
<nav class="main">
<ul class="nav">
<li class="logo"><a href="<?php echo $root; ?>"><img src="<?php echo $root; ?>images/banner.png" /></a></li>
<?php echo $navigation; ?>
</ul>

<section class="flag">
<img class="tag" src="<?php echo $root; ?>themes/public/student_government/images/login.png" />
</section>
</nav>

