<?php
session_start();
require_once("_BDDconnect.php");
$login=verif("login");
$login_bdd=bdd("login");
$password=verif("password");
$ok="index.php";
$ko="login.php?auth=1";
$connection=verif("connection");
if($connection==="Identifier"&&$login){
	$hashed=md5($password.SEL);
	$sql=mysqli_query($connect,"SELECT user_id,email,password,date_naissance,users.actif,users.groupe_id,users.nom,prenom,groupes.nom AS groupe_nom FROM groupes INNER JOIN users ON groupes.groupe_id = users.groupe_id WHERE email='$login_bdd';");
	$row=mysqli_fetch_array($sql);
	if(mysqli_num_rows($sql)!=0&&$hashed==$row["password"]&&$row["actif"]==1){
		$_SESSION["user_id"]=$row["user_id"];
		$_SESSION["groupe_id"]=$row["groupe_id"];
		$_SESSION["email"]=$row["email"];
		$_SESSION["nom"]=$row["nom"];
		$_SESSION["prenom"]=$row["prenom"];
		$_SESSION["groupe_nom"]=$row["groupe_nom"];
		$anniv=new DateTime($row["date_naissance"]);
		$_SESSION["age"]=$anniv->diff(new DateTime())->format('%Y');
		header ("location:$ok");
		} else {header ("location:$ko");}
} else {header ("location:$ok");}
mysqli_close($connect);
?>