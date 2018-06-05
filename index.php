<?php
session_start();
include("head.php");
include("conf.inc.php");
include("functions.php");
$bdd = connectDB();
?>
<title>Give It Back - Accueil</title>
<?php include("navbar.php"); 
if (isset($_GET['info'])) {
	switch ($_GET['info']) {
		case 'signup':
			echo modal("Information","Vous avez bien été inscrit, regardez vos mails pour activer votre compte !","footer");
			break;
		case 'activation':
			echo modal("Information","Votre compte a bien été activé","footer");
			break;
		default:
 			break;
	}
}
?>
<div class="container-fluid accueil">
	<div class="row justify-content-center accueil">
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner accueil">
		    <div class="carousel1 carousel-item text-carousel active">
		    	<div class="row justify-content-center text-center text-accueil">
			    	<h2 class="h1">Echangez</h2>
			      	<p class="lead">
				      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			  		</p>
			  		<button class="btn btn-secondary">En savoir plus</button>
		  		</div>
		    </div>
		    <div class="carousel2 carousel-item text-carousel">
		    	<div class="row justify-content-center text-center text-accueil">
			    	<h2 class="h1">Prêtez</h2>
			      	<p class="lead">
				      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			  		</p>
			  		<button class="btn btn-secondary">En savoir plus</button>
		  		</div>
		    </div>
		    <div class="carousel3 carousel-item text-carousel">
		    	<div class="row justify-content-center text-center text-accueil">
			    	<h2 class="h1">Recevez</h2>
			      	<p class="lead">
				      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			  		</p>
			  		<button class="btn btn-secondary">En savoir plus</button>
		  		</div>
		    </div>
		  </div>
		  <a class="carousel-control-prev" id="carousel-control" href="#carouselExampleControls" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" id="carousel-control" href="#carouselExampleControls" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</div>
</body>
</html>