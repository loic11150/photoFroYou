<?php include("head.inc.php"); ?>
<body>
 <?php include("header.inc.php");
    if(!isset($_SESSION['mail'])){
    	echo"<script type='text/javascript'>document.location.href='index.php';</script>";
    }
?>
 <div class="card bg-light">
    <article class="card-body mx-auto" style="max-width: 400px;">
      <h4 class="card-title mt-3 text-center">Vendre une photographie</h4>
      
      <!-- Formulaire -->
      <form method="POST" enctype="multipart/form-data">
      <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
         </div>
            <input name="photo"  placeholder="photo" type="file" required accept="image/png, image/jpeg, image/gif, image/raw"/>
        </div> 
        <!-- form-group// -->

        <div class="form-group input-group">
          
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
         </div>
            <input name="prix" class="form-control" placeholder="Le prix en crédits" type="number" required max="100" min="2">
        </div>
    <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-building"></i> </span>
        </div>
        <select name="cat" class="form-control"required>
          <option value="" selected >Choisissez une catégorie</option>
          <?php 
          	$item = $managerP->afficherCat();
            echo $item;
          ?>
        </select>
        </div>
        <!-- form-group -->
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
         </div>
            <input name="mot_clef" class="form-control" placeholder="Mots clefs séparés par une virgule" type="text" required maxlength="500">
        </div>
      <!-- form-group// -->                                      
        <div class="form-group">
            <button type="submit" name="envoie" class="btn btn-primary btn-block">Publier la photo</button>
        </div> <!-- form-group// -->                                                                       
      </form>
    </article>    
  </div>
<?php include("footer.inc.php");?>	
</body>
<?php
	if(isset($_POST['envoie'])){
		// les extensions adaptés
		$extension = array("png","jpeg","gif","raw","jpg","PNG");
		$testExtension =  explode(".", $_FILES['photo']['name']);
    //recupère la taille en pixels
    $taille = getimagesize($_FILES['photo']['tmp_name']);
		$condition = 0 ;
    //test extension
		foreach ($extension as $key => $value) {
			if ($testExtension[1] == $value){
				$condition = 1 ;				
			}
		}
		if($condition == 1){
			// cat = nom Catégorie $chem = chemin
			$name = str_replace(" ", "", $_FILES['photo']['name']);
      $_FILES['photo']['name'] = $name ;
			//$chem = chemin du fichier A enregistrer dans la BDD
			$chem = "BDD_IMAGE/".strtoupper($_POST['cat']."/".$name);
			//ajout bdd img
			move_uploaded_file($_FILES['photo']['tmp_name'], $chem) or die("nop");
			$id = $manager->recupId($_SESSION['mail']);
      //création objet Photo
			$photo = new Photo([
				'nom_photo' => $name ,
		        'taille_pixels_x' => $taille[0],
		        'taille_pixels_y' => $taille[1],
		        'poids' => $_FILES['photo']['size'],
		        'url_photo'=> $chem,
		        'id_user' => $id,
		        'id_cat' => $managerP->recupIdCat($_POST['cat']),
		        'prix' => $_POST['prix'],
            'mot_clef' => $_POST['mot_clef']]);
      //ajout Photo à la BDD
			$managerP->add($photo);
      echo "<script type='text/javascript'>alert('Photo ajouté avec succès dans la catégrorie : ".$_POST['cat']."')</script>";
		}else{
			echo "<script type='text/javascript'>alert('Extension incorrect : extensions acceptée : png, jpeg , gif, raw, jpg')</script>";
		}

		
		
   	

	}
	?>