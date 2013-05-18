<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Portofolio de Chimon S.">
	<meta name="author" content="CHS">
	<meta name="robots" content="noindex">
	<title>Kiss Portfolio | your simplest portfolio</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" />
	<link rel="icon" type="image/png" href="images/fav65.png">
</head>

<body>

<!-- header-wrap -->
<div id="header-wrap">
	<header>

		<hgroup>
			<h1><a href="index.php">Kiss Portfolio</a></h1>
			<h3>your simplest portfolio</h3>
		</hgroup>
		
		<nav>
	 		 <ul>
				
		<?php if(isset($_SESSION['logged']) AND $_SESSION['logged']) { ?>
				<li><a href="index.php">Portfolio</a></li>
				<li><a href="admin.php?module=accueil">Accueil</a></li>
				<li><a href="admin.php?module=categories">Catégories</a></li>
				<li><a href="admin.php?module=rubriques">Rubriques</a></li>
				<li><a href="admin.php?module=articles">Articles</a></li>
				<li><a href="admin.php?logout">Déconnexion</a></li>
		<?php }
				else {?>
				<li><a href="admin.php">Espace Admin</a></li>
		<?php } ?>
			</ul>
		</nav>
	</header>
</div>

<!-- content-wrap -->
<div class="content-wrap">

	<!-- main -->
	<div class="light-bg">
	<section id="main" class="section-wrap">

	
