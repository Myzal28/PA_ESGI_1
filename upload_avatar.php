<?php
session_start();
$type = explode("/", $_FILES['avatar']['type']);
switch ($type[1]) {
	case 'png':
		//
	case 'jpg':
		//
	case 'jpeg':
		//
		break;
	default:
		$_SESSION['uploadAvatar'][0] = "NOK";
		$_SESSION['uploadAvatar'][] = "Les seuls types de fichier acceptés sont jpg/jpeg et png";
		break;
}
if ($_FILES['avatar']['size'] >= 5000000) {
	$_SESSION['uploadAvatar'][0] = "NOK";
	$_SESSION['uploadAvatar'][] = "La taille maximale autorisée est de 5mo";
}
if ($_SESSION['uploadAvatar'][0] != "NOK") {
	copy($_FILES['avatar']['tmp_name'],"images/profils/".$_SESSION['email']."/photo.png");
	$_SESSION['uploadAvatar'][0] = "OK";
}
header("Location: modification_profil.php");
?>
