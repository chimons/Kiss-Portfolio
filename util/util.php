<?php
function stop($a){echo '<pre>';print_r($a);exit('</pre>');}
function filter($in) {
	$search = array ('@[ ]@i','@[^a-zA-Z0-9,._]@i');
	$replace = array ('_','');
	echo $in;
	echo preg_replace($search, $replace, $in);
	return preg_replace($search, $replace, $in);
}

function taille_max_upload (){
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	return $upload_mb;
}

function nettoyer_nom_fichier($nom){
	$equivalents = array( 
             'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Å'=>'A', 'Ä'=>'A', 'Æ'=>'AE', 'Ç'=>'C', 
             'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ð'=>'Eth', 
             'Ñ'=>'N', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 
             'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 
     
             'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a', 'ä'=>'a', 'æ'=>'ae', 'ç'=>'c', 
             'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'eth', 
             'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 
             'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 
             
             'ß'=>'sz', 'þ'=>'thorn', 'ÿ'=>'y' 
         );
		 
	return  strtr($nom, $equivalents);

}

function get_extension($file) {
	$retour= strtolower(substr($file, '-3', '3'));
		return $retour;
}


function resize_img($filename, $destination) {
// largeur et hauteur maximale
$width = '258';
$height = '168';
// Cacul des nouvelles dimensions
list($width_orig, $height_orig) = getimagesize($filename);
if ($width && ($width_orig < $height_orig)) {
   $width = ($height / $height_orig) * $width_orig;
} else {
   $height = ($width / $width_orig) * $height_orig;
}
// Redimensionnement
$image_p = imagecreatetruecolor($width, $height);
	if (get_extension($filename) === 'jpg' OR get_extension($filename) === 'jpeg') {
		$image = imagecreatefromjpeg($filename);
	} elseif (get_extension($filename) === 'png') {
		$image = imagecreatefrompng($filename);
	} elseif (get_extension($filename) === 'gif') {
		$image = imagecreatefromgif($filename);
	}

imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
// Enregistrement
	if (get_extension($filename) === 'jpg') {
		imagejpeg($image_p, $destination, 100);
	} elseif (get_extension($filename) === 'png') {
		imagepng($image_p, $destination, 9);
	} elseif (get_extension($filename) === 'gif') {
		imagegif($image_p, $destination, 100);
	}
}

function traitement_fichier_upload($fichier, $type){
	global $messages;
	if ($type=='image') $extensions_autorisees = array('png', 'gif', 'jpg', 'jpeg');
	elseif ($type=='document') $extensions_autorisees = array('pdf', 'doc', 'docx', 'odt', 'png', 'gif', 'jpg', 'jpeg');
	else $extensions_autorisees = array(); 
	if ($fichier['error']==0){
		$fichier = basename($fichier['name']);
		
		
		
		
		$extension = get_extension($fichier);
		
		
		
		
		if(in_array($extension, $extensions_autorisees)){
			$fichier = nettoyer_nom_fichier($fichier);
			$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
			return $fichier;
		}
		else {
			$messages[]="Type de fichier incorrect";
			return FALSE;
		}
	}
	else{
		$messages[]="Erreur à l'upload";
		return FALSE;
	}
	
}

function valider_lien_article($lien){
	if (preg_match("#^http://|^https://|^documents/|^ftp://#" , $lien)){
		return $lien;
	}
	else{
		return "http://".$lien;
	}
}