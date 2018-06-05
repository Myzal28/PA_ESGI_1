<?php $page = str_replace(dirname($_SERVER['PHP_SELF']).'/', '', $_SERVER['PHP_SELF']); ?>
<div class="col-lg-2">
	<div class="list-group">

        <a class="list-group-item list-group-item-action <?php if($page == 'manage_approbations.php'){ echo "active";}?>" href="manage_approbations.php">
			<i class="fas fa-check-circle"></i> Approuver
		</a>
		<a class="list-group-item list-group-item-action <?php if($page == 'manage_demandes.php'){ echo "active";}?>" href="manage_demandes.php">
			<i class="fas fa-folder-open"></i> Gérer
		</a>
		<a class="list-group-item list-group-item-action <?php if(($page == 'confirmation.php') OR ($page == 'view_confirmation.php')){ echo "active";}?>" href="confirmation.php">
			<i class="fas fa-id-card"></i> Vérifications CNI
		</a>
		<a class="list-group-item list-group-item-action <?php if($page == 'gestion_user.php'){ echo "active";}?>" href="gestion_user.php">
			<i class="fas fa-users"></i> Gestion des utilisateurs
		</a>
	</div>
</div>