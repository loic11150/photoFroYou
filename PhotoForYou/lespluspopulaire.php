<!-- head -->
<?php include("head.inc.php"); ?>
<body>
	<?php include("header.inc.php"); ?>
	<div id="container"style="margin-left: 5% ; margin-right: 5% ; margin-top: 2%;">
	<!-- barre de navigation --> 
	    <?php 
	    	// affichage photo
	    	echo $managerP->afficherPhoto();
	    ?>
	</div>

	<?php include("footer.inc.php"); ?>