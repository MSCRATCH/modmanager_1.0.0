<!DOCTYPE html>
<html lang="de">
<head>
<title>Modmanager</title>
<meta charset="utf-8">
<meta name="robots" content="INDEX,FOLLOW">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="pathologicalplay">
<meta name="revisit-after" content="2 days">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css" media="all" type="text/css">
<link rel="stylesheet" href="/fonts/fontawesome/css/all.min.css" />
<script src="js/menu.js" defer></script>
<script src="js/slideshow.js" defer></script>
</head>
<body>
<nav class="navbar">
<div class="brand-title">Modmanager</div>
<a href="#" class="toggle-button">
<span class="bar"></span>
<span class="bar"></span>
<span class="bar"></span>
</a>
<div class="navbar-links">
<ul>
<li><a href="index.php?section=categories">Home</a></li>
<li><a href="index.php?section=news">News</a></li>
<?php if (! Auth::isLoggedIn()) { ?>
<li><a href="index.php?section=login">Login</a></li>
<li><a href="index.php?section=register">Register</a></li>
<?php } ?>

<?php if (Auth::isAdministrator()) { ?>
<li class="dropdown">
<a href="#" class="dropdown-toggle">Administration</a>
<ul class="dropdown-menu">
<li><a href="index.php?section=user_management">Manage users</a></li>
<li><a href="index.php?section=create_file">Create file</a></li>
<li><a href="index.php?section=category_management">Manage categories</a></li>
<li><a href="index.php?section=news_management">Manage news</a></li>
<li><a href="index.php?section=file_management">Manage files</a></li>
<li><a href="index.php?section=error_log">Error log</a></li>
</ul>
</li>
<?php } ?>

<?php if (Auth::isLoggedIn()) { ?>
<?php $username_header = Auth::getUsername(); ?>
<?php $user_id_header = Auth::getUserId(); ?>

<li><a href="index.php?section=profile&id=<?php echo sanitize($user_id_header);?>"><?php echo sanitize_ucfirst($username_header);?></a></li>
<li><a href="index.php?section=manage_profile&id=<?php echo sanitize($user_id_header);?>">Settings</a></li>
<li><a href="index.php?section=logout">Logout</a></li>
<?php } ?>
</ul>
</div>
</nav>
<main>
