<?php 
// Classe qui va gérer la manipulation des objets Clients et de la BDD
	class UsersManager{
		protected $_db;

		// On fixe la BDD
		public function setDb(PDO $db){
			$this->_db = $db;
		}

		public function __construct($db){
			$this->setDB($db);
		}

		// CRUD

		// Ajout d'un user
		public function add(Users $users){
			$q = $this->_db->prepare('INSERT INTO USERS(email, type, prenom, nom, pseudo, motDePasse, credits, ban) VALUES(:email, :type, :prenom, :nom, :pseudo, :motDePasse, :credits, :ban)');	
			$q->bindValue(':email', $users->getEmail());
			$q->bindValue(':type', $users->getType());
			$q->bindValue(':prenom', $users->getPrenom());
			$q->bindValue(':nom', $users->getNom());
			$q->bindValue(':pseudo', $users->getPseudo());
			$q->bindValue(':motDePasse', $users->getMotDePasse());
			$q->bindValue(':credits', $users->getCredits());
			$q->bindValue(':ban' ,$users->getBan());
			$q->execute();

		}

		// Modification d'un user
		public function update(Users $users){
			$q = $this->_db->prepare('UPDATE USERS 
				SET email = :email, type = :type, prenom = :prenom, pseudo = :pseudo, motDePasse = :mdp, credits = :credits
				WHERE email = :email');
			$q->bindValue(':email', $users->getEmail(), PDO::PARAM_STR);
			$q->bindValue(':type', $users->getType(), PDO::PARAM_STR);
			$q->bindValue(':prenom', $users->getPrenom(), PDO::PARAM_STR);
			$q->bindValue(':nom', $users->getNom(), PDO::PARAM_STR);
			$q->bindValue(':pseudo', $users->getPseudo(), PDO::PARAM_STR);
			$q->bindValue(':mdp', $users->getMotDePasse());
			$q->bindValue(':credits', $users->getCredits(), PDO::PARAM_INT);
			$q->execute();
		}

		// Retourne un objet de type users en fonction de l'identifiant passé en paramètre
		public function get($id_user){
			$id_user = (int) $id_user;
			$q = $this->_db->query('SELECT * FROM USERS Where id_user = "'.$id_user.'"');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);

			// On retourne un objet de type user
			return new Users($donnees);
		}
		//utiliser pour connection
		public function exist($mail, $mdp){

			$requete = 'SELECT COUNT(*) as count FROM USERS WHERE email = :mail AND motDePasse = :mdp';
	 		
			// Preparation -> aide à prévenir les attaques par injection SQL en éliminant le besoin de protéger les paramètres manuellement.
			$q = $this->_db->prepare($requete);
	 
			// execution
			$q->execute( array(':mail' => $mail, ':mdp' => $mdp) );

			$row = $q->fetch(PDO::FETCH_BOTH);

			if ($row['count'] > 0){
				return "true";
			} else {
				return "false";
			}	
		}
		//mail existe
		public function mailExist($mail){
			$requete = 'SELECT COUNT(*) as count FROM USERS WHERE email = :mail';
			// Preparation
			$q = $this->_db->prepare($requete);	 
			// execution
			$q->execute( array(':mail' => $mail) );
			$row = $q->fetch(PDO::FETCH_BOTH);
			if ($row['count'] == 0){
				return "true";
			} else {
				return "false";
			}	
		}
		// Autres méthodes 

		//récupérer dans la BDD si l'user est client ou photographe
		public function recupType($mail){
			$requete = 'SELECT type FROM USERS where email ="'.$mail.'"';
			$q = $this->_db->query($requete);

			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['type'] ;
		}

		//récupérer dans la BDD si l'id
		public function recupId($mail){
			$requete = 'SELECT id_user FROM USERS where email ="'.$mail.'"';
			$q = $this->_db->query($requete);

			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['id_user'] ;
		}

		//Récupérer dans la BDD le Pseudo
		public function recupPseudo($mail){
			$requete = 'SELECT pseudo FROM USERS where email ="'.$mail.'"';
			$q = $this->_db->query($requete);

			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['pseudo'] ;
		}

		//récupère la date de ban si users est ban
		public function banni($mail){
			// appel de la routine deban, si date de ban est dépassé
			$p = $this->_db->query('CALL deban("'.$mail.'")');
			$q = $this->_db->query('SELECT ban FROM USERS where ban is not null and email = "'.$mail.'";');

			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['ban'];
		}	

		public function afficherMesCredits($mail){
			$q = $this->_db->query('SELECT credits FROM users where email = "'.$mail.'"');
			
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			return $donnees['credits'];
		}
//méthode payer 
		public function payer($mail,$idPhoto){
			$mesCredits = $this->afficherMesCredits($mail);
			
			$where = "";
			foreach ($idPhoto as $key => $value) {
				$where .= " id_photo = '".$value."' or";
			}
			$where = substr($where,0,-2);	
			$q = $this->_db->query('SELECT SUM(prix) from photo where '.$where.'');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			$prix = $donnees['SUM(prix)'] ;

			if($prix <= $mesCredits){
				$q = $this->_db->query('update users set credits = credits - '.$prix.' where email = "'.$mail.'"') ;
				foreach ($idPhoto as $key => $value) {
					$q = $this->_db->query('INSERT INTO photo_achete (id_user,id_photo,date_achat) values('.$this->recupId($mail).','.$value.',"'.date("Y-m-d H:i:s").'")');
					$q = $this->_db->query('SELECT prix, id_user from photo where id_photo = "'.$value.'";');
					$donnees = $donnees = $q->fetch(PDO::FETCH_ASSOC);
					
					$q = $this->_db->query('update users set credits = credits + '.$donnees['prix'].' where id_user =  '.$donnees['id_user'].'');
				}

				return true ; 
			}else{
				return false ;
			}
			
		}
		public function achat_credits($mail,$somme){
			$q = $this->_db->query('update users set credits = credits + '.$somme.' where email = "'.$mail.'"');
			
		}
	}
// 	$user = new Users([
// 	'email' => 'fffff',
// 	'type' => 'client',
// 	'prenom' => "Mec",
// 	'nom' => "lambda",
// 	'pseudo'=>"Pseudo ",
// 	'credit' => 0]);
// echo $user ;

// try {
// 	$db = new PDO('mysql:host=127.0.0.1;dbname=photoforyou','root');
// } 
// catch (PDOException $e) {
// 	echo "Erreur : ".$e->getMessage();
// 	die();
// }

// $manager = new UsersManager($db);
// $manager->add($user);
?>