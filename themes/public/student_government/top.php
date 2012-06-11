<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<link href="http://delfinicdn.ffstatic.com/stylesheets/delfini.all.min.css" rel="stylesheet" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo $root; ?>themes/public/student_government/stylesheets/style.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="http://delfinicdn.ffstatic.com/javascripts/delfini.all.min.js"></script>
<script src="<?php echo $root; ?>themes/public/student_government/javascripts/template.min.js.php"></script>
<script src="https://widget.uservoice.com/JkKcZfC4qw8m0wz3PeMf5Q.js"></script>
<?php echo $HTML; ?>
</head>

<body>
<?php
//Include the login bar only if the user is logged out
	if (!loggedIn()) {
?>
<section class="login">
<div class="design">
<div class="login">
<form action="<?php echo $root; ?>login.php" method="post">
<h2>Login</h2>
<p>Email address:</p><input autocomplete="off" name="username" type="email" />
<p>Password:</p><input autocomplete="off" name="password" type="password"/>
<input class="redirect" name="redirect" type="hidden" />
<br /><br />
<input class="red" type="submit" value="Login" />
</form>
</div>

<span class="toggle"></span>

<div class="register">
<form action="#" method="post">
<h2>Register</h2>
<p>First and last name:</p><input autocomplete="off" name="name" type="text" />
<p>Email address:</p><input autocomplete="off" name="email" type="email" />
<p>Password:</p><input autocomplete="off" name="username" type="password" />
<input class="redirect" name="redirect" type="hidden" />
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

<ul class="breadcrumb"><?php echo $breadCrumb; ?></ul>

<ul class="exchange">
<li><a href="<?php echo $root; ?>book-exchange/sell-books">Sell Books</a></li>
<li><a href="<?php echo $root; ?>book-exchange/search">Search</a></li>
<li><a href="<?php echo $root; ?>book-exchange/listings">Browse</a></li>
<?php
//Include the account and administration tools only if the user is logged in
	if (loggedIn()) {
		if ($userData['role'] == 'Administrator') {
?>
<li class="myAccount"><a href="<?php echo $root; ?>book-exchange/account">My Account</a></li>
<?php
//Finish the administrative tools condition
		}
?>
<li class="admin"><a href="<?php echo $root; ?>admin/index.php">Administration</a></li>
<?php
//Finish the tools condition
	}
?>
</ul>

<section class="search">
<form action="<?php echo $root; ?>book-exchange/search" method="get">
<input autocomplete="off" class="noMod search template" name="search" type="text" />
<input type="hidden" name="category" value="0" />
<input type="hidden" name="searchBy" value="Title" />
<span class="performSearch"></span>
</form>
</section>

<?php
//The login flag will change depending on login status
	if (!loggedIn()) {
?>
<section class="flag">
<img class="tag" src="<?php echo $root; ?>themes/public/student_government/images/login.png" />
</section>
<?php
	} else {
?>
<section class="flag">
<a href="<?php echo $root; ?>logout.php"><img class="tag" src="<?php echo $root; ?>themes/public/student_government/images/logout.png" /></a>
</section>
<?php
	}
?>
</nav>

