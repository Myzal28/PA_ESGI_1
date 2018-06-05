<?php 
session_start();
header("Content-Type: image/png");

$image = imagecreate(200,50);
$length = 7;

$back = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));


$charAuthorized = "abcdefghijklmnpqrstuvwxyz123456789";
$charAuthorized = str_shuffle($charAuthorized);
$captcha = substr($charAuthorized, 0, $length);

$_SESSION["captcha"] = $captcha;


$fontfile = glob("font/*.ttf");

$x = rand(5,10);
$y = rand(25,40);

for($i=0;$i<strlen($captcha);$i++){
	$size = rand(20, 25);
	$angle = rand(-25, 25);

	$colors[] = imagecolorallocate($image, rand(150,250), rand(150,250), rand(150,250));
	imagettftext($image, $size, $angle, $x, $y, $colors[$i], $fontfile[rand(0,count($fontfile)-1)] , $captcha[$i]);
	$x += rand(20, 30) ;
	$y = rand(20, 45) ;
}

for($i=0; $i<rand(2, 5); $i++ ){
	$j = rand(0,2);
	switch ($j) {
		case 0:
			imageline($image, rand(0, 200), rand(0, 50), rand(0, 200), rand(0, 50), $colors[rand(0,count($colors)-1)]);
			break;
		case 1:
			imagerectangle($image, rand(0, 200), rand(0, 50), rand(0, 200), rand(0, 50), $colors[rand(0,count($colors)-1)]);
			break;
		default:
			imageellipse($image, rand(0, 200), rand(0, 50), rand(0, 100), rand(0, 100), $colors[rand(0,count($colors)-1)]);
			break;
	}
}
imagepng($image);
/*

	Modifier la police d'écriture aléatoire (parmis une liste) par caractère
	Positionnement et inclinaison aléatoires par lettre
	lettre et chiffre aléatoires
	couleur aléatoire par lettre
	générer aléatoirement des formes géométriques (ligne, carré, rond, ....) de couleurs aléatoires par dessus
	Visible et lisible
	
*/





