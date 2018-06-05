
<?php
include("../head.php");
include("../conf.inc.php");
include("../functions.php");
$bdd = connectDB();
?>
<title>Gérer les utilisateurs</title>
<?php include("headerBO.php"); ?>
<div class="container-fluid">
<div class="row justify-content-center">
	<?php include("nav_backoffice.php"); ?>
	<div class="col-lg-10">
		<?php 
		if(isset($_POST['action'])){
			switch ($_POST['action']) {
				case 'moderateur':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été passé modérateur";
					$bdd->exec('UPDATE user SET role = 3 WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'user':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été passé utilisateur";
					$bdd->exec('UPDATE user SET role = 1 WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'admin':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été passé administrateur";
					$bdd->exec('UPDATE user SET role = 4 WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'ban':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été banni";
					$bdd->exec('UPDATE user SET role = 5 WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'unban':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été débanni";
					$bdd->exec('UPDATE user SET role = 1 WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'delete':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été supprimé";
					$bdd->exec('DELETE FROM user WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'confirmation':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été confirmé";
					$bdd->exec('UPDATE user SET role = 2 WHERE pseudo = "'.$_POST['pseudo'].'"');
					$bdd->exec('UPDATE confirmation SET approbation = 2 WHERE pseudo_user = "'.$_POST['pseudo'].'"');
					break;
				case 'activation':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été activé";
					$bdd->exec('UPDATE user SET role = 1 WHERE pseudo = "'.$_POST['pseudo'].'"');
					break;
				case 'unconfirm':
					$commentaire =  "L'utilisateur <b>".$_POST['pseudo']."</b> a bien été déconfirmé";
					$bdd->exec('UPDATE user SET role = 1 WHERE pseudo = "'.$_POST['pseudo'].'"');
					$bdd->exec('UPDATE confirmation SET approbation = 3 WHERE pseudo_user = "'.$_POST['pseudo'].'"');
					break;
				default: 
					break;
			}
			?>
			<script type="text/javascript">
			    $(window).on('load',function(){
			        $('#myModal').modal('show');
			    });
			</script>
			<div class="modal" id="myModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Confirmation</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p><?php echo $commentaire; ?></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<table class="table table-striped table-hover text-center table-responsive">
			<thead class="thead-dark">
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>E-mail</th>
					<th>Pseudo</th>
					<th>Statut	</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = $bdd->query("SELECT * FROM user");
				while ($reponse = $sql->fetch()){
					switch ($reponse['role']) {
						case '0':
							$role = 'Compte non activé';
							break;
						case '1':
							$role = 'Utilisateur activé';
							break;
						case '2':
							$role = 'Utilisateur confirmé';
							break;
						case '3':
							$role = 'Modérateur';
							break;
						case '4':
							$role = 'Admin';
							break;
						case '5':
							$role = 'Banni';
							break;
					}
					?>
					<tr>
						<td><?php echo $reponse['nom']; ?></td>
						<td><?php echo $reponse['prenom']; ?></td>
						<td><?php echo $reponse['email']; ?></td>
						<td><?php echo $reponse['pseudo']; ?></td>
						<td><?php echo $role; ?></td>
						<td style="width: 50%">
							<?php
							switch ($reponse['role']) {
								case '0':
									?>
									<form method="POST" class="form-inline">
										<select name="action" class="form-control select_user">
											<option>--- Séléctionner une option ---</option>
											<option value="activation">Activer</option>
											<option value="confirmation">Confirmer</option> 	
											<option value="moderateur">Passer modérateur</option>
											<option value="admin">Passer administrateur</option>
											<option value="delete">Supprimer</option>
											<option value="ban">Bannir</option>
										</select>
										<input type="hidden" value="<?php echo $reponse['pseudo']?>" name="pseudo">
										<input class="form-control btn btn-primary" type="submit" name="edit_user" value="Confirmer">
									</form>
									<?php
									break;
								case '1':
									?>
									<form method="POST" class="form-inline">
										<select name="action" class="form-control select_user">
											<option>--- Séléctionner une option ---</option>
											<option value="confirmation">Confirmer</option>
											<option value="moderateur">Passer modérateur</option>
											<option value="admin">Passer administrateur</option>
											<option value="delete">Supprimer</option>
											<option value="ban">Bannir</option>
										</select>
										<input type="hidden" value="<?php echo $reponse['pseudo']?>" name="pseudo">
										<input class="form-control btn btn-primary" type="submit" name="edit_user" value="Confirmer">
									</form>
									<?php
									break;
								case '2':
									?>
									<form method="POST" class="form-inline">
										<select name="action" class="form-control select_user">
											<option>--- Séléctionner une option ---</option>
											<option value="unconfirm">Déconfirmer</option>
											<option value="moderateur">Passer modérateur</option>
											<option value="admin">Passer administrateur</option>
											<option value="delete">Supprimer</option>
											<option value="ban">Bannir</option>
										</select>
										<input type="hidden" value="<?php echo $reponse['pseudo']?>" name="pseudo">
										<input class="form-control btn btn-primary" type="submit" name="edit_user" value="Confirmer">
									</form>
									<?php
									break;
								case '3':
									?>
									<form method="POST" class="form-inline">
										<select name="action" class="form-control select_user">
											<option>--- Séléctionner une option ---</option>
											<option value="user">Passer utilisateur</option>
											<option value="admin">Passer administrateur</option>
											<option value="delete">Supprimer</option>
											<option value="ban">Bannir</option>
										</select>
										<input type="hidden" value="<?php echo $reponse['pseudo']?>" name="pseudo">
										<input class="form-control btn btn-primary" type="submit" name="edit_user" value="Confirmer">
									</form>
									<?php
									break;
								case '4':
									?>
									<form method="POST" class="form-inline">
										<select name="action" class="form-control select_user">
											<option>--- Séléctionner une option ---</option>
											<option value="moderateur">Passer modérateur</option>
											<option value="user">Passer utilisateur</option>
											<option value="delete">Supprimer</option>
											<option value="ban">Bannir</option>
										</select>
										<input type="hidden" value="<?php echo $reponse['pseudo']?>" name="pseudo">
										<input class="form-control btn btn-primary" type="submit" name="edit_user" value="Confirmer">
									</form>
									<?php
									break;
								case '5':
									?>
									<form method="POST" class="form-inline">
										<select name="action" class="form-control select_user">
											<option>--- Séléctionner une option ---</option>
											<option value="unban">Débannir</option>
										</select>
										<input type="hidden" value="<?php echo $reponse['pseudo']?>" name="pseudo">
										<input class="form-control btn btn-primary" type="submit" name="edit_user" value="Confirmer">
									</form>
									<?php
									break;
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</div>
</body>
</html>