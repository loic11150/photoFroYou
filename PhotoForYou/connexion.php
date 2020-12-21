<!-- head -->
<?php include("head.inc.php");
    //test si le cookie existe et donc si on a bien supprimé le compte.
    if(isset($_COOKIE['compteCree'])){
      echo  "<script type='text/javascript'>
            alert('Création de compte réussi.');
          </script>";
        // Suppression du cookie 
        setcookie('compteCree');
        // Suppression de la valeur du tableau $_COOKIE
        unset($_COOKIE['compteCree']);
      }
//si on est déjà connecté on peut pas retourner sur la page
if(isset($_SESSION['mail'])){
    echo"<script type='text/javascript'>document.location.href='index.php';</script>"; 
} ?>
<body>
<!-- barre de navigation --> 
    <?php include("header.inc.php");?>
   
   <div class="card bg-light">
    <article class="card-body mx-auto" style="max-width: 400px;">
      <h4 class="card-title mt-3 text-center">Se connecter</h4>
      
      <!-- Formulaire -->
    <form method="POST" action="connexion.php">
      <div class="form-group input-group">
    <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
         </div>
            <input name="mail" class="form-control" placeholder="Votre adresse mail" type="email" required maxlength="50">
        </div> <!-- form-group// -->
 <!-- form-group end.// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
            <input id="mdp1" name="mdp1" class="form-control" placeholder="Mot de passe" type="password" required>
        </div> <!-- form-group// -->
 <!-- form-group// -->  
        </div>                                    
        <div class="form-group">
            <button type="submit" name="envoie" class="btn btn-primary btn-block">Se connecter</button>
        </div>    
      </form>
    </article>
  </div>
  <?php  
    if(isset($_POST['envoie'])){
      //adresse mail
      $mail = $_POST['mail'] ;
      //mdp
      $mdp = sha1($_POST['mdp1']) ;

      // exist : Pour savoir si le mail et le mdp correspondent à un users dans la BDD
      $exist = $manager->exist($mail,$mdp);
      // savoir si user est ban
      $ban = $manager->banni($mail);
      if ($ban != null){
        //récup date du jour
        $date = date('Y-m-d');
        //crée une date qu'on peut comparer
        $datetime1 = date_create($date);
          //récup date du ban
        $datetime2 = date_create($ban);
        //fais l'intervale des dates
        $interval = date_diff($datetime1, $datetime2);
        // pour que ça affiche des jours 
        $interval = $interval->format('%a');
        echo 
        "<script type='text/javascript'>
          alert('Vous êtes banni durant : ".$interval." jours');
        </script>";
        }
        if($exist == "true" and $ban == null){ 
          
          $_SESSION['mail'] = $mail;

          $type = $manager->recupType($_SESSION['mail']);

          $_SESSION['type'] = $type ;
          echo"<script type='text/javascript'>
              document.location.href='index.php';
            </script>";   

        }elseif($ban==null){
            echo "<script type='text/javascript'>
              alert('Mot de passe ou mail invalide');
            </script>";
        }

    }
  ?>
</body>
<!-- footer -->
<?php include("footer.inc.php"); ?>