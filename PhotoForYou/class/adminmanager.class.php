<?php
	//classe qui hérite de usersmanager
	class AdminManager extends usersmanager{
		
		public function afficherListe($mail){			
			$code ="" ;		
				$q = $this->_db->query('SELECT libelle FROM liste ;');
				while($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
					//--------------------------------- pour que le lien quand le libellé à des espaces/ des é les remplace
						$str = strtolower($donnees['libelle']);
						$str = str_replace("&eacute", "e",$str);
						$str = str_replace(" ", "",$str);
					//---------------------------------
						$code .= '<a class="dropdown-item" href="'.$str.'.php">'.$donnees['libelle'].'</a>';
				}						
			 return $code;
		}
		
		//bannir un users 
		public function bannirUser($mail,$date){
			$q = $this->_db->query('UPDATE users SET ban = "'.$date.'" WHERE email = "'.$mail.'";');
		}
		public function debannir($mail){
			// appel de la routine debanAdmin, qui deban 
			$p = $this->_db->query('CALL debanAdmin("'.$mail.'")');
		}
		// Supression d'un user
		public function delete($mail){
			$this->_db->exec('DELETE FROM users WHERE email = "'.$mail.'"') or die("ne fonctionne pas");
		}
		// Liste de tout les users
		public function getList(){
			// Retourne tout les users
			$users = [];

			$q = $this->_db->query('SELECT * FROM USERS ORDER BY type,nom');

			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
				$users[] = new Users($donnees);
			}
			
			return $users;
		}
	}
?>