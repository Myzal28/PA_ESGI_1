  <?php
	session_start();

	require "../conf.inc.php";
	require "../functions.php";

	
	 
	// Doit avoir 9 champs
	// Vérifier que les champs: firstname, lastname, ... existent (et non vide)
	if( count($_POST) == 12
		&& !empty($_POST["firstname"]) 	
		&& !empty($_POST["lastname"]) 
		&& !empty($_POST["email"]) 
		&& !empty($_POST["captcha"]) 
		&& !empty($_POST["pwd"]) 
		&& !empty($_POST["pwdConfirm"]) 
		&& !empty($_POST["country"]) 
		&& isset($_POST["gender"]) 
		&& !empty($_POST["birthday"]) 
		&& !empty($_POST["cgu"]) 
		&& !empty($_POST["pseudo"])
		&& !empty($_POST["ville"])
	){
		
		$error = false;
		$listOfErrors = [];

		//Nettoyage des chaînes
		
		$_POST["firstname"] = ucfirst( strtolower(trim($_POST["firstname"]))) ;
		$_POST["lastname"] = strtoupper(trim($_POST["lastname"])) ;
		$_POST["email"] = strtolower(trim($_POST["email"])) ;
		$_POST["birthday"] = trim($_POST["birthday"]);
		$_POST["captcha"] = strtolower($_POST["captcha"]) ;
		$_POST["ville"] = trim($_POST['ville']);
		//Vérifier les champs un par un

			//gender : soit 0,1,2
			if( !array_key_exists($_POST["gender"], $listOfGender)  ){
				$error = true;
				$listOfErrors[]=1;
			}
			//firstname : min 2 max 25
			if( strlen($_POST["firstname"])<2 || strlen($_POST["firstname"])>25  ){
				$error = true;
				$listOfErrors[]=2;
			}
			if(strlen($_POST["ville"])>100){
				$error = true;
				$listOfErrors[]=13;
			}
			//lastname : min 2 max 125
			if( strlen($_POST["lastname"])<2 || strlen($_POST["lastname"])>125  ){
				$error = true;
				$listOfErrors[]=3;
			}

			//email : format valide
			if( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)   ){
				$error = true;
				$listOfErrors[]=4;
			}else{
				//Vérification d'unicité
				//SELECT id FROM users WHERE email="$_POST['email']";
				$connection = connectDB();

				$query = $connection->prepare("SELECT id 
								FROM users WHERE email=:email");

				$query->execute([
										"email"=>$_POST["email"]
									]);

				//Permet de récupérer toutes les données de ma 
				//requête sql sous forme de tableau
				$results = $query->fetchAll();

				if( !empty($results) ){
					$error = true;	
					$listOfErrors[]=11;
				}

			}
			
			//birthday : a faire ensemble
			//2017-02-01 ou 01/02/2017
			//yyyy-mm-dd ou dd/mm/yyyy

			$dateFormat = false;

			if(strpos( $_POST["birthday"] , "/")  ){
				list($day,$month,$year) = explode("/", $_POST["birthday"] );
				$dateFormat = true;
			}else if( strpos( $_POST["birthday"] , "-")  ){
				list($year,$month,$day) = explode("-", $_POST["birthday"] );
				$dateFormat = true;
			}else{
				$error = true;
				$listOfErrors[]=5;
			}

			// -> explode : permet de couper une chaîne
			//est ce que la date est valide : exemple 30/02/2017
			// -> bool checkdate ( int $month , int $day , int $year )
			if($dateFormat){
				if( is_numeric($month) 
				&& is_numeric($day)
				&& is_numeric($year)
				&& checkdate ( $month , $day , $year ) ){

					//Vérifier que l'internaute a entre 18 et 100 ans
					//echo time();
					$today = time();
					$birthday = mktime(0,0,0,$month,$day,$year);
					$time18years = $today - 18*3600*24*365;
					$time100years = $today - 100*3600*24*365;

					if( $birthday > $time18years || $birthday < $time100years){
						$error = true;
						$listOfErrors[]=6;
					}
				}else{
					$error = true;
					$listOfErrors[]=7;
				}
			}

			


			//country : soit fr, soit pl, soit ru
			if( !array_key_exists($_POST["country"], $listOfCountry)  ){
				$error = true;
				$listOfErrors[]=8;
			}
			//pwd : min 8 max 25
			if( strlen($_POST["pwd"])<8 || strlen($_POST["pwd"])>25  ){
				$error = true;
				$listOfErrors[]=9;
			}
			//pwdConfirm == pwd
			if($_POST["pwd"] != $_POST["pwdConfirm"]){
				$error = true;
				$listOfErrors[]=10;
			}

			//Vérification du captcha
			if( $_SESSION["captcha"] !=  $_POST["captcha"]){
				$error = true;
				$listOfErrors[]=12;
			}
			

			//cgu : Pas besoin de la tester car s'elle n'est pas cochée elle n'existe pas




			if($error){
				// redirection (signup.php) avec les erreurs
				//echo "error";
				$_SESSION["errorsForm"] = $listOfErrors;
				$_SESSION["postForm"] = $_POST;
				header("Location: ../signup.php");


			}else{
				//Si ok : insertion en BDD et redirection (index.php) avec message success
				mkdir("../images/profils/".$_POST['email']);
				copy("../images/profils/default_avatar.png", "../images/profils/".$_POST['email']."/photo.png");
				$query = $connection->prepare("INSERT INTO user (gender,email,nom,prenom, password,date_naissance,pseudo,country,ville)
					VALUES ( :gender, :email, :nom, :prenom,:password, :date_naissance, :pseudo, :country,:ville) ");				
				$query->execute([
									"gender"=>$_POST["gender"],
									"email"=>$_POST["email"],
									"nom"=>$_POST["lastname"],
									"prenom"=>$_POST["firstname"],
									"password" => password_hash($_POST["pwd"], PASSWORD_DEFAULT),
									"date_naissance"=>$year."-".$month."-".$day,
									"pseudo"=>$_POST["pseudo"],
									"country"=> $_POST['country'],
									"ville"=> $_POST['ville']
								]);
				header("Location: ../index.php?info=signup");
			}

		

	}else{

		die("Tentative de Hack");

	} 