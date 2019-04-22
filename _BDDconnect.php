<?php
// SGBD
$connect=mysqli_connect("localhost","root","","ud"); // Connexion à MySQL
mysqli_query($connect,"SET NAMES 'utf8'");
// Sécurisation des fonctions
define("SEL", "@~#^}9{&(7!)?1.,:;é6èç3|`<>4/*-+É2r5i8c0");
// Transmission des données issues du formulaire
function verif($champs){
	return (isset($_REQUEST[$champs])) ? nl2br(htmlentities(htmlspecialchars($_REQUEST[$champs]), ENT_QUOTES, 'utf-8')) : NULL;
}
// Transmission des données issues d'une liste
function liste($champs){
	return (isset($champs)) ? nl2br(htmlentities(htmlspecialchars($champs), ENT_QUOTES, 'utf-8')) : NULL;
}
// Requêtes SQL
function bdd($data){
	$connect=mysqli_connect("localhost","root","","ud");
	return (isset($_REQUEST[$data])) ? mysqli_real_escape_string($connect,$_REQUEST[$data]) : NULL;
}
// Transmission des données issues d'une liste
function liste_bdd($data){
	$connect=mysqli_connect("localhost","root","","ud");
	return (isset($data)) ? mysqli_real_escape_string($connect,$data) : NULL;
}
// Vérification adresse mail
function emailvalid($login)
{
	$caractere='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
	if(preg_match($caractere,$login)) {
		return true;
	} else {
		return false;  
	}
}
// Remplacer accents
function suppaccent($nom) {
$search=array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý');
$replace=array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y');
return str_replace($search,$replace,$nom);
}
function verifsuppaccent($champs) {
	return (isset($_REQUEST[$champs])) ? nl2br(htmlentities(htmlspecialchars(suppaccent($_REQUEST[$champs])), ENT_QUOTES, 'utf-8')) : NULL;
}
// Gestion sécurisée des accents
function accentsecure($champs) {
	$trouve=array("&ccedil;","&amp;","&lt;","&gt;","&acirc;","&auml;","&agrave;","&ecirc;","&euml;","&eacute;","&egrave;","&icirc;","&iuml;","&ocirc;","&ouml;","&ucirc;","&uuml;","&Egrave;","&Eacute;","&Ecirc;","&Icirc;","&Ocirc;","&Uuml;");
	$remplace=array("ç","&","<",">","â","ä","à","ê","ë","é","è","î","ï","ô","ö","û","ü","È","É","Ê","Î","Ô","Ü");
	return str_replace($trouve,$remplace,verif($champs));
}
// Rafraîchissement de la page
function actualisation($delai) {
	$uri=$_SERVER['REQUEST_URI'];
	header("Refresh:$delai;url=$uri");
}
/* Debug (affichage des variables issues d'un formulaire/URI */
function affivar() {
	echo"<div style=\"font:14px Arial;background:#fff;color:#000;\">";
	if(!empty($_REQUEST)) {var_dump($_REQUEST);}
	echo"</div>";
}
// Extraction URI pour nom
function uri($lien) {
	if(isset($lien)) {
		if(strpos($lien,"/")===6) {
			preg_match('@^(?:https://)?([^/]+)@i',$lien,$matches);
		} else {
			preg_match('@^(?:http://)?([^/]+)@i',$lien,$matches);
		}
		$nom=$matches[1];
	}
	else {
		$nom=NULL;
	}
	return $nom;
}