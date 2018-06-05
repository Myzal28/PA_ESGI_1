<?php
include("../head.php");
include("../conf.inc.php");
include("../functions.php");
$bdd = connectDB();
?>
<title>Approuver les demandes</title>
<?php include("headerBO.php"); ?>
<div class="row justify-content-center">
	<?php include("nav_backoffice.php");?>
	<div class="col-lg-10">
		<?php 
		if ((isset($_POST['delete'])) OR (isset($_POST['accepter']))) {
			if (isset($_POST['delete'])) {
				$commentaire = "La demande a bien été supprimée";
				//Suppression de l'objet en base et de l'image
			}else{
				$commentaire = "La demande a bien été acceptée"; 
				//Insertion SQL de l'approbation
			}
			echo modal('Information',$commentaire,'footer');
		}if (isset($_POST['view_approb'])) {
			$sql = $bdd->query("SELECT * FROM produit WHERE id=".$_POST['id_demande']."");
			$reponse = $sql->fetch(PDO::FETCH_ASSOC);
			$sql2 = $bdd->query("SELECT * FROM user WHERE pseudo='".$reponse['pseudo_user']."'");
			$reponse2 = $sql2->fetch(PDO::FETCH_ASSOC);
			$contenu = "
			<table class='table'>
				<tbody>
					<tr>
						<td>".$reponse2['nom']."</td>
						<td>".$reponse2['prenom']."</td>
					</tr>
					<tr>
						<td>".$reponse2['email']."</td>
						<td>".$reponse['pseudo_user']."</td>
					</tr>
					<tr class='text-center'>
						<td colspan='2'>".$reponse['nom_objet']."</td>
					</tr>					
					<tr class='text-center'>
						<td colspan='2'>".$reponse['description']."</td>
					</tr>
					<tr>
						<td class='text-center'><img src='../image_objets/".$reponse['id']."/firstPhoto.png' height='200px' ></td>
					</tr>
				</tbody>
			</table>";
			$footer="
			<button type='button' class='btn btn-primary' data-dismiss='modal'>Accepter</button>
			<button type='button' class='btn btn-danger' data-dismiss='modal'>Refuser</button>";
			echo modal('Demande',$contenu,$footer);
		}

		?>
		<table class="table table-striped table-hover text-center">
			<thead class="thead-dark">
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>E-mail</th>
					<th>Pseudo</th>
					<th>Objet</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = $bdd->query("SELECT * FROM produit WHERE approbation = 0 ORDER BY dateheure");
				while ($reponse2 = $sql->fetch()){
					$sql2 = $bdd->query("SELECT * FROM user WHERE pseudo='".$reponse2['pseudo_user']."'");
					while($reponse = $sql2->fetch()){
						$dateHeure = timeStamp($reponse2['dateHeure']);
						if ($dateHeure['date'] == date("d/m/Y")) {
							$dateHeure['date'] = "Aujourd'hui";
						}
						?>
						<tr>
							<td><?php echo $reponse['nom']; ?></td>
							<td><?php echo $reponse['prenom']; ?></td>
							<td><?php echo $reponse['email']; ?></td>
							<td><?php echo $reponse['pseudo']; ?></td>
							<td><?php echo $reponse2['nom_objet']; ?></td>
							<td><?php echo $dateHeure['date']." à ".$dateHeure['heure']; ?></td>
							<td>	
								<form method="POST">
									<input type="hidden" name="id_demande" value="<?php echo $reponse2['id']?>">
									<button name="view_approb" class="btn btn-primary">Voir</button>
								</form>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>