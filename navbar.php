<nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #12a117">
  <a class="navbar-brand pacifico" href="/Projet/index.php">Give It Back</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php
  if (isConnected()) {
    ?>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/Projet/index.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="searchobject.php"><i class="fas fa-search"></i> Rechercher un objet</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="addobject.php"><i class="fas fa-plus"></i> Ajouter mon objet</a>
        </li> 
       <li class="nav-item">
          <a class="nav-link" href="lendobject.php"><i class="fas fa-handshake"></i> Prêter un objet</a>
        </li> 
      </ul>
      <div class="my-2 my-lg-0">
        <ul class="navbar-nav mr-auto">
          <?php 
          if (isAdmin()){
            ?>
            <li class="nav-item">
              <a class="nav-link" href="/Projet/backoffice/index.php"><i class="fas fa-sign-in-alt"></i> Backoffice</a>
            </li>
            <?php
          }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="/Projet/profil.php"><i class="fas fa-user"></i> <?php echo getPseudo($_SESSION['email']); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Projet/logout.php"><i class="fas fa-power-off"></i> Se déconnecter</a>
          </li>
        </ul>
      </div>
    </div>
    <?php
  }else{
    ?>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/Projet/index.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <div class="my-2 my-lg-0">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/Projet/signup.php"><i class="fas fa-user-plus"></i> S'inscrire</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Projet/signup.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
          </li>
        </ul>
      </div>
    </div>
    <?php
   } 
  ?>
</nav>