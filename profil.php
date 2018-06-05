<?php
session_start();
include "head.php";
include "functions.php";
include "conf.inc.php";
isPrivate();
include "navbar.php";
$bdd = connectDB();
?>
<title>Profil de <?php echo getPseudo($_SESSION['email'])?></title>
<body>
    <div class="container">
        <div class="resume decalageTop">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12">
                  <?php
                  if (isset($_GET['pseudo'])) {
                    $sql = $bdd->prepare("SELECT * FROM user WHERE pseudo=:toto");
                    $sql->execute([
                      "toto" => $_GET['pseudo']
                      ]);
                    $data = $sql->fetch();
                    if (!isset($data['pseudo'])) {
                      echo modal("Erreur","La personne n'a pas été trouvée","footer");
                    }else{
                      foreach ($typeOfAccount as $key => $value) {
                        if ($key == $data['role']) {
                          $type = $value;
                        }
                      }
                      ?>
                      <div class="row">
                          <div class="col-sm-4 col-xs-12">
                               <center>
                                <?php 
                                echo '<img class="avatar" width="150" height="150" src="images/profils/'.$data['email'].'/photo.png ">';
                                ?>
                               </center>
                               <br>
                          </div>
                          <div class="col-sm-8 col-xs-12">
                              <ul class="list-group">
                                  <li class="list-group-item"><span><i class="fas fa-angle-double-right"></i> Type de compte : <?php echo $type; ?></span></li>
                                  <li class="list-group-item"><span><i class="fas fa-address-card"></i> Nom : <?php echo $data['nom'] ?></span></li>
                                  <li class="list-group-item"><span><i class="fas fa-address-card"></i> Prénom : <?php echo $data['prenom'] ?></span></li>
                                  <li class="list-group-item"><span><i class="fas fa-user"></i> Pseudo : <?php echo $data['pseudo'] ?></span></li>
                                  <li class="list-group-item">
                                    <span><i class="fas fa-home "></i>
                                      <?php 
                                      if(isset($data['residence'])){ 
                                        echo $data['residence']; 
                                      }else{ 
                                        echo "Lieu de résidence non enregistré";
                                      } 
                                      ?>
                                    </span>
                                  </li>
                                  <?php
                                  $dateInscription = timeStamp($data['dateInscription']);
                                  ?>
                                  <li class="list-group-item"><span><i class="fas fa-calendar-alt"></i> Date d'inscription : <?php echo $dateInscription['date']; ?></span></li>
                                  <li class="list-group-item">
                                    <span>
                                      <i class="fa fa-phone"></i>
                                      <?php if(isset($data['phone'])){
                                        echo $data['phone']; 
                                      }else{
                                        echo "Numéro de téléphone non enregistré"; 
                                      } 
                                      ?>
                                    </span>
                                  </li>
                                  <li class="list-group-item"><span><i class="fa fa-envelope"></i> Email : <?php echo $data['email'] ?></span></li>
                                  <li class="list-group-item"><span><i class="fa fa-trophy"></i> Note : // a coder</span></li>
                              </ul>
                          </div>
                      </div>
                      <?php
                    }
                  }else{
                    $sql = $bdd->prepare("SELECT * FROM user WHERE email=:toto");
                    $sql->execute([
                      "toto" => $_SESSION['email']
                      ]);
                    $data = $sql->fetch();
                    foreach ($typeOfAccount as $key => $value) {
                      if ($key == $data['role']) {
                        $type = $value;
                      }
                    }
                    $dateInscription = timeStamp($data['dateInscription']);
                    ?>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                             <center>
                                <img class="avatar" width="150" height="150" src="images/profils/<?php echo $data['email'] ?>/photo.png ">
                             </center>
                             <br>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                  <span>
                                    <i class="fas fa-angle-double-right"></i>
                                    Type de compte : <?php echo $type;?>
                                  </span>
                                </li>
                                <li class="list-group-item">
                                  <span>
                                    <i class="fas fa-address-card"></i> 
                                    Nom : <?php echo $data['nom']?>
                                  </span>
                                </li>
                                <li class="list-group-item">
                                  <span>
                                    <i class="fas fa-address-card"></i> 
                                    Prénom : <?php echo $data['prenom'] ?>
                                  </span>
                                </li>
                                <li class="list-group-item">
                                  <span>
                                    <i class="fas fa-user"></i>
                                    Pseudo : <?php echo $data['pseudo'] ?>
                                  </span>
                                </li>
                                <li class="list-group-item">
                                  <span>
                                    <i class="fas fa-home "></i>
                                    <?php 
                                    if(isset($data['residence'])){ 
                                      echo $data['residence']; 
                                    }else{ 
                                      echo "Lieu de résidence non enregistré";
                                    } 
                                    ?>
                                  </span>
                                </li>
                                <li class="list-group-item"><span><i class="fas fa-calendar-alt"></i> Date d'inscription : <?php echo $dateInscription['date']; ?></span></li>
                                <li class="list-group-item">
                                  <span>
                                    <i class="fa fa-phone"></i>
                                    <?php if(isset($data['phone'])){
                                      echo $data['phone']; 
                                    }else{
                                      echo "Numéro de téléphone non enregistré"; 
                                    } 
                                    ?>
                                  </span>
                                </li>
                                <li class="list-group-item"><span><i class="fa fa-envelope"></i> Email : <?php echo $data['email'] ?></span></li>
                                <li class="list-group-item"><span><i class="fa fa-trophy"></i> Note : // a coder</span></li>
                            </ul>
                        </div>
                    </div>
                    <a href="modification_profil.php" class="btn btn-primary">Modifier mon profil</a>   
                    <?php
                  }
                  ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
