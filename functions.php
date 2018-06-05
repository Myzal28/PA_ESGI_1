<?php
function connectDB(){
	try{
		$connection = new PDO(
					DBDRIVER.":host=".DBHOST.";dbname=".DBNAME,
					DBUSER,
					DBPWD
						);
	}catch(Exception $e){
		die( "Erreur SQL ".$e->getMessage() );
	}
	return $connection;
}

function createToken($id, $email){

	$sha1 = sha1($email."FDSQfdsq444FGSDQ".$id."fdsfqfsdq");
	return substr($sha1, 4, 10) ;
}

function isConnected(){
	if(isset($_SESSION["auth"]) && $_SESSION["auth"]==true){
		$connection = connectDB();
		$query = $connection->prepare("SELECT id FROM user WHERE email = :toto");
		$query->execute([
						"toto"=>$_SESSION["email"]
					]);
		$resultat = $query->fetch();
		if($_SESSION["token"] == createToken($resultat["id"], $_SESSION["email"]) ){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function isPrivate(){
	if (!isConnected()) {
		header("Location: /Projet/signup.php?url=".urlencode($_SERVER["REQUEST_URI"]));
	}
}

function timeStamp($timestamp){
	$heure = explode(" ", $timestamp);
	$date = explode("-", $heure[0]);
	$heure = explode(":", $heure[1]);
	$date = $date[2]."/".$date[1]."/".$date[0];
	return $timestamp = array(
		'date' => $date,
		'heure' => $heure[0].":".$heure[1]
	);
}
function modal($titre,$texte,$footer){
	if ($footer == "footer") {
		$footer = "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fermer</button>";
	}
	$modal = 
	"<script type='text/javascript'>
		$(window).on('load',function(){
			$('#myModal').modal('show');
		});
	</script>
	<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
		<div class='modal-dialog' role='document'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='exampleModalLabel'>".$titre."</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body'>
					<p>".$texte."</p>
				</div>
				<div class='modal-footer'>
					".$footer."
				</div>
			</div>
		</div>
	</div>";
	return $modal;
}

function getPseudo($email){
	$connection = connectDB();
	$query = $connection->prepare("SELECT pseudo FROM user WHERE email = :toto");
	$query->execute([
					"toto"=>$email
				]);
	$resultat = $query->fetch();
	return $resultat['pseudo'];
}
function isAdmin(){
	$bdd = connectDB();
	$sql = $bdd->prepare("SELECT role FROM user WHERE email=:email");
	$sql->execute([
		"email" => $_SESSION['email']
	]);
	$sql = $sql->fetch();
	if (($sql['role'] == 3) || ($sql['role'] == 4)) {
		return true;
	}else{
		return false;
	}
}
function getCategories(){
	$bdd = connectDB();
	$sql = $bdd->query('SELECT * FROM categories');
	$sql = $sql->fetchAll(PDO::FETCH_ASSOC);
	return $sql;
}
function showAnnounce($idAnnonce){
	$bdd = connectDB();
	$annonce = $bdd->query('SELECT * FROM produit WHERE id='.$idAnnonce.'');
	$annonce = $annonce->fetch(PDO::FETCH_ASSOC);
	$dateHeure = timeStamp($annonce['dateHeure']);
	$villeUser = $bdd->query('SELECT ville FROM user WHERE pseudo="'.$annonce['pseudo_user'].'"');
	$villeUser = $villeUser->fetch(PDO::FETCH_ASSOC);
	if ($dateHeure['date'] == date("d/m/Y")) {
		$dateHeure['date'] = "Aujourd'hui";
	}
	$nbrImages = count(glob('image_objets/'.$annonce['id'].'/*.png'));
	$imageSize = getimagesize("image_objets/".$idAnnonce."/firstPhoto.png");
	$cheminPhoto = "image_objets/".$idAnnonce."/firstPhoto.png";
	if (($imageSize[0] / $imageSize[1]) > 1) {
		$image = "<img style='width:100%' src='".$cheminPhoto."'>";
	}else{
		$image = "<img height='200' src='".$cheminPhoto."'>";
	}
	echo $show = 
	"
	<div class='row justify-content-center'>
		<div class='col-lg-11'>
			<div class='row annonce'>
				<div class='col-lg-4 justify-content-center text-center' style='background-color: #DCDCDC;padding:0px'>
					".$image."
				</div>
				<div class='col-lg-8'>
					<p class='lead' style='font-size: 1.1rem;float:right;'>
						".$nbrImages." <i class='fas fa-images'></i>
					</p>
					<h2>".$annonce['nom_objet']."</h2>
					<p class='lead'> ".$annonce['description']."</p>
					<p> ".$annonce['pseudo_user']." - ".$villeUser['ville']." </p>
					<a href='LIEN ANNONCE' class='btn btn-success'>Voir l'annonce</a>
					<p style='float:right;'>
						".$dateHeure['date']." - ".$dateHeure['heure']."
					</p>
				</div>
			</div>
			<br>
		</div>
	</div>
	";
}











