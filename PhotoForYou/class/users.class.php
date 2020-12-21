<?php
class users
	{
		// Atrributs d'un users
		private $_Id_users;
		private $_Email;
		private $_Type;
		private $_Prenom;
		private $_Nom;
		private $_Pseudo;
		private $_MotDePasse;
		private $_Credits ;
		private $_ban ;

		//constructeur
		public function __construct(array $donnees){
			$this->hydrate($donnees);
		}
		//hydrate
		public function hydrate(array $donnees){
			foreach ($donnees as $key => $value) {
				$method = 'set'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}

		// Méthode magique
		//affichage par défaut des users
		public function __toString(){
			return "<td>".$this->_Email."</td><td>".$this->_Type."</td><td>".$this->_Nom."</td><td>".$this->_Prenom."</td><td>".$this->_Pseudo."</td><td>".$this->_Credits."</td><td>".$this->_ban."</td>" ;
		}
		
		// Les getters

		public function getId_users(){
			return $this->_Id_users;
		}
		public function getEmail(){
			return $this->_Email;
		}
		public function getType(){
			return $this->_Type;
		}
		public function getPrenom(){
			return $this->_Prenom;
		}
		public function getNom(){
			return $this->_Nom;
		}
		public function getPseudo(){
			return $this->_Pseudo;
		}
		public function getMotDePasse(){
			return $this->_MotDePasse;
		}

		public function getCredits(){
			return $this->_Credits;
		}
		
		public function getBan(){
			return $this->_ban;
		}

		// Les setters

		public function setId_users($Id_users){
			$Id_users = (int) $Id_users;
			// Si c'est pas un entier la convertion donne 0.
			// On suppose que l'Id d'un user ne peut pas être 0
			if ($Id_users > 0){
				$this->_Id_users = $Id_users;
			}
		}

		public function setEmail($Email){
			if (is_string($Email)){
				$this->_Email = $Email;
			}
		}
		public function setType($Type){
			if (is_string($Type) AND ($Type == "photographe" OR $Type == "client" OR $Type = "admin")){
				$this->_Type = $Type;
			}
		}

		public function setPrenom($Prenom){
			if (is_string($Prenom)){
				$this->_Prenom = $Prenom;
			}
		}

		public function setNom($Nom){
			if (is_string($Nom)){
				$this->_Nom = $Nom;
			}
		}
		public function setPseudo($Pseudo){
			if (is_string($Pseudo)){
				$this->_Pseudo = $Pseudo;
			}
		}
		public function setMotDePasse($mdp){
			if (is_string($mdp)){
				$this->_MotDePasse = $mdp;
			}
		}
		public function setCredits($credits){
			
				$this->_Credits = $credits;
				
		}
		public function setBan($date){
			
			$this->_ban = $date;
		
		}
	}
?>