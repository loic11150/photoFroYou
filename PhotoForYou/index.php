<!-- head -->
<?php include("head.inc.php");?>

  <body>
   <!-- barre de navigation -->
    <?php include("header.inc.php");
    //test si le cookie suppr existe et donc si on a bien supprimé le compte.
    if(isset($_COOKIE['suppr'])){
      echo  "<script type='text/javascript'>
            alert('Suppression de compte réussie.');
          </script>";
        // Suppression du cookie 
        setcookie('suppr');
        // Suppression de la valeur du tableau $_COOKIE
         unset($_COOKIE['suppr']);
    }

    ?>
    <div id="container" style="margin-left: 5% ; margin-right: 5% ;">
    <!-- logo + texte -->
      <center><img src="img/logo.png" >
        <h1>PhotoForYou</h1>
        <p>Des pros au services des professionels de la communication.</p>
      </center>
         <!-- carousel -->
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" style="">
          <div class="carousel-item active">
            <img src="img/car1.jpg" class="d-block w-100 img_fluid" alt="paysage" style="height: 600px ;">
          </div>
          <div class="carousel-item">
            <img src="img/car2.jpg" class="d-block w-100 img_fluid" alt="paysage" style="height: 600px ;">
          </div>
          <div class="carousel-item">
            <img src="img/car3.jpg" class="d-block w-100 img_fluid" alt="paysage" style="height: 600px ;">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      <!-- Jumbotron -->
      <div class="jumbotron " >
        <p>Moins de temps à chercher. Plus de résultats. Découvrez les images qui vous aideront à vous démarquer.</p>
        <a class="btn btn-primary btn-lg" href="inscription.php" role="button">Inscrivez vous !</a>
      </div>
      <!-- Cartes -->
      <div class="card-deck">
       <!-- première carte -->
        <div class="card bg-warning text-white" >
          <img class="card-img-top img_fluid" src="img/paysage.jpg" alt="Card image cap">
          <div class="card-img-overlay">
            <h5 class="card-title"  style="color:black;">Paysages</h5>
          </div>
          <div class="card-body">
            <h5 class="card-title">Les paysages</h5>
          <p class="card-text">Une collection de photos extraordinaires réalisées par des photographes professionels. Redécouvrez la planète terre!</p>
            <button type="button" class="btn btn-primary">Je veux voir...</button>
          </div>
          <div class="card-footer">
            <small>Dernière mise à jour, il y a 3 min</small>
          </div>
        </div>
        <!-- deuxieme carte -->
        <div class="card bg-success text-white" >
          <img class="card-img-top img_fluid" src="img/portrait.jpg" alt="Card image cap">
          <div class="card-img-overlay">
            <h5 class="card-title" style="color:black;">Portraits</h5>
          </div>
          <div class="card-body">
            <h5 class="card-title">Les portraits</h5>
            <p class="card-text">Toutes les expressions, tous les visages du sourire aux larmes. Vous trouverez le portrait qu'il vous faut pour vos publications.</p>
            <button type="button" class="btn btn-primary">Je veux voir...</button>
          </div>
          <div class="card-footer">
            <small>Dernière mise à jour, il y a 3 min</small>
          </div>
        </div>
        <!-- troisième carte -->
        <div class="card bg-danger text-white" >
          <img class="card-img-top img_fluid" src="img/event.png" alt="Card image cap">
          <div class="card-img-overlay">
            <h5 class="card-title" style="color:black;">Evenements</h5>
          </div>
          <div class="card-body">
            <h5 class="card-title">Les évenements</h5>
            <p class="card-text">Que ce soit les mariages, férias, soirée DJ. vous trouverez la photo pour mettre en valeur votre événement.</p>
            <button type="button" class="btn btn-primary">Je veux voir...</button>
          </div>
          <div class="card-footer">
            <small>Dernière mise à jour, il y a 3 min</small>
          </div>
        </div>
      </div>
      <!-- tarifs -->
      <center style="margin-top: 5%;">
        <h1>Tarifs</h1>
        <p>Une Tarification flexible.</p>
      </center>
      <div class="card-deck" style="margin-bottom: 5%; ">
        <!-- premier tarif -->
        <div class="card bg-light" style="text-align: center ;">
          <div class="card-header"><h4>Essai</h4></div>
          <div class="card-body">
            <h1 class="card-title"><strong>1€</strong></h1>
            <p class="card-text">100 Crédits<br>Valable 1 fois</p>
          <form method="POST">     
            <button type="input" name="achat_credits" value="100" class="btn btn-outline-primary" style="width: 100% ;">Acheter</button>
          </div>
        </div>
        <!-- deuxième tarif -->
        <div class="card bg-light" style="text-align: center ;">
          <div class="card-header"><h4>Formule Classique</h4></div>
          <div class="card-body">
            <h1 class="card-title"><strong>10€</strong></h1>
            <p class="card-text">500 crédits<br>Cumulable à l'infini</p>
            <button type="input" name="achat_credits" value="500" class="btn btn-primary" style="width: 100%;">Acheter</button>
          </div>
        </div>
        <!-- troisième tarif -->
        <div class="card bg-light" style="text-align: center ;">
          <div class="card-header"><h4>Formule Pro</h4></div>
          <div class="card-body">
            <h1 class="card-title"><strong>100€</strong></h1>
            <p class="card-text">10000 crédits<br>Cumulable à l'infini (Pro)</p>
            <button type="input" name="achat_credits" value="10000" class="btn btn-primary" style="width: 100%;">Acheter</button>
          </form>
          </div>
        </div>
      </div>
    </div>
      <!-- Footer -->
    <?php include("footer.inc.php")?>
  </body>
</html>
<?php

    if(isset($_POST['achat_credits'])){
      $manager->achat_credits($_SESSION['mail'],$_POST['achat_credits']);
      echo"<script type='text/javascript'>alert('Paiement abouti, vous allez recevoir ".$_POST['achat_credits']." Crédits ! ');</script>"; 
      echo"<script type='text/javascript'>document.location.href='index.php';</script>"; 
    }