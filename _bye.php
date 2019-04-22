<?php
session_start();
require("_BDDconnect.php");
// sessions
$deconnect=verif("deconnect");
// Déconnexion
if($deconnect=="change") {
	session_destroy();
	header ("location:_admin/login.php");
} elseif($deconnect=="ok") {
	session_destroy();
	header ("location:index.php");
}
?>