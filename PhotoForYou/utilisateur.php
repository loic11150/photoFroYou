<?php include("head.inc.php"); ?>

<body>
<!-- barre de navigation --> 
    <?php include("header.inc.php");
    if(!isset($_SESSION['mail'])){
    	echo"<script type='text/javascript'>document.location.href='index.php';</script>";
    }
    ?>
    <div id="container" style="margin-left: 5% ; margin-right: 5% ; margin-top: 1%;">
		
		<!-- //bouton supprimer compte  -->
						
				<center><h1>Paramètres de compte</h1></center>
				<form method="POST">
					<button type="submit" name="supprimer" class="btn btn-primary btn-block" style="width: 20%; margin-bottom:2%;">Supprimer compte</button>
				</form>
			<?php 
			//si c'est un client on dit que supprimer le compte supprime tous ses crédits et si c'est un photographe on dit que ses photos seront supprimer	
			if($_SESSION['type'] =="client" and $_SESSION['type'] !="admin"){
				echo "Cela entraînera la perte <b>définitive</b> de vos crédits !";
			}else if($_SESSION['type'] !="admin"){
				echo "Cela entraînera le retrait de toutes vos photographies.";
			}
			//confirmation suppression
			if(isset($_POST['supprimer'])){
				echo "<p style='color:red'>Etes vous sûr de vouloir supprimer votre compte?</p>
				<form method='POST'><button type='submit' name='confirmer' class='btn btn-danger btn-block' style='width: 20%;'>Confirmer suppression</button>
				</form>";
			}
			//suppression / redirection / creation cookie pour avoir l'information qu'on ai supprimer le user
			if(isset($_POST['confirmer'])){
				$test = $manager->delete($_SESSION['mail']);
				echo"<script type='text/javascript'>document.location.href='deconnexion.php';</script>";
				$alert = "aaa";
				setcookie('suppr', $alert, time() + 1*60);
			}
			//si c'est un photographe il peut voir ses photos
			if($_SESSION['type'] == "photographe"){
				echo '<button id="voirPhotos" class="btn btn-primary btn-block" style="width: 20%; margin-bottom:2%;" onclick="voirmesphotos()">Afficher mes photos</button>';
				echo '<div id="mesphotos" style="display : none ;">'.$managerP->afficherMesPhotos($_SESSION['mail']).'</div>';
			}
		?>

			
			
			
	</div>
</body>
<?php 

	include("footer.inc.php");?>
<script type="text/javascript">
    function voirmesphotos(){
    	document.getElementById("mesphotos").style.display = 'block';
    }
</script>