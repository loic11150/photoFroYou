<!-- head -->
<?php include("head.inc.php");?>

  <body>
   <!-- barre de navigation -->
    <?php include("header.inc.php");

   $id = $manager->recupId($_SESSION['mail']);
   echo $managerP->voirMesPhotos($id);
?>

 <?php // footer -->
 include("footer.inc.php"); ?>