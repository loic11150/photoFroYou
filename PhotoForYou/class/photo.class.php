<?php
	
	class Photo{
		//attributs photo
		private $_id_photo;
		private $_nom_photo;
		private $_taille_pixels_x;
		private $_taille_pixels_y;
		private $_poids;
		private $_url_photo;
		private $_id_user;
		private $_id_cat;
		private $_prix;
		private $_mot_clef;
		
		//constructeur qui appelle hydrate 
		public function __construct(array $donnees){
				$this->hydrate($donnees);
		}
		//hydrate qui appelle les setter de photos avant d'attribuer les données à l'objet
		public function hydrate(array $donnees){
			foreach ($donnees as $key => $value) {
				$method = 'set'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}

		//méthode magique
		public function __toString(){
			return "<td>".$this->_id_photo."</td><td>".$this->_nom_photo."</td><td>".$this->_taille_pixels_x."</td><td>".$this->_taille_pixels_y."</td><td>".$this->_poids."</td><td>".$this->_url_photo."</td><td>".$this->_id_user."</td><td>".$this->_id_cat."</td><td>".$this->_prix."</td><td>".$this->_mot_clef.'</td>' ;
		}

		//getters et setters

		public function getId_photo(){
			return $this->_id_photo;
		}
		public function getNom_photo(){
			return $this->_nom_photo;
		}
		public function getTaille_pixels_x(){
			return $this->_taille_pixels_x;
		}
		public function getTaille_pixels_y(){
			return $this->_taille_pixels_y;
		}
		public function getPoids(){
			return $this->_poids;
		}
		public function getUrl_photo(){
			return $this->_url_photo;
		}
		public function getId_user(){
			return $this->_id_user;
		}
		public function getId_cat(){
			return $this->_id_cat;
		}
		public function getPrix(){
			return $this->_prix;
		}
		public function getMot_clef(){
			return $this->_mot_clef;
		}

		public function setId_photo($id){
			$id = (int) $id;
			//si c'est pas un int = 0
			if($id > 0){
				$this->_id_photo = $id;
			}
		}
		public function setNom_photo($nom){
			if (is_string($nom)){
				$this->_nom_photo = $nom;
			} 
		}
		public function setTaille_pixels_x($x){
			if($x < 2400){
				$this->_taille_pixels_x = $x;
			} 
		}
		public function setTaille_pixels_y($y){
			if($y < 1600){
				$this->_taille_pixels_y = $y;
			} 
		}
		public function setPoids($poids){
		
				$this->_poids = $poids ;
		
		}
		public function setUrl_photo($chem){
			if(is_string($chem)){
				$this->_url_photo = $chem;
			} 
		}
		public function setId_user($id){
			$id = (int) $id ;
			if($id > 0){
				$this->_id_user = $id;
			}
			
		}
		public function setId_cat($id){
			$id = (int) $id;
			if ($id > 0){
				$this->_id_cat = $id ;
			}
		}
		public function setPrix($prix){
			$prix = (int) $prix;
			if ($prix > 2 and $prix < 100){
				$this->_prix = $prix ;
			}
		}
		public function setMot_clef($kw){
			if(is_string($kw)){
				$this->_mot_clef = $kw;
			} 
		}
	}
?>