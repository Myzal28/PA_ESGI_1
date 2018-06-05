<?php

	session_start();


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <div class="formulaire-contact">
        <form action="../function/checkContact.php" method="post">
            <h2 class="sr-only">Formulaire de contact</h2>
            <div class="illustration"><i class="icon ion-paper-airplane"></i></div>

               <?php
                    if(isset($_SESSION['erreur_parametre'])){
                         foreach($_SESSION['erreur_parametre'] as $key){
                              if($key== 4){?>
                                   <br>
                                   <div class="alert alert-danger">
                                   <strong>Erreur! </strong><?php echo $contact[$key] ?>
                                   </div>
                                   <?php
                              }
                         }
                    }

                    if(isset($_SESSION['erreur_parametre'])){
                         foreach($_SESSION['erreur_parametre'] as $key){
                              if($key== 5){?>
                                   <br>
                                   <div class="alert alert-success">
                                   <strong>Succès! </strong><?php echo $contact[$key] ?>
                                   </div>
                                   <?php
                              }
                         }
                    }  ?>

            <div class="form-group">
                <input class="form-control" type="email" name="email" required="required" placeholder="Email" minlength="2">
            </div>

            <?php
                 if(isset($_SESSION['erreur_parametre'])){
                      foreach($_SESSION['erreur_parametre'] as $key){
                           if($key== 1){?>
                                <br>
                                <div class="alert alert-danger">
                           <strong>Erreur! </strong><?php echo $contact[$key] ?>
                                </div>
                                <?php
                           }
                      }
                 }  ?>

            <input class="form-control" type="text" name="name" required="required" placeholder="Nom" minlength="5">

            <?php
                 if(isset($_SESSION['erreur_parametre'])){
                      foreach($_SESSION['erreur_parametre'] as $key){
                           if($key== 3){?>
                                <br>
                                <div class="alert alert-danger">
                           <strong>Erreur! </strong><?php echo $contact[$key] ?>
                                </div>
                                <?php
                           }
                      }
                 }  ?>

            <div class="form-group"></div>
            <input class="form-control" type="testarea" name="message" placeholder="Message">
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Envoyer</button>
            </div><a href="../index.php" class="forgot">Revenir sur l'écran d'accueil</a></form>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/PHP-Contact-Form-dark.js"></script>
    <script src="../js/PHP-Contact-Form-dark1.js"></script>
</body>

</html>
