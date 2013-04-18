<?php
$id=(isset($_GET['id']) ? $_GET['id'] : "");
$action=NULL;
$titre = "";
$chapeau = "";
$active = NULL;


if (isset($_POST['poste'])){

	switch ($_POST['action']){
		case "ajouter":
				$id_categorie=ajouter_categorie($_POST["titre"], $_POST["chapeau"], $active=(isset($_POST['active'])? 1 : 0));
				
				if ($id_categorie){
					$action="consulter";
					$id=$id_categorie;
					$message="La catégorie a été correctement ajoutée.";
				}
				else{
					$action="ajouter";
					$message="L'insertion a échoué.";
				}
			break;
			
		case "modifier":
				$modifie=modifier_categorie($_POST["id"], $_POST["titre"], $_POST["chapeau"], $active=(isset($_POST['active'])? 1 : 0));
				
				if ($modifie){
					$action="consulter";
					$id=$_POST["id"];
					$message="La catégorie a été correctement éditée.";
				}
				else{
					$action="modifier";
					$message="La mise à jour a échoué";
				}
			
			break;
			
		default : 
				$message="Une erreur est survenue";
			break;
		}
}

if(isset($_GET['supprimer'])){
	$supprime=supprimer_une_categorie($id);
	if ($supprime){
					
					$message="La catégorie a été correctement supprimée.";
				}
				else{
					$action="consulter";
					$message="La suppression a échoué.";
				}
}

if(isset($_GET['ajouter']) AND $action!="consulter"){
	$action="ajouter";
}

if((isset($_GET['consulter']) && isset($_GET['id'])) OR $action=="consulter"){
	$action="consulter";
	$la_categorie=get_une_categorie($id);
	$cat_rubriques=get_rubriques($la_categorie['id_cat']);
}


if((isset($_GET['modifier']) AND isset($_GET['id']) AND $action!="consulter") OR ($action=="modifier")){
	$action="modifier";
	$la_categorie=get_une_categorie($id);
	$titre = $la_categorie['cat_titre'];
	$chapeau = $la_categorie['cat_chapeau'];
	$active = $la_categorie['active'];

}
$categories=get_categories();
$rubriques=get_toutes_les_rubriques();
$articles=get_tous_les_articles();
include ("v/v_categories.php");
