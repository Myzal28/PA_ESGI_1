<?php

$listOfGender = [0=>"Monsieur", 1=>"Madame", 2=>"Autre"];
$defaultGender = 0;

$listOfCountry = ["fr"=>"France", "pl"=>"Pologne", "ru"=>"Russie"];
$defaultCountry = "fr";

$typeOfAccount = [
	"0"=>"Compte non activé",
	"1"=>"Utilisateur activé",
	"2"=>"Utilisateur confirmé",
	"3"=>"Modérateur",
	"4"=>"Administrateur",
	"5"=>"Banni",];



define("DBDRIVER", "mysql");
define("DBHOST", "localhost");
define("DBNAME", "projet_annuel");
define("DBUSER", "root");
define("DBPWD", "");


$listOfErrors=[
	1=>"Le genre n'est pas correct",
	2=>"Le prénom doit faire plus de 2 caractères",
	3=>"Le nom doit faire plus de 2 caractères",
	4=>"L'email n'est pas valide",
	5=>"Le format de la date d'anniversaire n'est pas correct",
	7=>"La date d'anniversaire n'existe pas",
	6=>"Vous devez avoir entre 18 et 100 ans",
	8=>"Le pays n'est pas correct",
	9=>"Le mot de passe doit faire entre 8 et 20 caractères",
	10=>"Le mot de passe de confirmation ne correspond pas",
	11=>"L'email existe déjà",
	12=>"Captcha incorrect",
	13=>"Le nom de votre ville doit faire moins de 100 caractères",
];





