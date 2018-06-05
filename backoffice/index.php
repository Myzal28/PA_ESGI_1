<?php
include("../head.php");
include("../conf.inc.php");
include("../functions.php");
session_start();
isPrivate();
$bdd = connectDB();
?>
<title>Accueil Backoffice</title>
<?php include("headerBO.php"); ?>
<div class="row justify-content-center">
	<?php include("nav_backoffice.php"); ?>
	<div class="col-lg-10">
		<div class="jumbotron">
			<p class="lead">
				<h1>Bienvenue, <?php echo getPseudo($_SESSION['email']); ?></h1>
				<br>
				<p class="h2">Il y a actuellement :</p>
				<ul>
					<?php
					$nbrDemandes = $bdd->query('SELECT COUNT(*) FROM produit WHERE approbation = 0');
					$nbrDemandes = $nbrDemandes->fetch();
					$nbrCni = $bdd->query('SELECT COUNT(*) FROM confirmation WHERE approbation = 0');
					$nbrCni = $nbrCni->fetch();
					?>
					<li class="lead"><?php echo $nbrDemandes[0];?> demande(s) en attente d'approbation</li>
					<li class="lead"><?php echo $nbrCni[0];?> CNI en attente d'approbation</li>
				</ul>
			</p>
		</div>  
	</div>
</div>
</body>
</html>
