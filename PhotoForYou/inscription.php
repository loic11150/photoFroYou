<!-- head -->
<?php include("head.inc.php"); ?>

<body>
<!-- barre de navigation --> 
    <?php include("header.inc.php");
    if(isset($_SESSION['mail'])){
    echo"<script type='text/javascript'>document.location.href='index.php';</script>"; 
} ?>
   
   <div class="card bg-light">
    <article class="card-body mx-auto" style="max-width: 400px;">
      <h4 class="card-title mt-3 text-center">Créer un compte</h4>
      
      <!-- Formulaire -->
      <form method="POST" action="inscription.php">
      <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
         </div>
            <input name="nom" class="form-control" placeholder="Nom" type="text" required maxlength="25">
            <input name="prenom" class="form-control" placeholder="Prénom" type="text" required maxlength="25">
        </div> 
        <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
         </div>
            <input name="pseudo" class="form-control" placeholder="Votre Pseudo" type="text" required maxlength="50">
        </div>
    <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
         </div>
            <input name="mail" class="form-control" placeholder="Votre adresse mail" type="email" required maxlength="50">
        </div> <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-building"></i> </span>
        </div>
        <select name="role" class="form-control"required>
          <option value=""  selected >Choisissez votre Rôle</option>
          <option value="photographe">Photographe</option>
          <option value="client">Client</option>
        </select>
      </div> <!-- form-group end.// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
            <input id="mdp1" name="mdp1" class="form-control" placeholder="Mot de passe" type="password" required>
        </div> <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
            <input id="mdp2" name="mdp2" class="form-control" placeholder="Répétez mot de passe" type="password" required>
        </div> <!-- form-group// -->                                      
        <div class="form-group">
            <button type="submit" name="envoie" class="btn btn-primary btn-block" onclick="verifMdp()">Créer un compte</button>
        </div> <!-- form-group// -->      
        <p class="text-center">Déja un compte? <a href="connexion.php">Se connecter</a> </p>                                                                 
      </form>
    </article>
  </div>
  <?php
  //conditions si les mdp sont les même et si le formulaire est envoyé
    if(isset($_POST['envoie']) and $_POST['mdp1'] == $_POST['mdp2']){
    //  creation users
        $user = new Users([
          'email' => $_POST['mail'] ,
          'type' => $_POST['role'],
          'prenom' => $_POST['prenom'],
          'nom' => $_POST['nom'],
          'pseudo'=>$_POST['pseudo'],
          'motDePasse' => sha1($_POST['mdp1']),
          'credit' => 0,
          'ban' => null ]);
        echo $user ;
        //cherche si le mail existe dans la BDD ou pas
        if ($manager->mailExist($_POST['mail']) == "true" ){
          //ajout dans la BDD
          $manager->add($user);
          echo"<script type='text/javascript'>
                document.location.href='connexion.php';
              </script>";
               //création cookie
          // setcookie('compteCree', "123", time() + 1*60); 
        }else{           
          echo"<script type='text/javascript'>
            alert('Cette adresse mail est déjà utilisé !');
          </script>"; 
        }
       
      }
    ?>
</body>

<!-- footer -->
<?php include("footer.inc.php"); ?>
<script type="text/javascript">
  function verifMdp() {
 
            var a = document.getElementById("mdp1").value;
            var b = document.getElementById("mdp2").value;
 
            if (a!=b) {
              alert("Les mots de passe ne correspondent pas.");
              return false; }
            }
</script>