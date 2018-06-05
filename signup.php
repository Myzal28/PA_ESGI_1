<?php
	session_start();
	include "head.php";
	require "conf.inc.php";
	require "functions.php";
	include "navbar.php";
	//VERIFICATION DE L'AUTHENTIFICATION
	if(isset($_POST["email"]) && isset($_POST["pwd"])){

		//Connexion a la bdd
		$connection = connectDB();
		//Récupérer le mot de passe hashé correspondant à $_POST["email"]
		$query = $connection->prepare("SELECT password,id FROM user WHERE email = :toto");
		$query->execute([
							"toto"=>$_POST["email"]
						]);
		$resultat = $query->fetch();
		//$resultat['pwd']
		//vérifier la correspondance entre le mot de passe
		//du input et le mot de passe hashé -> password_verify
		if( password_verify( $_POST["pwd"], $resultat['password'] )){
			//Si password_verify retourne true alors on va créer une session
			$_SESSION["auth"]=true;
			$_SESSION["email"] = $_POST["email"];
			$_SESSION["token"] = createToken($resultat['id'], $_POST['email']);

			if( isset($_GET["url"]) ){
				$urlRedirect = urldecode($_GET["url"]);
			}else{
				$urlRedirect = "index.php";
			}
			header("Location: ".$urlRedirect);

		}else{
			//Sinon Affichage d'une erreur
			echo modal("Erreur","Identifiants incorrects","footer");
			//Vérifier que le fichier auth.txt existe
			//a la racine de votre projet
			//S'il n'existe pas le créer
			//Ecrire a la suite la tentative de connexion
			$handle = fopen("auth.txt", "a");
			fwrite ( $handle , $_POST["email"]." -> ".$_POST["pwd"]."\r\n");
			fclose($handle);


		}
	}
?>
	<title>S'enregistrer/Se connecter</title>
	<div class="row decalageTop">
		<div class="col-md-4 ml-auto">
			<center><h2>S'inscrire</h2></center>

			<?php
				if( isset($_SESSION["errorsForm"]) ){
					foreach ($_SESSION["errorsForm"] as $keyError) {
						echo "<li style='color:red'>".$listOfErrors[$keyError]."</li>";
					}

					unset($_SESSION["errorsForm"]);
				}
				if (isset($_GET['url'])) {
					echo modal("Accès refusé","Veuillez vous connecter pour accéder à cette page","footer");
				}
			?>


			<form method="POST" action="script/saveUser.php">
					
				<?php
					//$listOfGender = [0=>"Monsieur", 1=>"Madame", 2=>"Autre"];
				?>

				
				<?php 
				foreach ($listOfGender as $key => $value) {
				?>

					<div class="form-check form-check-inline">
						<label class="form-check-label">
							
									<input class="form-check-input" 
									type="radio" 
									name="gender" 
									value="<?php echo $key;?>" 

									<?php
										if(isset($_SESSION["postForm"]["gender"]) && $_SESSION["postForm"]["gender"] == $key ){
											echo 'checked="checked"';
										} 
										else if($key == $defaultGender){
											echo 'checked="checked"';
										}
									?>

									<?php
										//Identique mais via une condition ternaire
										//echo ($key == $defaultGender)?'checked="checked"':'';
									?>

									>


									<?php echo $value;?>
						</label>
					</div>

				<?php
				}
				?>

					
				



				

				<div class="form-row">
				    
				    <div class=" form-group col">
				      <input type="text" class="form-control" placeholder="Prénom" name="firstname" required="required" 
				      value="<?php
				      	echo (isset($_SESSION["postForm"]["firstname"]))?
				      	$_SESSION["postForm"]["firstname"]
				      	:"";
				      ?>">
				    </div>



				    <div class="form-group col">
				      <input type="text" class="form-control" placeholder="Nom" name="lastname" required="required"
				      value="<?php
				      	echo (isset($_SESSION["postForm"]["lastname"]))?
				      	$_SESSION["postForm"]["lastname"]
				      	:"";
				      ?>">
				    </div>

				  </div>
				  <div class="form-group">			    
				    <input type="text" class="form-control" placeholder="Votre pseudo" name="pseudo" required="required"
				    value="<?php
				      	echo (isset($_SESSION["postForm"]["pseudo"]))?
				      	$_SESSION["postForm"]["pseudo"]
				      	:"";
				      ?>">
				  </div>
				  <div class="form-group">			    
				    <input type="text" class="form-control" placeholder="Votre ville" name="ville" required="required"
				    value="<?php
				      	echo (isset($_SESSION["postForm"]["ville"]))?
				      	$_SESSION["postForm"]["ville"]
				      	:"";
				      ?>">
				  </div>

				  <div class="form-row">
				    <div class="form-group col">
				      <input type="date" class="form-control" placeholder="Date d'anniversaire" name="birthday" required="required"
				      value="<?php
				      	echo (isset($_SESSION["postForm"]["birthday"]))?
				      	$_SESSION["postForm"]["birthday"]
				      	:"";
				      ?>"
				      >
				    </div>

				    <div class="form-group col">

				    	<select class="form-control"  name="country">
							
							<?php 
							foreach ($listOfCountry as $key => $value) {
							?>
								<option 
									value="<?php echo $key;?>" 
									<?php 
										if(isset($_SESSION["postForm"]["country"]) && $_SESSION["postForm"]["country"] == $key ){
											echo 'selected="selected"';
										} 
										else if($key == $defaultCountry){
											echo 'selected="selected"';
										}
									?>
									>

									<?php echo $value;?></option>
							<?php
							}
							?>
 
				    	</select>

				    	
				    </div>
				  </div>

				  <div class="form-group">			    
				    <input type="email" class="form-control" id="emailLogin" aria-describedby="emailHelp" placeholder="Votre email" name="email" required="required"
				    value="<?php
				      	echo (isset($_SESSION["postForm"]["email"]))?
				      	$_SESSION["postForm"]["email"]
				      	:"";
				      ?>">
				  </div>

				  <div class="form-group">			    
				    <input type="password" class="form-control"   placeholder="Mot de passe"
				     name="pwd" required="required">
				  </div>

				  <div class="form-group">			    
				    <input type="password" class="form-control"   placeholder="Confirmation"
				    name="pwdConfirm" required="required">
				  </div>


				  <div class="form-check">
				  	<label class="form-check-label">			    
					    <input type="checkbox" class="form-check-input" name="cgu" required="required">
					    J'accepte les CGUs de ce site
					</label>
				  </div>




				  
				

				<div class="form-row">
				    
				    <div class=" form-group col">			    
				  		<img src="captcha.php">
				  	</div>
				  	<div class=" form-group col">			    
				    	<input type="text" class="form-control"   placeholder="Confirmation"
				    	name="captcha" required="required">
				  	</div>
				 </div>

				  <button type="submit" class="btn btn-primary">S'inscrire</button>
			</form>
		</div>


		<?php 
			//supprime les valeurs du formulaire
			unset($_SESSION["postForm"]);
		?>





		<div class="col-md-4 mr-auto">
			<center><h2>Se connecter</h2></center>
			
			<form method="POST" >
			  
			  <div class="form-group">
			    <label for="emailLogin">Votre email</label>
			    
			    <input type="email" class="form-control" id="emailLogin" aria-describedby="emailHelp" name="email" placeholder="test@domain.fr">
			    
			  </div>


			  <div class="form-group">
			    <label for="pwdLogin">Mot de passe</label>
			    <input type="password" name="pwd" class="form-control" id="pwdLogin">
			  </div>


			  <button type="submit" class="btn btn-primary">Se connecter</button>

			</form>

		</div>
	</div>

<?php
	include "footer.php";
?>




