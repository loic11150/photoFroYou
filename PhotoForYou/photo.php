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
    <div id="container" style="margin-left: 5% ; margin-right: 5% ; margin-top: 5%;">
      
    <?php echo $managerP->afficherUnePhoto($_GET['lien']);

    if(isset($_POST['panier'])){
      if(empty($_SESSION['panier'])){
        $panier = array();
      }else{
        $panier = $_SESSION['panier'];
      }
      $test = 0 ;
      foreach ($panier as $key => $value) {
        if ($value == $_POST['panier']){
          $test = 1 ;
        }
      }
      if ($test ==0) {
        $panier[] = $_POST['panier'];
        $_SESSION['panier'] = $panier ;
        //panier
      echo "<script type='text/javascript'>document.location.href='panier.php';</script>";

      }else{
        echo "<script type='text/javascript'>alert('Vous avez déjà cet article dans votre panier !');</script>";

      }
           }?>
