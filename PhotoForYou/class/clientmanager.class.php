<?php
	//classe qui hérite de usersmanager
	class clientManager extends usersmanager{

		//si afficher liste déroulante
		public function afficherListe($mail){
			
			$code ="" ;

				$q = $this->_db->query('SELECT libelle FROM liste WHERE type = 2 OR type = 1 ;');
				while($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
					//--------------------------------- pour que le lien quand le libellé à des espaces/ des é 
					$str = strtolower($donnees['libelle']);
					$str = str_replace("&eacute", "e",$str);
					$str = str_replace(" ", "",$str);
					//---------------------------------
					$code .= '<a class="dropdown-item" href="'.$str.'.php">'.$donnees['libelle'].'</a>';
				}
					
			 return $code;
		}
	}
?>