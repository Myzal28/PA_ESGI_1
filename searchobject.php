<?php
session_start();
include "head.php";
include "functions.php";
include "conf.inc.php";
isPrivate();
include "navbar.php";
$bdd = connectDB();
?>
<title>Rechercher un objet</title>
<body>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<h1 class="titleUnderlined">Rechercher un objet</h1>
			<div class="jumbotron">
				<div class="row justify-content-center">
					<form method="POST" class="form-inline">
						<input value="<?php if(isset($_POST['search'])){ echo $_POST['search'];}?>" type="search" style="width: 210px;" placeholder="Tapez votre recherche ici" name="search" class="form-control">
						<select name="categorie" class="form-control mx-2">
							<option value="all">Toutes catégories</option>
							<?php
							$categories = $bdd->query('SELECT * FROM categories');
							$categories = $categories->fetchAll(PDO::FETCH_ASSOC);
							foreach ($categories as $key => $value) {
								?>
								<option 
								<?php 
								if (isset($_POST['categorie'])) {
									if ($_POST['categorie'] == $value['id']) {
										echo "selected='selected'";
									}
								}
								?>
								value="<?php echo $value['id']?>"><?php echo $value['name'];?>
								<?php
							}
							?>
						</select>
						<input type="submit" value="Rechercher" class="btn btn-success">
					</form>
				</div>
				<br>
				<?php
				if (isset($_POST['search'])) {
					?>
					<div class="row justify-content-center">
						<div class="col-lg-11">
							<?php
							if ($_POST['categorie'] == 'all') {
								$recherche = $bdd->query('SELECT * FROM produit 
									WHERE nom_objet OR description LIKE "%'.$_POST['search'].'%"
									AND approbation="1"');
								$recherche = $recherche->fetchAll();

							}else{
								$recherche = $bdd->query('SELECT * FROM produit 
									WHERE nom_objet OR description LIKE "%'.$_POST['search'].'%" 
									AND categorie = '.$_POST['categorie'].'
									AND approbation="1"');
								$recherche = $recherche->fetchAll();
							}
							
							foreach ($recherche as $key => $value){
								showAnnounce($value['id']);
							}
							?>
						</div>
					</div>
					<?php
				}else{
					?>
					<div class="row justify-content-center">
						<h4 class="display-4">Les 5 dernières annonces...</h4>
						<div class="col-lg-11">
							<?php
							$annonces = $bdd->query('SELECT * FROM produit WHERE type="pret" AND approbation="1" ORDER BY dateHeure DESC LIMIT 0,5');
							$annonces = $annonces->fetchAll(PDO::FETCH_ASSOC);
							foreach ($annonces as $key => $value) {
								showAnnounce($value['id']);
							}
							?>
						</div>
					</div>
					<?php
				} 
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
