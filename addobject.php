<?php
session_start();
include "head.php";
include "functions.php";
include "conf.inc.php";
include "navbar.php";
$bdd = connectDB();
?>
<title>Ajouter mon objet</title>
<body>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<?php 
			if (isset($_SESSION['addObject'])) {
				if ($_SESSION['addObject']['etat'] == "NOK") {
					unset($_SESSION['addObject']['etat']);
					$contenu = "<ul>";
					foreach ($_SESSION['addObject'] as $key => $value) {
						$contenu = $contenu."<li>".$value."</li>";
					}
					$contenu = $contenu."</ul>";
					$etat = "Erreur";
				}else{
					$contenu = 
					"
					<div class='text-center'>
						<p>Votre objet a bien été ajouté</p>
						<p>Vous pouvez consulter son statut dans la rubrique <a href='#'>\"Mes objets\"</a></p>
					</div>
					";
					$etat = "Succès";
				}
				echo modal($etat,$contenu,'footer');
				unset($_SESSION['addObject']);
			}
			?>
			<h1 class="titleUnderlined">Ajouter mon objet</h1>
			<div class="jumbotron">
				<div class="row justify-content-center">
					<div class="col-lg-8">
						<form method="POST" action="script/script_addobject.php" enctype="multipart/form-data">
							<div class="form-row">
								<label for="categorie">Catégorie</label>
								<select id="categorie" name="categorie" class="form-control">
									<?php
									$categories = getCategories();
									foreach ($categories as $key => $value) {
										?>
										<option value="<?php echo $value['id']?>"><?php echo $value['name'];?>
										<?php
									}
									?>
								</select>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="1">Désignation</label>
									<input value="<?php if(isset($_POST['designation'])){ echo $_POST['designation'];}?>" type="text" id="1" class="form-control" placeholder="Nom de votre objet" name="designation">
								</div>						
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="2">Description</label>
									<textarea style="resize: none; height:12vh" id="2" placeholder="Décrivez votre objet" class="form-control" name="description"><?php if(isset($_POST['description'])){ echo $_POST['description'];}?></textarea>
								</div>	
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="3">Début de disponibilité</label>
									<input type="date" id="3" class="form-control" name="disponibilites" value="<?php if(isset($_POST['disponibilites'])){ echo $_POST['disponibilites'];}?>">
								</div>					
							</div>			
							<br>					
							<p class="text-center text-danger">Une photo minimum</p>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="5">Photo 1</label>
									<input type="file" id="5" class="form-control" name="firstPhoto">
								</div>
								<div class="form-group col-md-6">
									<label for="6">Photo 2</label>
									<input type="file" id="6" class="form-control" name="secondPhoto">
								</div>							
							</div>
							<div class="form-row justify-content-center">
								<div class="form-group">
									<input type="submit" value="Ajouter mon objet" class="btn btn-success">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
