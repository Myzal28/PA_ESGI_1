<?php
session_start();
include "../head.php";
include "../functions.php";
include "../conf.inc.php";
$bdd = connectDB();
if (isset($_POST['categorie'])) {
	if(
		(count($_POST) == 4) &&
		(isset($_POST['categorie'])) &&
		(isset($_POST['designation'])) &&
		(isset($_POST['description'])) &&
		(isset($_POST['disponibilites'])) &&
		(isset($_FILES['firstPhoto'])) &&
		(isset($_FILES['secondPhoto']))
	){
		//Récupération de l'ID du dernier objet ajouté
		$lastItem = $bdd->query('SELECT id FROM produit ORDER BY id DESC');
		list($lastItem) = $lastItem->fetch();
		$lastItem++;

		//Récupération du nombre de catégories
		$nbrCategories = $bdd->query('SELECT COUNT(*) as nbrCategories FROM categories');
		list($nbrCategories) = $nbrCategories->fetch();

		//Gestion de la catégorie
		if (($_POST['categorie'] < 1) ||($_POST['categorie'] > $nbrCategories)){
			$_SESSION['addObject'][] = "Catégorie incorrecte";
			$error = true;
		}

		//Gestion de la désignation
		if ( (strlen($_POST['designation']) < 2) OR (strlen($_POST['designation']) > 30) OR (empty($_POST['designation']))) {
			$_SESSION['addObject'][] = "La désignation de votre objet doit faire entre 2 et 30 caractères" ;
			$error = true;
		}
		//Gestion de la date
		if(strpos( $_POST["disponibilites"] , "/")  ){
			list($day,$month,$year) = explode("/", $_POST["disponibilites"] );
			$dateFormat = true;
		}elseif(strpos( $_POST["disponibilites"] , "-")  ){
			list($year,$month,$day) = explode("-", $_POST["disponibilites"] );
			$dateFormat = true;
		}else{
			$_SESSION['addObject'][] = "Date incorrecte";
			$error = true;
		}

		//Vérifier si on a au moins une photo
		if (($_FILES['firstPhoto']['error'] != 0) && ($_FILES['secondPhoto']['error'] != 0)) {
			$_SESSION['addObject'][] = "Vous devez mettre au moins une photo";
			$error = true;
		}

		//Gestion de la première photo
		if ($_FILES['firstPhoto']['error'] == 0){
			$type = explode("/", $_FILES['firstPhoto']['type']);
			switch ($type[1]) {
				case 'png':
					//
				case 'jpg':
					//
				case 'jpeg':
					//
					break;
				default:
					$_SESSION['addObject']['errorPhoto1'] = "Les seuls types de fichiers acceptés sont jpg/jpeg et png";
					$error = true;
					break;
			}
			if ($_FILES['firstPhoto']['size'] >= 5000000) {
				$_SESSION['addObject']['errorPhoto2'] = "La taille maximale autorisée pour les photos est de 5mo";
				$error = true;
			}
		}

		// Gestion de la seconde photo
		if ($_FILES['secondPhoto']['error'] == 0) {
			$type = explode("/", $_FILES['secondPhoto']['type']);
			switch ($type[1]) {
				case 'png':
					//
				case 'jpg':
					//
				case 'jpeg':
					//
					break;
				default:
					$_SESSION['addObject']['errorPhoto1'] = "Les seuls types de fichiers acceptés sont jpg/jpeg et png";
					$error = true;
					break;
			}
			if ($_FILES['secondPhoto']['size'] >= 5000000) {
				$_SESSION['addObject']['errorPhoto2'] = "La taille maximale autorisée pour les photos est de 5mo";
				$error = true;
			}
		}

		// Si il n'y a pas d'erreur photo ni d'erreur formulaire
		if (!isset($error)) {
			//Insertion en base
			$insertionObjet = $bdd->prepare('INSERT INTO produit(`nom_objet`, `approbation`, `description`, `dateDisponibilite`, `pseudo_user`, `categorie`, `type`) VALUES (:nom , :approbation, :description, :dateDisponibilite, :pseudoUser, :categorie, :type)');
			$insertionObjet->execute([
				"nom" => $_POST['designation'],
				"approbation" => "0",
				"description" => $_POST['description'],
				"dateDisponibilite" => $_POST['disponibilites'],
				"pseudoUser" => getPseudo($_SESSION['email']),
				"categorie" => $_POST['categorie'],
				"type" => "pret"
			]);
			mkdir("../image_objets/".$lastItem);
			if (($_FILES['firstPhoto']['error'] == 0) && ($_FILES['secondPhoto']['error'] == 0)) {
				move_uploaded_file($_FILES['firstPhoto']['tmp_name'],"../image_objets/".$lastItem."/firstPhoto.png");
				move_uploaded_file($_FILES['secondPhoto']['tmp_name'],"../image_objets/".$lastItem."/secondPhoto.png");
			}elseif(($_FILES['firstPhoto']['error'] == 0) && ($_FILES['secondPhoto']['error'] != 0)){
				move_uploaded_file($_FILES['firstPhoto']['tmp_name'],"../image_objets/".$lastItem."/firstPhoto.png");
			}elseif(($_FILES['firstPhoto']['error'] != 0) && ($_FILES['secondPhoto']['error'] == 0)){
				move_uploaded_file($_FILES['secondPhoto']['tmp_name'],"../image_objets/".$lastItem."/firstPhoto.png");
			}
			$_SESSION['addObject']['etat'] = "OK";
		}else{
			$_SESSION['addObject']['etat'] = "NOK";
		}
	}else{
		echo "<h1 class='display-4 text-danger'>TENTATIVE DE  HACK</h1>";
		die();
	}
	//header("Location: ../addobject.php");
}
?>
