<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<?php echo $HTML; ?>
<link href="<?php echo $root; ?>themes/administration/simplistic/stylesheets/style.min.css" rel="stylesheet" />
<script src="<?php echo $root; ?>themes/administration/simplistic/javascripts/navigation.min.js"></script>
</head>

<body>
<nav class="admin">
<ul>
<li>
<section class="user">
<h2><?php echo $userData['firstName'] . " " . $userData['lastName']; ?></h2>

<div class="profile">
<a href="<?php echo $root; ?>admin/users/profile.php?id=<?php echo $userData['id']; ?>"><img src="<?php echo $root; ?>themes/administration/simplistic/images/avatar.jpg" /></a>
</div>

<div class="links">
<a href="<?php echo $root; ?>admin/users/profile.php?id=<?php echo $userData['id']; ?>">View Profile</a>
<br><br>
<a href="<?php echo $root; ?>admin/users/manage_user.php?id=<?php echo $userData['id']; ?>">Edit Profile</a>
<br><br>
<a href="<?php echo $root; ?>logout.php">Logout</a>
</div>
</section>
</li>

<li class="seperator"></li>

<li>
<ul class="<?php echo $main == "dashboard" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon home" href="<?php echo $root; ?>admin/index.php">Dashboard</a><?php echo $main == "dashboard" ? "<span class=\"arrow\"></span>" : ""; ?></li>
</ul>
</li>

<li>
<ul class="<?php echo $main == "collaboration" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon collaboration" href="<?php echo $root; ?>admin/collaboration/index.php">Collaboration</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/index.php">All Collaboration Items</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/manage_announcement.php">New Announcement</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/manage_agenda.php">New Agenda</a></li>
<li><a<?php echo $subpage == 4 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/manage_files.php">New File Share</a></li>
<li><a<?php echo $subpage == 5 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/manage_poll.php">New Poll</a></li>
<li><a<?php echo $subpage == 6 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/manage_forum.php">New Forum</a></li>
<li><a<?php echo $subpage == 7 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/collaboration/send_email.php">Send Email</a></li>
</ul>
</li>
</ul>
</li>

<li>
<ul class="<?php echo $main == "users" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon users" href="<?php echo $root; ?>admin/users/index.php">Users</a><span class="arrow"></span></li>
<li>

<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/users/index.php">All Users</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/users/manage_user.php">New User</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/users/privileges.php">User Privileges</a></li>
<li><a<?php echo $subpage == 4 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/users/failed.php">Failed Logins</a></li>
<li><a<?php echo $subpage == 5 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/users/search.php">Search for Users</a></li>
</ul>
</li>
</ul>
</li>

<li class="seperator"></li>

<li>
<ul class="<?php echo $main == "website" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon website" href="<?php echo $root; ?>admin/cms/index.php">Website</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/index.php">All Pages</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/manage_page.php">New Page</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/statistics/index.php">Site Statistics</a></li>
</ul>
</li>
</ul>
</li>

<li>
<ul class="<?php echo $main == "sidebar" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon sidebar" href="<?php echo $root; ?>admin/cms/sidebar/index.php">Sidebar</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/sidebar/index.php">All Sidebar Items</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/sidebar/manage_sidebar.php">New Sidebar Item</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/sidebar/sidebar_settings.php">Sidebar Settings</a></li>
</ul>
</li>
</ul>
</li>

<li>
<ul class="<?php echo $main == "external" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon external" href="<?php echo $root; ?>admin/cms/external/index.php">External Pages</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/external/index.php">All External Pages</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/external/manage_external.php">New External Page</a></li>
</ul>
</li>
</ul>
</li>

<li>
<ul class="<?php echo $main == "settings" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon settings" href="<?php echo $root; ?>admin/cms/site_settings.php">Site Settings</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/site_settings.php?type=meta">Site Information</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/site_settings.php?type=logo">Logo</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/site_settings.php?type=theme">Theme</a></li>
<li><a<?php echo $subpage == 4 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/site_settings.php?type=security">Security</a></li>
<li><a<?php echo $subpage == 5 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/cms/site_settings.php?type=icon">Browser Icon</a></li>
</ul>
</li>
</ul>
</li>

<li class="seperator"></li>

<li>
<ul class="<?php echo $main == "question" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon question" href="<?php echo $root; ?>admin/question-of-the-week/index.php">Weekly Question</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/question-of-the-week/index.php">All Questions</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/question-of-the-week/manage_question.php">New Question</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/question-of-the-week/statistics.php">Response Statistics</a></li>
</ul>
</li>
</ul>
</li>

<li>
<ul class="<?php echo $main == "exchange" ? "active" : "inactive"; ?>">
<li class="title"><a class="icon exchange" href="<?php echo $root; ?>admin/book-exchange/index.php">Book Exchange</a><span class="arrow"></span></li>

<li>
<ul>
<li><a<?php echo $subpage == 1 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/book-exchange/index.php">Manage Exchange</a></li>
<li><a<?php echo $subpage == 2 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/book-exchange/categories.php">Book Categories</a></li>
<li><a<?php echo $subpage == 3 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/book-exchange/listing.php">View All Books</a></li>
<li><a<?php echo $subpage == 4 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/book-exchange/users.php">View Exchange Users</a></li>
<li><a<?php echo $subpage == 5 ? " class=\"active\"" : ""; ?> href="<?php echo $root; ?>admin/book-exchange/my.php">View my Books</a></li>
</ul>
</li>
</ul>
</li>
</ul>
</nav>

<h1 class="<?php echo $headerClass; ?>"><?php echo $title; ?></h1>

<section class="body">