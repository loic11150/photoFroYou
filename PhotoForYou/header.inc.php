<header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <a class="navbar-brand" href="index.php">PhotoForYou</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Photos
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php 

              if(isset($_SESSION['mail'])){
              //récupère et affiche les items de la navbar 
                  $item = $manager->afficherListe($_SESSION['mail']);
                  echo $item;
                }
              ?>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tarifs</a>
            </li>

          </ul> 
            <?php 

              if(isset($_SESSION['mail']) ){
                $items = 0;
                if(isset($_SESSION['panier'])){
                  foreach ($_SESSION['panier'] as $key => $value) {
                    $items ++;
                  }
                }else{
                  $items = 0 ;
                }
                if($_SESSION["type"] != "photographe") {
                  //affiche bouton panier pour accéder à son panier
                      echo "<button type='button' class='btn btn-success' style=' margin-right: 1%; margin-left: 1% ;''><a style='color: white; text-decoration: none ;' href='panier.php'>Panier +".$items."</a></button>";
                      echo "<button type='button' class='btn btn-info' style=' margin-right: 1%; margin-left: 1% ;''><a style='color: white; text-decoration: none ;' href='mesphotos.php'>Mes photos achetées</a></button>";
                }
              }
                
            ?>  

            <?php 
             if(isset($_SESSION['mail']) ){
            // <!-- si ce n'est pas un photographe on affiche recherche si non non -->
            if($_SESSION["type"] != "photographe") {
             echo' <form class="form-inline my-2 my-lg-0" method="POST" action="recherche.php">
                <input class="form-control mr-sm-2" type="search" name="recherche" placeholder="Rechercher" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
              </form>';
              }
            }
            ?>
          <?php 
            if(isset($_SESSION['mail'])){
              $admin = "";
              if ($_SESSION['type']== "admin"){
                $admin = "admin" ;
              }
              //récup pseudo
                 $pseudo = $manager->recupPseudo($_SESSION['mail']);
                 $credits = $manager->afficherMesCredits($_SESSION['mail']);
              echo "<button type='button' class='btn btn-danger' style='float: left ; margin-right: 1%; margin-left: 1% ;''><a style='color: white; text-decoration: none ;' href='deconnexion.php'>Déconnexion</a></button>"."<button type='button' class='btn btn-dark' style='float: left ; margin-right: 1%; margin-left: 1% ;''><a style='color: white; text-decoration: none ;' href='utilisateur".$admin.".php'>".$pseudo."</a></button>";
              echo "<button type='button' class='btn btn-dark' style='float: left ; margin-right: 1%; margin-left: 1% ;''>Crédits : ".$credits."</button>";
            }else{
              echo'<button type="button" class="btn btn-dark" style="float: left ; margin-right: 1%; margin-left: 1% ;"><a style="color: white; text-decoration: none ;" href="connexion.php">Connexion</a></button>
                <button type="button" class="btn btn-secondary" style="float: left ;"><a style="color: white; text-decoration: none ;" href="inscription.php">Inscription</a></button>';
            }
          ?>
        </div>
      </nav>
    </header>