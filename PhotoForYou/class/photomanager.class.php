<?php  

	//class qui gère la manip des photo dans la bdd 
	class PhotoManager{
		private $_db;

		// On fixe la BDD
		public function setDb(PDO $db){
			$this->_db = $db;
		}
		public function __construct($db){
			$this->setDB($db);
		}
	// CRUD

		// Ajout d'une photo
		public function add(Photo $photo){
			$q = $this->_db->prepare('INSERT INTO PHOTO(nom_photo, taille_pixels_x, taille_pixels_y, poids, url_photo, id_user, id_cat, prix, mot_clef) VALUES(:nom_photo, :taille_pixels_x, :taille_pixels_y, :poids, :url_photo, :id_user, :id_cat, :prix, :mot_clef)');	
			$q->bindValue(':nom_photo', $photo->getNom_photo());
			$q->bindValue(':taille_pixels_x', $photo->getTaille_pixels_x());
			$q->bindValue(':taille_pixels_y', $photo->getTaille_pixels_y());
			$q->bindValue(':poids', $photo->getPoids());
			$q->bindValue(':url_photo', $photo->getUrl_Photo());
			$q->bindValue(':id_user', $photo->getId_user());
			$q->bindValue(':id_cat', $photo->getId_cat());
			$q->bindValue(':prix', $photo->getPrix());
			$q->bindValue(':mot_clef', $photo->getMot_clef());
			$q->execute();

		}

		//récuperer les catégories photos et afficher dans le formulaire ajouter photo
		public function afficherCat(){
			$code ="" ;
			
				$q = $this->_db->query('SELECT categorie FROM cat_photo ORDER BY categorie;');
					while($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
					$code .='<option value="'. $donnees['categorie'].'">'. $donnees['categorie'].'</option>';
			}			
			 return $code;
		}

		//récupérer l'id de la catégorie de photo 
		public function recupIdCat($cat){
			$q = $this->_db->query('SELECT id_cat FROM cat_photo where categorie = "'.$cat.'";');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['id_cat'] ;
		}

		//récuperer tout les id des photos
		public function recupId(){
			$q = $this->_db->query('SELECT id_cat FROM cat_photo;');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees ;
		}
		
		//Afficher les photos dans l'ordre décroissant par id 
		public function afficherPhoto(){
			$q = $this->_db->query('SELECT * from photo order by id_photo desc ;');
			
			$code = "";
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
				$tag = $donnees['mot_clef'];
				$tag = explode(",", $tag);
				$tag2 = "";
				foreach ($tag as $value) {
					$tag2 .= "#".$value;
				}
				$code .= "<div id='block_img'>
							<a href='photo.php?lien=".$donnees['url_photo']."'>
								<img src='".$donnees['url_photo']."' style='height: 10% ; width:20%; margin-right : 2%;'/>
       						</a>
       						<p style='width: 20%; background-color: #e5e5e5 ; word-wrap: break-word;'>".$tag2."</p>

       					</div>";
			}
			return $code ; 
		}

		//Afficher les données des photos 
		public function donneesPhoto(){
			$q = $this->_db->query('SELECT * FROM photo order by id_photo desc;');
			while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
				$photo[] = new Photo($donnees);
				//$photo[] = $donnees['id_photo'];
			}

			return $photo ;
		}

		//ajouter une catégorie
		public function addCategorie($cat){
			//requete + execution
			$q= $this->_db->query('INSERT INTO cat_photo (categorie) values("'.$cat.'")');

		}

		//afficher les photos du photographe
		public function afficherMesPhotos($mail){
			//requete
			$q = $this->_db->query('SELECT url_photo FROM photo,users where photo.id_user = users.id_user and email = "'.$mail.'" order by id_photo desc;');
			//code qu'on incrémente à chaque données du tableau
			$code = "";
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
				$code .= "<img src='".$donnees['url_photo']."' style='height: 10% ; width:20%; margin-right : 2%;'/>" ;
			}
			return $code ; 
		}

		//supprimer photo de la BDD sql (là où sont stockés les )
		public function supprimerPhotoBddSQL($id){
			// requete supression BBD MYSQL
			$q = $this->_db->query('DELETE from photo where id_photo = "'.$id.'";');

			}

		//supprimer de la bdd là ou sont stockés les photos
		public function supprimerPhotoBdd($id){
			//---suppression de la bdd_image(IMAGE STOCKEE)--- 
			$s = $this->_db->query('SELECT url_Photo from photo where id_photo = "'.$id.'";');
			//recup chemin
			$s = $s->fetch(PDO::FETCH_ASSOC);
			//récup le chemin dzns variable
			$chem1 = $s['url_Photo'];
			$chem = explode("/", $chem1);
			$ouvre = opendir($chem[0]."/".$chem[1]);
			// echo $ouvre ;
			unlink($chem1);
			// $ferme = closedir($chem[0]."/".$chem[1]);

			//fonction qui supprime la photo
			// unlink($chem);
		}

		//Afficher les données des catégories 
		public function donneesCat(){
			$q = $this->_db->query('SELECT * FROM cat_photo ;');
			$cat = "";
			while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
				$id = $donnees['id_cat'];
				$categorie = $donnees['categorie'];
				$cat .="<tr><td>".$id."</td><td>".$categorie."</td><td><form method='POST'><button type='submit' value='".$id."' name='supprimerCat' class='btn btn-danger')'>Supprimer catégorie</button></form></td></tr>";
			}
			return $cat ;
		}
		//supprimer catégorie et photos qu'elle contient
		public function supprimerCat($id){
			$q1 = $this->_db->query('select * from photo where id_cat = '.$id.';');
			while($donnees = $q1->fetch(PDO::FETCH_ASSOC)){
				//---suppression de la bdd_image(IMAGE STOCKEE)--- 
				$s = $this->_db->query('SELECT url_Photo from photo where id_photo = "'.$donnees['id_photo'].'";');
				//recup chemin
				$s = $s->fetch(PDO::FETCH_ASSOC);
				//récup le chemin dzns variable
				$chem1 = $s['url_Photo'];
				$chem = explode("/", $chem1);
				$ouvre = opendir($chem[0]."/".$chem[1]);
				// echo $ouvre ;
				unlink($chem1);
				//suppression BDD sql
				$this->_db->query('DELETE from photo where id_photo = "'.$donnees['id_photo'].'";');
				
			}

			$q3 = $this->_db->query('select categorie from cat_photo where id_cat ='.$id.';');
			
			while($donnees = $q3->fetch(PDO::FETCH_ASSOC)){
				rmdir("BDD_IMAGE/".strtoupper($donnees['categorie']));
			}
			$q2 = $this->_db->query('delete from cat_photo where id_cat ='.$id.' ; ');

		}

		public function recherchePhoto($tag){
			$q = $this->_db->query('SELECT * from photo where mot_clef like "%'.$tag.'%"');
			
			$code = "";
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
				$tag = $donnees['mot_clef'];
				$tag = explode(",", $tag);
				$tag2 = "";
				foreach ($tag as $value) {
					$tag2 .= "#".$value;
				}
				$code .= "<div id='block_img'>
							<a href=''>
								<img src='".$donnees['url_photo']."' style='height: 10% ; width:20%; margin-right : 2%;'/>
       						</a>
       						<p style='width: 20%; background-color: #e5e5e5 ; word-wrap: break-word;'>".$tag2."</p>

       					</div>";
			}
			return $code;
		}

		//afficher une photo avec son lien
		public function afficherUnePhoto($lien){
			$q = $this->_db->query('SELECT id_photo,prix from photo where url_Photo = "'.$lien.'"');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			$code = "<div id='block_img'>
							
						<center><img src='".$lien."' style='height: 50% ; width:30%;'/>
						<p>".$donnees['prix']." Crédits</p>
						<form method='POST'><button type='input' name='panier' value='".$donnees['id_photo']."' class='btn btn-primary'>Ajoutez au panier !</button></form></center>

       				</div>";
       		return $code;
		}

		//afficher le prix des photos d'une liste
		public function calculPrixPhoto($listePhoto){
			$where = "";
			foreach ($listePhoto as $key => $value) {
				$where .= " id_photo = '".$value."' or";
			}
			$where = substr($where,0,-2);	
			$q = $this->_db->query('SELECT SUM(prix) from photo where '.$where.'');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['SUM(prix)'] ;
		}
		//users id -> voir ses photos achetés avec l'id de l'users
		public function voirMesPhotos($id){
			$q = $this->_db->query('select id_photo from photo_achete where id_user =  '.$id.';');
			$id = array();
				
			foreach ($q as $donnees) {
				$q =  $this->_db->query('SELECT url_photo,nom_photo from photo where id_photo = "'.$donnees['id_photo'].'"');
				$id[] = $q->fetch(PDO::FETCH_ASSOC);
			}
			
			$code = "";

			foreach ($id as $key => $value) {

				$code .= "<img src='".$value['url_photo']."' style='height: 10% ; width:10%;'/><button type='download' name='panier' value='".$donnees['id_photo']."' class='btn btn-success'><a style='text-decoration = none;' download='".$value['nom_photo']."' href='".$value['url_photo']."'>Téléchargez !</button>";
			}
			return $code ;
		}
	}
?>
