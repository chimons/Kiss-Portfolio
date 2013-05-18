<?php

session_start();


$identifiant="admin";
$mot_de_passe="admin";

require_once("m/Bdd.php");
require_once("util/util.php");

if (isset($_POST['login']) AND isset($_POST['password']) AND $_POST['login']==$identifiant AND $_POST['password']==$mot_de_passe ){
		$_SESSION['logged']=TRUE;
		header('Location: index.php');
	}
include ('v/v_header.php');	
if (!isset ($_SESSION['logged']) OR !$_SESSION['logged']){
	include ("v/v_login.php");
	exit();
	}

if (isset($_GET['logout'])){
		$_SESSION['logged']=FALSE;
	header('Location: index.php');
    exit();
}


if ($_SESSION['logged'])
{
	
	
	if (isset($_GET['module'])){
	
		switch ($_GET['module']){
			
			case "accueil":
				require ('c/c_accueil.php');
				break;
				
			case "categories":
				require ('c/c_categories.php');
				break;
				
			case "rubriques":
				require ('c/c_rubriques.php');
				break;
				
			case "articles":
				require ('c/c_articles.php');
				break;
					
			default : 	
				echo ("Il n'y a pas encore de page d'accueil. Utilisez le menu");
				break;
		}
	
	}
	else{
		echo ("Il n'y a pas encore de page d'accueil. Utilisez le menu");
	}
	include('v/v_footer.php');
}


	





	
