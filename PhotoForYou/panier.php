<!-- head -->
<?php include("head.inc.php");?>

  <body>
   <!-- barre de navigation -->
    <?php include("header.inc.php");
    

    if (!empty($_SESSION['panier']) ){
      foreach ($_SESSION['panier'] as $key => $value) {

        echo "<br>".$value.'<form method="POST"> <button type="input" class="btn btn-danger" style=" margin-right: 1%; margin-left: 1% ;"  name="supprimer" value="'.$value.'"><a style="color: white; text-decoration: none ;">Supprimer du panier</a></button></form>';
      }
      echo '<br>Prix : '.$managerP->calculPrixPhoto($_SESSION['panier']).' Crédits';
     echo' <form method="POST"> <button type="input" class="btn btn-success"  name="achat" style=" margin-right: 1%; margin-left: 1% ;"><a style="color: white; text-decoration: none ;">acheter</a></button></form>';

    }else{
      echo "<center><h3>Vous n'avez rien dans votre panier!</h3></center>";
    }
    
    if(isset($_POST['supprimer'])){
      unset($_SESSION['panier'][array_search($_POST['supprimer'], $_SESSION['panier'])]);
      echo "<script type='text/javascript'>document.location.href='panier.php';</script>";
    }

    if(isset($_POST['achat'])){
      $achat = $manager->payer($_SESSION["mail"],$_SESSION["panier"]) ;
      if($achat == true){
        foreach ($_SESSION['panier'] as $key => $value) {
           unset($_SESSION['panier'][array_search($value, $_SESSION['panier'])]);
        }
        
        echo "<script type='text/javascript'>alert('Payé avec succès !');</script>";
        echo "<script type='text/javascript'>document.location.href='panier.php';</script>"; 

      }else {
         echo "<script type='text/javascript'>alert('Pas assez de crédits ! Paiement non aboutie.');</script>";
      }

    }

    ?>