<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<link rel="shortcut icon" href="<?php echo $root; ?>/images/icon.gif" />
<link href="http://delfinicdn.ffstatic.com/stylesheets/delfini.all.min.css" rel="stylesheet" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo $root; ?>themes/public/student_government/stylesheets/style.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="http://delfinicdn.ffstatic.com/javascripts/delfini.all.min.js"></script>
<script src="<?php echo $root; ?>themes/public/student_government/javascripts/template.min.js.php"></script>
<script src="https://widget.uservoice.com/JkKcZfC4qw8m0wz3PeMf5Q.js"></script>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11478926-19']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php
//We will need the login encryption library to process login requests
    if (!loggedIn()) {
?>
<script src="<?php echo $root; ?>javascripts/common/md5.min.js"></script>
<?php
//Finish the encryption library condition
    }
?>
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
<input name="action" type="hidden" value="login" />
<br /><br />
<input class="red" type="submit" value="Login" />
<p><a href="<?php echo $root; ?>forgot_password.php">Forgot your password?</a></p>
</form>
</div>

<span class="toggle"></span>

<div class="register">
<form action="<?php echo $root; ?>login.php" method="post">
<h2>Register</h2>
<p>First and last name:</p><input autocomplete="off" name="name" type="text" />
<p>Email address:</p><input autocomplete="off" name="username" type="email" />
<p>Password:</p><input autocomplete="off" name="password" type="password" />
<input class="redirect" name="redirect" type="hidden" />
<input name="action" type="hidden" value="register" />
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
    if (loggedIn() && basename($_SERVER['PHP_SELF']) != "logout.php") {
?>
<li class="myAccount"><a href="<?php echo $root; ?>book-exchange/account">My Account</a></li>
<?php
//Include this if the user is an administrator
        //if ($userData['role'] == 'Administrator') { //Delete the line below once the administration is done
        if ($userData['role'] == 'Exotic') {
?>
<li class="admin"><a href="<?php echo $root; ?>admin/index.php">Administration</a></li>
<?php
//Finish the administrative tools condition
        }
//Finish the tools condition
    }
?>
</ul>

<section class="search">
<form action="<?php echo $root; ?>book-exchange/search/" method="get">
<input autocomplete="off" class="noMod search template" name="search" type="text" />
<input type="hidden" name="category" value="0" />
<input type="hidden" name="searchBy" value="title" />
<span class="performSearch"></span>
</form>
</section>

<?php
//The login flag will change depending on login status
    if (!loggedIn() || basename($_SERVER['PHP_SELF']) == "logout.php") {
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