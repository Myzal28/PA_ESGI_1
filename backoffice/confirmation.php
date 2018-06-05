<?php
include("../head.php");
include("../conf.inc.php");
include("../functions.php");
$bdd = connectDB();
?>
<title>Voir les confirmations</title>
<?php include("headerBO.php"); ?>
<div class="row justify-content-center">
	<?php include("nav_backoffice.php"); ?>
	<div class="col-lg-10">
		<?php
		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'refuser') {
				$commentaire = "La demande a bien été refusée";
			}elseif($_GET['confirm'] == 'accepter') {
				$commentaire = "La demande a bien été acceptée";
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
		<table class="table table-striped table-hover text-center">
			<thead class="thead-dark">
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>E-mail</th>
					<th>Pseudo</th>
					<th>Statut</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = $bdd->query("SELECT * FROM user INNER JOIN confirmation ON user.pseudo = confirmation.pseudo_user WHERE approbation='1' OR approbation='3' OR approbation='0'");
				while ($reponse = $sql->fetch()){
					switch ($reponse['approbation']) {
						case '0':
							$reponse['approbation'] = "En attente";
							break;
						case '1':
							$reponse['approbation'] = "En attente de nouveaux justificatifs";
							break;
						case '2':
							$reponse['approbation'] = "Validée";
							break;
						case '3':
							$reponse['approbation'] = "Refusée";
							break;
					}
					?>
					<tr>
						<td><?php echo $reponse['nom']; ?></td>
						<td><?php echo $reponse['prenom']; ?></td>
						<td><?php echo $reponse['email']; ?></td>
						<td><?php echo $reponse['pseudo']; ?></td>
						<td><?php echo $reponse['approbation']; ?></td>
						<td>
							<form method="POST" action="view_confirmation.php">
								<input type="hidden" name="pseudo_user" value="<?php echo $reponse['pseudo_user']; ?>">
								<button class="btn btn-primary">Voir la demande</button>
							</form>
						</td>
					<tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>