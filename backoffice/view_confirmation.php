<?php
include("../head.php");
include("../conf.inc.php");
include("../functions.php");
$bdd = connectDB();
?>
<title>Voir une confirmations</title>
<div class="row justify-content-center">
	<?php include("nav_backoffice.php"); ?>
	<div class="col-lg-10">
		<?php
		if ((isset($_POST['refuser'])) OR (isset($_POST['accepter']))) {
			if (isset($_POST['refuser'])) {
				$bdd->exec('UPDATE confirmation SET approbation = 1 WHERE pseudo_user = "'.$_POST['pseudo_confirmation'].'"');
				header('Location: confirmation.php?confirm=refuser');
				// Insertion du commentaire
			}else{
				$bdd->exec('UPDATE user SET role = 2 WHERE pseudo = "'.$_POST['pseudo_confirmation'].'"');
				$bdd->exec('UPDATE confirmation SET approbation = 2 WHERE pseudo_user = "'.$_POST['pseudo_confirmation'].'"');
				header('Location: confirmation.php?confirm=accepter');
			}
		}elseif(isset($_POST['pseudo_user'])){
			$sql = $bdd->query("SELECT * FROM confirmation WHERE pseudo_user='".$_POST['pseudo_user']."'");
			$reponse = $sql->fetch();
			switch ($reponse['approbation']) {
				case '0':
					$etat = 'En attente';
					break;
				case '1':
					$etat = 'Refusée/En attente de nouveaux justificatifs';
					break;
				case '2':
					$etat = 'Validée';
					break;
				case '3':
					$etat = 'Refusée';
					break;
			}
			?>
			<p>Pseudo du demandeur : <?php echo $reponse['pseudo_user']; ?></p>
			<p>Etat de la demande : <?php echo $etat; ?></p>
			<img src="cni/<?php echo $reponse['image_cni']; ?>" width="50%" alt="Image non disponible">
			<form method="POST" class="form-inline">
				<input type="hidden" name="pseudo_confirmation" value="<?php echo $_POST['pseudo_user']; ?>">
				<input class="form-control select_user" type="text" name="commentaire" placeholder="Commentaire...">
				<input class="form-control btn btn-primary select_user" type="submit" name="refuser" value="Refuser">
				<input class="form-control btn btn-primary" type="submit" name="accepter" value="Accepter">
			</form>
			<?php
		}else{
			echo "Veuillez saisir une demande valide";
		}
		?>
	</div>
</div>
