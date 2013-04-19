<?php
/*!
 * Medoo database framework
 * http://medoo.in
 * 
 * Copyright 2013, Angel Lai
 * Released under the MIT license
 */
class medoo 
{
	protected $database_type = 'sqlite';
	public function __construct($database_name){try{$type=strtolower($this->database_type);switch($type){case 'mysql':case 'pgsql':$this->pdo=new PDO($type.':host='.$this->server.';dbname='.$database_name,$this->username,$this->password);break;case 'mssql':case 'sybase':$this->pdo=new PDO($type.':host='.$this->server.';dbname='.$database_name.','.$this->username.','.$this->password);break;case 'sqlite':$this->pdo=new PDO($type.':'.$database_name);break;}}catch(PDOException $e){echo $e->getMessage();}}public function query($query){$this->queryString=$query;return $this->pdo->query($query);}public function exec($query){$this->queryString=$query;return $this->pdo->exec($query);}public function quote($string){return $this->pdo->quote($string);}protected function array_quote($array){$temp=array();foreach($array as $value){$temp[]=is_int($value)?$value:$this->pdo->quote($value);}return implode($temp,',');}protected function inner_conjunct($data,$conjunctor,$outer_conjunctor){$haystack=array();foreach($data as $value){$haystack[]='('.$this->data_implode($value,$conjunctor).')';}return implode($outer_conjunctor.' ',$haystack);}protected function data_implode($data,$conjunctor,$outer_conjunctor=null){$wheres=array();foreach($data as $key=>$value){if(($key=='AND'||$key=='OR')&&is_array($value)){$wheres[]=0!==count(array_diff_key($value,array_keys(array_keys($value))))?'('.$this->data_implode($value,' '.$key).')':'('.$this->inner_conjunct($value,' '.$key,$conjunctor).')';}else{preg_match('/([\w]+)(\[(\>|\>\=|\<|\<\=|\!|\<\>)\])?/i',$key,$match);if(isset($match[3])){if($match[3]==''||$match[3]=='!'){$wheres[]=$match[1].' '.$match[3].'= '.$this->quote($value);}else{if($match[3]=='<>'){if(is_array($value)&&is_numeric($value[0])&&is_numeric($value[1])){$wheres[]=$match[1].' BETWEEN '.$value[0].' AND '.$value[1];}}else{if(is_numeric($value)){$wheres[]=$match[1].' '.$match[3].' '.$value;}}}}else{if(is_int($key)){$wheres[]=$this->quote($value);}else{$wheres[]=is_array($value)?$match[1].' IN ('.$this->array_quote($value).')':$match[1].' = '.$this->quote($value);}}}}return implode($conjunctor.' ',$wheres);}public function where_clause($where){$where_clause='';if(is_array($where)){$single_condition=array_diff_key($where,array_flip(array('AND','OR','GROUP','ORDER','HAVING','LIMIT','LIKE','MATCH')));if($single_condition!=array()){$where_clause=' WHERE '.$this->data_implode($single_condition,'');}if(isset($where['AND'])){$where_clause=' WHERE '.$this->data_implode($where['AND'],' AND ');}if(isset($where['OR'])){$where_clause=' WHERE '.$this->data_implode($where['OR'],' OR ');}if(isset($where['LIKE'])){$like_query=$where['LIKE'];if(is_array($like_query)){if(isset($like_query['OR'])||isset($like_query['AND'])){$connector=isset($like_query['OR'])?'OR':'AND';$like_query=isset($like_query['OR'])?$like_query['OR']:$like_query['AND'];}else{$connector='AND';}$clause_wrap=array();foreach($like_query as $column=>$keyword){if(is_array($keyword)){foreach($keyword as $key){$clause_wrap[]=$column.' LIKE '.$this->quote('%'.$key.'%');}}else{$clause_wrap[]=$column.' LIKE '.$this->quote('%'.$keyword.'%');}}$where_clause.=($where_clause!=''?' AND ':' WHERE ').'('.implode($clause_wrap,' '.$connector.' ').')';}}if(isset($where['MATCH'])){$match_query=$where['MATCH'];if(is_array($match_query)&&isset($match_query['columns'])&&isset($match_query['keyword'])){$where_clause.=($where_clause!=''?' AND ':' WHERE ').' MATCH ('.implode($match_query['columns'],', ').') AGAINST ('.$this->quote($match_query['keyword']).')';}}if(isset($where['GROUP'])){$where_clause.=' GROUP BY '.$where['GROUP'];}if(isset($where['ORDER'])){$where_clause.=' ORDER BY '.$where['ORDER'];if(isset($where['HAVING'])){$where_clause.=' HAVING '.$this->data_implode($where['HAVING'],'');}}if(isset($where['LIMIT'])){if(is_numeric($where['LIMIT'])){$where_clause.=' LIMIT '.$where['LIMIT'];}if(is_array($where['LIMIT'])&&is_numeric($where['LIMIT'][0])&&is_numeric($where['LIMIT'][1])){$where_clause.=' LIMIT '.$where['LIMIT'][0].','.$where['LIMIT'][1];}}}else{if($where!=null){$where_clause.=' '.$where;}}return $where_clause;}public function select($table,$columns,$where=null){if(is_callable($where)&&$callback==null){$callback=$where;$where='';}$query=$this->query('SELECT '.(is_array($columns)?implode(', ',$columns):$columns).' FROM '.$table.$this->where_clause($where));return $query?$query->fetchAll((is_string($columns)&&$columns!='*')?PDO::FETCH_COLUMN:PDO::FETCH_ASSOC):false;}public function insert($table,$data){$keys=implode(',',array_keys($data));$values=array();foreach($data as $key=>$value){$values[]=is_array($value)?serialize($value):$value;}$this->query('INSERT INTO '.$table.' ('.$keys.') VALUES ('.$this->data_implode(array_values($values),',').')');return $this->pdo->lastInsertId();}public function update($table,$data,$where=null){$fields=array();foreach($data as $key=>$value){if(is_array($value)){$fields[]=$key.'='.$this->quote(serialize($value));}else{preg_match('/([\w]+)(\[(\+|\-)\])?/i',$key,$match);if(isset($match[3])){if(is_numeric($value)){$fields[]=$match[1].' = '.$match[1].' '.$match[3].' '.$value;}}else{$fields[]=$key.' = '.$this->quote($value);}}}return $this->exec('UPDATE '.$table.' SET '.implode(',',$fields).$this->where_clause($where));}public function delete($table,$where){return $this->exec('DELETE FROM '.$table.$this->where_clause($where));}public function replace($table,$columns,$search=null,$replace=null,$where=null){if(is_array($columns)){$replace_query=array();foreach($columns as $column=>$replacements){foreach($replacements as $replace_search=>$replace_replacement){$replace_query[]=$column.' = REPLACE('.$column.', '.$this->quote($replace_search).', '.$this->quote($replace_replacement).')';}}$replace_query=implode(', ',$replace_query);$where=$search;}else{if(is_array($search)){$replace_query=array();foreach($search as $replace_search=>$replace_replacement){$replace_query[]=$columns.' = REPLACE('.$columns.', '.$this->quote($replace_search).', '.$this->quote($replace_replacement).')';}$replace_query=implode(', ',$replace_query);$where=$replace;}else{$replace_query=$columns.' = REPLACE('.$columns.', '.$this->quote($search).', '.$this->quote($replace).')';}}return $this->exec('UPDATE '.$table.' SET '.$replace_query.$this->where_clause($where));}public function get($table,$columns,$where=null){if(is_array($where)){$where['LIMIT']=1;}$data=$this->select($table,$columns,$where);return isset($data[0])?$data[0]:false;}public function has($table,$where){return $this->query('SELECT EXISTS(SELECT 1 FROM '.$table.$this->where_clause($where).')')->fetchColumn()==='1';}public function count($table,$where=null){return 0 +($this->query('SELECT COUNT(*) FROM '.$table.$this->where_clause($where))->fetchColumn());}public function max($table,$column,$where=null){return 0 +($this->query('SELECT MAX('.$column.') FROM '.$table.$this->where_clause($where))->fetchColumn());}public function min($table,$column,$where=null){return 0 +($this->query('SELECT MIN('.$column.') FROM '.$table.$this->where_clause($where))->fetchColumn());}public function avg($table,$column,$where=null){return 0 +($this->query('SELECT AVG('.$column.') FROM '.$table.$this->where_clause($where))->fetchColumn());}public function sum($table,$column,$where=null){return 0 +($this->query('SELECT SUM('.$column.') FROM '.$table.$this->where_clause($where))->fetchColumn());}public function error(){return $this->pdo->errorInfo();}public function last_query(){return $this->queryString;}public function version(){return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);}public function info(){return $this->pdo->getAttribute(PDO::ATTR_SERVER_INFO);}}
/* END MEDOO */


$database = new medoo('m/database.sqlite');

function get_categories(){
	try{
	global $database;
	$categories=$database->select("categories", "*", array("ORDER"=>"cat_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des categories';
		exit();
	}
	return $categories;
}

function get_categories_publiees(){
	try{
	global $database;
	$categories=$database->select("categories", "*", array("active"=>1, "ORDER"=>"cat_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des categories';
		exit();
	}
	return $categories;
}

function get_texte_accueil(){
	try{
	global $database;
	$accueil=$database->get("accueil", "*");
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation du texte d\'accueil';
		exit();
	}
	return $accueil;
}


function modifier_texte_accueil($titre, $intro, $titre_colonne1, $texte_colonne1, $titre_colonne2, $texte_colonne2, $titre_colonne3, $texte_colonne3, $legende_image_1, $legende_image_2, $legende_image_3, $url_image_1, $url_image_2, $url_image_3){
	try{
	global $database;
	$insertion=$database->update("accueil", array("titre"=>$titre, "intro"=>$intro, "titre_colonne1"=>$titre_colonne1, "texte_colonne1"=>$texte_colonne1, "titre_colonne2"=>$titre_colonne2, "texte_colonne2"=>$texte_colonne2, "titre_colonne3"=>$titre_colonne3, "texte_colonne3"=>$texte_colonne3, "legende_image_1"=>$legende_image_1, "legende_image_2"=>$legende_image_2, "legende_image_3"=>$legende_image_3, "url_image_1"=>$url_image_1, "url_image_2"=>$url_image_2, "url_image_3"=>$url_image_3));
	}
	catch(Exception $e)
	{
		echo 'Echec à l\'ajout du texte';
		exit();
	}
	return $insertion;
}

function get_une_categorie($id_cat){
	try{
	global $database;
	$la_categorie=$database->get("categories", "*", array("id_cat"=>$id_cat, "ORDER"=>"cat_position"));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation de la categories';
		exit();
	}
	return $la_categorie;
}

function supprimer_une_categorie($id){
	try{
	global $database;
	$supprime=$database->delete("categories",  array("id_cat"=>$id));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la suppression de la categories';
		exit();
	}
	return $supprime;
}


function supprimer_une_rubrique($id){
	try{
	global $database;
	$supprime=$database->delete("rubriques",  array("id_rubrique"=>$id));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la suppression de la rubrique';
		exit();
	}
	return $supprime;
}


function supprimer_un_article($id){
	try{
	global $database;
	$supprime=$database->delete("articles",  array("id_article"=>$id));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la suppression de la categories';
		exit();
	}
	return $supprime;
}

function get_titre_categorie($id_cat){
	try{
	global $database;
	$la_categorie=$database->get("categories", "cat_titre", array("id_cat"=>$id_cat));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation de la categories';
		exit();
	}
	return $la_categorie;
}

function get_libelle_type_lien($code){
	try{
	global $database;
	$libelle=$database->get("types_liens", "libelle", array("code"=>$code));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation de la categories';
		exit();
	}
	return $libelle;
}

function get_titre_rubrique($id_rub){
	try{
	global $database;
	$la_categorie=$database->get("rubriques", "rub_titre", array("id_rub"=>$id_rub));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation de la categories';
		exit();
	}
	return $la_categorie;
}

function ajouter_categorie($titre, $chapeau, $active){
	try{
	global $database;
	$insertion=$database->insert("categories", array("cat_titre"=>$titre, "cat_chapeau"=>$chapeau, "active"=>$active));
	}
	catch(Exception $e)
	{
		echo 'Echec à l ajout de categorie';
		exit();
	}
	return $insertion;
}

function modifier_categorie($id, $titre, $chapeau, $active){
	try{
	global $database;
	$insertion=$database->update("categories", array("cat_titre"=>$titre, "cat_chapeau"=>$chapeau, "active"=>$active), array("id_cat"=>$id));
	}
	catch(Exception $e)
	{
		echo 'Echec à l ajout de categorie';
		exit();
	}
	return $insertion;
}

function ajouter_rubrique($id_cat, $titre, $texte, $vignette, $active){
	try{
	global $database;
	$insertion=$database->insert("rubriques", array("id_cat"=>$id_cat, "rub_titre"=>$titre, "rub_texte"=>$texte, "rub_image"=>$vignette, "active"=>$active));
	}
	catch(Exception $e)
	{
		echo 'Echec à l ajout de rubrique';
		exit();
	}
	return $insertion;
}

function modifier_rubrique($id, $id_cat, $titre, $texte, $vignette, $active){
	try{
	global $database;
	$insertion=$database->update("rubriques", array("id_cat"=>$id_cat, "rub_titre"=>$titre, "rub_texte"=>$texte, "rub_image"=>$vignette, "active"=>$active), array("id_rubrique"=>$id));
	}
	catch(Exception $e)
	{
		echo 'Echec à l ajout de rubrique';
		exit();
	}
	return $insertion;
}

function ajouter_article($id_rubrique, $titre, $url, $art_type_lien, $texte, $active){
	try{
	global $database;
	$insertion=$database->insert("articles", array("id_rubrique"=>$id_rubrique, "art_titre"=>$titre, "art_url"=>$url, "art_type_lien"=>$art_type_lien, "art_texte"=>$texte, "active"=>$active));
	}
	catch(Exception $e)
	{
		echo 'Echec à l ajout de l\'article';
		exit();
	}
	return $insertion;
}

function modifier_article($id, $id_rubrique, $titre, $url, $art_type_lien, $texte, $active){
	try{
	global $database;
	$insertion=$database->update("articles", array("id_rubrique"=>$id_rubrique, "art_titre"=>$titre, "art_url"=>$url, "art_type_lien"=>$art_type_lien, "art_texte"=>$texte, "active"=>$active), array("id_article"=>$id));
	}
	catch(Exception $e)
	{
		echo 'Echec à la mise à jour de l\'article';
		exit();
	}
	return $insertion;
}

function get_rubriques($idCat){
	try{
	global $database;
	$rubriques=$database->select("rubriques", "*", array("id_cat"=>$idCat, "ORDER"=>"rub_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des rubriques';
		exit();
	}
	return $rubriques;
}

function get_rubriques_publiees($idCat){
	try{
	global $database;
	$rubriques=$database->select("rubriques", "*", array("AND"=>array("id_cat"=>$idCat, "active"=>1), "ORDER"=>"rub_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des rubriques';
		exit();
	}
	return $rubriques;
}

function get_une_rubrique($id_rub){
	try{
	global $database;
	$rubrique=$database->get("rubriques", "*", array("AND"=>array("id_rubrique"=>$id_rub), "ORDER"=>"rub_position"));
	//echo $database->last_query();
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des rubriques';
		exit();
	}
	return $rubrique;
}

function get_toutes_les_rubriques(){
	try{
	global $database;
	$rubriques=$database->select("rubriques", "*", array("ORDER"=>"rub_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des rubriques';
		exit();
	}
	return $rubriques;
}



function get_articles($idRubrique){
	try{
	global $database;
	$articles=$database->select("articles", "*", array("id_rubrique"=>$idRubrique, "ORDER"=>"art_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des articles';
		exit();
	}
	return $articles;
}

function get_tous_les_articles(){
	try{
	global $database;
	$articles=$database->select("articles", "*", array("ORDER"=>"art_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des articles';
		exit();
	}
	return $articles;
}

function get_types_liens(){
	try{
	global $database;
	$articles=$database->select("types_liens", "*");
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des articles';
		exit();
	}
	return $articles;
}

function get_un_article($id){
	try{
	global $database;
	$article=$database->get("articles", "*", array("id_article"=>$id, "ORDER"=>"art_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des articles';
		exit();
	}
	return $article;
}

function get_articles_publies($idRubrique){
	try{
	global $database;
	$articles=$database->select("articles", "*", array("AND"=>array("id_rubrique"=>$idRubrique, "active"=>1), "ORDER"=>"art_position"));
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des articles';
		exit();
	}
	return $articles;
}

function get_infos(){
	try{
	global $database;
	$infos=$database->get("infos", "*");	
	}
	catch(Exception $e)
	{
		echo 'Echec de la recuperation des infos';
		exit();
	}
	return $infos;
}
