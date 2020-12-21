<?php include("head.inc.php"); ?>
	<body>
<?php include("header.inc.php");
//si l'users est pas connecté qu'il est pas admin et qu'il arrive sur la page on le redirige sur la page d'accueil 
if(!isset($_SESSION['mail'])or$_SESSION['type']!= "admin"){
	echo"<script type='text/javascript'>document.location.href='index.php';</script>";
}?>		
		<div id="container" style="margin-left: 5% ; margin-right: 5% ; margin-top: 1%;">
				
				<!-- //bouton gérer users -->
				<button name='users' id='btnUsers' class='btn btn-info btn-block' style='width: 25%; margin-bottom : 1%;' onclick='voirusers()'>Gérer les utilisateurs</button>
				
				<!-- //bouton ajouter catégories -->
				<button name='users' id='ajoutCategorie' class='btn btn-info btn-block' style='width: 25%; margin-bottom : 1%; ' onclick='voirajout()'>Ajouter des catégories de photos</button>

				<button name='users' id='supprimerPhoto' class='btn btn-info btn-block' style='width: 25%; margin-bottom : 1%; ' onclick='supprimerPhoto()'>Supprimer photo</button>
				
				<!-- //bouton supprimer catégories -->
				<button name='users' id='supprCategorie' class='btn btn-info btn-block' style='width: 25%; margin-bottom : 1%; ' onclick='supprimerCat()'>Supprimer des catégories de photos</button>
				
				<!--------------------------- TABLEAU USERS --------------------------->
				<table class="table" id="user" style="display: none ;">
					<thead>
					    <tr>
						    <th><b>email</b></th>
							<th><b>type</b></th>
							<th><b>nom</b></th>
							<th><b>prenom</b></th>
							<th><b>pseudo</b></th>
							<th><b>credits</b></th>
							<th><b>ban</b></th>
							<th><b>option</b></th>
						</tr>
					</thead>
					<tbody>
					<?php 
						//boucle qui va chercher les users et les mettre dans le tableau
						foreach ($manager->getList() as $key => $value) {
							echo "<tr>".$value."
							<td>
								<form method='POST' style='display:inline ;'>
									<input name='jour' type='number' min='0' required placeholder='nombre de jour à bannir'/>
									<button type='submit' value='".$value->getEmail()."' name='bannir' class='btn btn-danger')'>Bannir</button>
								</form>
								<form method='POST' style='display :inline ;'>
									<button type='submit' value='".$value->getEmail()."' name='debannir' class='btn btn-success')'>Debannir</button>
            					</form>
            				</td>"."</tr>";
						}
					?>			    
				  	</tbody>
				</table>

				<!--------------------------- FORMULAIRE AJOUT CATEGORIE --------------------------->
				<form method="POST" id="ajoutCat" style="width	: 50% ;display : none;">
		 			<div class="form-group">
		  				<input type="text" class="form-control" name="categorie" placeholder="Nom de la catégorie à ajouter">
		 			</div>
		 				<button type="submit" name="ajoutCat" class="btn btn-primary">Ajouter Catégorie</button>
				</form>

				<!---------------------------TABLEAU SUPPRESSION PHOTO--------------------------->
				<table class="table" id="photoGestion" style="display: none ;">
					<thead>
					    <tr>
					    	<th><b>id</b></th>
						    <th><b>nom</b></th>
							<th><b>taille x</b></th>
							<th><b>taille y</b></th>
							<th><b>poids (o)</b></th>
							<th><b>url</b></th>
							<th><b>id du photographe</b></th>
							<th><b>id catégorie</b></th>
							<th><b>prix</b></th>
							<th><b>Mots Clefs</b></th>
							<th><b>option</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//bouton données des photos(id, nom, etc) +supprimer photo
							foreach ($managerP->donneesPhoto() as $key => $value) {
							 	//echo $key ;
							 	echo "<tr>".$value."</td><td>"."<form method='POST'><button type='submit' value='".$value->getId_photo()."' name='supprimerPhoto' class='btn btn-danger')'>Supprimer</button></form></td></tr>";

							 }
						 // echo var_dump($managerP->donneesPhoto());
						 // $xxx = $managerP->donneesPhoto();
						 // echo $xxx[0]->getId_photo();
						 ?>
					</tbody>
				</table>
				<!---------------------------TABLEAU SUPPRESSION CATEGORIE--------------------------->
				<table class="table" id="supCat" style="display: none ;">
					<thead>
						<tr>
					    	<th><b style="color:red;">Attention cela entraine la suppression des photos dans la catégorie!!</b></th>
					    </tr>
					    <tr>
					    	<th><b>id</b></th>
						    <th><b>nom</b></th>
						    <th><b>option</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
							echo $managerP->donneesCat();
						?>
					</tbody>
				</table>
	</div>
</body>
				
	<?php 

		// <--------------------------- AJOUT CATEGORIE --------------------------->
		if(isset($_POST['ajoutCat'])and $_SESSION['type']=="admin"){
			//ajouter la catégorie en base de données catégorie en "unique" dans la bdd pas d'ajout si ça existe deja 
			$managerP->addCategorie($_POST['categorie']);
			$chemin = "BDD_IMAGE/".strtoupper($_POST['categorie']);
			//créer le dossier pour stocker les images // si le dossier existe ça le crée pas donc xx1 valeur bollean 0 
			$xx1 = mkdir($chemin,0700);
			//afficher ça fonctionne ou pas 
			if($xx1=="true"){
				echo "<script type='text/javascript'>
					alert('Vous avez bien rajouté la catégorie : ".$_POST['categorie']."'); 
				  </script>";
				  echo "<script type='text/javascript'>document.location.href='utilisateuradmin.php';</script>";
				}else{
					echo "<script type='text/javascript'>
					alert('--------------------------La catégorie ".$_POST['categorie']." existe déjà !!--------------------------'); 
				  </script>";
				  echo "<script type='text/javascript'>document.location.href='utilisateuradmin.php';</script>";
				}
			}

		// <--------------------------- supprimer une photo --------------------------->
		if(isset($_POST['supprimerPhoto'])and $_SESSION['type']=="admin"){
			//supp du côté stockage image 
			$suppBDD = $managerP->supprimerPhotoBdd($_POST['supprimerPhoto']);
			//supp coté base de données mysql 
			$suppSQL = $managerP->supprimerPhotoBddSql($_POST['supprimerPhoto']);
			echo "<script type='text/javascript'>document.location.href='utilisateuradmin.php';</script>";
		}

		// <--------------------------- BANNIR/DEBANNIR un user --------------------------->
		if(isset($_POST['bannir'])and $_SESSION['type']=="admin"){
			$nbrJourBan = $_POST['jour'];
			$mail = $_POST['bannir'];
			// Date d'ajourd'hui
			$ajd = date('Y-m-d');
			// sépare les jour des mois et des annees ([0] = annees ...)
			$ajd = explode('-', $ajd);
			// $ajd[2] += $nbrJourBan;
			$dateban = date("Y-m-d", mktime(0,0,0,$ajd[1],$ajd[2]+$nbrJourBan,$ajd[0]));
			$manager->bannirUser($mail,$dateban);
			echo "<script type='text/javascript'>document.location.href='utilisateuradmin.php';</script>";
			// echo $dateban;
		}
		if(isset($_POST['debannir'])and $_SESSION['type']=="admin"){
			$mail = $_POST['debannir'];
			$manager->debannir($mail);
			echo "<script type='text/javascript'>document.location.href='utilisateuradmin.php';</script>";
		}

		// <--------------------------- supprimer une Catégorie --------------------------->
		if(isset($_POST['supprimerCat'])and $_SESSION['type']=="admin"){
			//méthode qui supprime la catégorie
			$managerP->supprimerCat($_POST['supprimerCat']);
			echo "<script type='text/javascript'>document.location.href='utilisateuradmin.php';</script>";
		}

		include("footer.inc.php");
	?>
	<!-- JAVASCRIPT  -->
<script type="text/javascript">

	function voirusers() {
        document.getElementById("user").style.display = 'block';
        document.getElementById("ajoutCat").style.display = 'none';
        document.getElementById("photoGestion").style.display = 'none';
        document.getElementById("supCat").style.display = 'none';
    }
    function voirajout(){
    	document.getElementById("ajoutCat").style.display = 'block';
        document.getElementById("user").style.display = 'none';
        document.getElementById("photoGestion").style.display = 'none';
        document.getElementById("supCat").style.display = 'none';
    }
    function supprimerPhoto(){
    	document.getElementById("photoGestion").style.display = 'block';
    	document.getElementById("user").style.display = 'none';
    	document.getElementById("ajoutCat").style.display = 'none';
    	document.getElementById("supCat").style.display = 'none';
    }

    function supprimerCat(){
    	document.getElementById("photoGestion").style.display = 'none';
    	document.getElementById("user").style.display = 'none';
    	document.getElementById("ajoutCat").style.display = 'none';
    	document.getElementById("supCat").style.display = 'block';
    }
</script>
