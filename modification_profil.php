<?php
session_start();
include "head.php";
include "functions.php";
include "conf.inc.php";
isPrivate();
include "navbar.php";
$bdd = connectDB();
$sql = $bdd->prepare("SELECT * FROM user WHERE email=:toto");
$sql->execute([
	"toto" => $_SESSION['email']
]);
$data = $sql->fetch();
if (isset($_SESSION['uploadAvatar'])) {
	if ($_SESSION['uploadAvatar'][0] == "OK") {
		$title = "Succès";
		$body = "Votre avatar a été upload avec succès";
	}elseif ($_SESSION['uploadAvatar'][0] == "NOK") {
		$title = "Erreur";
		$body = NULL;
		for ($i=1; $i < count($_SESSION['uploadAvatar']) ; $i++) { 
			$body = $body."<li>".$_SESSION['uploadAvatar'][$i]."</li>";
		}
	}
	echo modal($title,"<ul>".$body."</ul>","footer");
	unset($_SESSION['uploadAvatar']);
}
?>
<body>
	<div class="container">
		<h2 class="titleUnderlined">Modification de profil</h2>
		<br>
		<center>
			<img class="avatar" width="150" height="150" src="images/profils/<?php echo $data['email']; ?>/photo.png ">
		</center>
		<div class="row">
			<div class="col-md-12">
				<center>
					<form method="post" action="upload_avatar.php" enctype="multipart/form-data">
						<input type="file" name="avatar">
						<button class="btn btn-primary btn-send" type="submit" value="Envoyer">Uploader</button>
					</form>
				</center>
			</div>
			<form method="post">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Nom </label>
						<input class="form-control" type="text" name="new_name" value="<?php echo $data['nom'];?>" id="form_name">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Prenom </label>
						<input class="form-control" type="text" name="new_surname" value="<?php echo $data['prenom'];?>" id="form_lastname">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Pseudo</label>
						<input class="form-control" type="text" name="new_pseudo" value="<?php echo $data['pseudo'];?>" id="form_email">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Téléphone</label>
						<input class="form-control" type="number" name="new_phone" placeholder="Entrez un nouveau numéro de téléphone" id="form_phone">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label">Adresse</label>
						<input class="form-control" type="text" name="new_adress" placeholder="Entrez votre nouvelle adresse" id="form_adress">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<button class="btn btn-primary">Sauvegarder</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>