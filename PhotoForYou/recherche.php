<?php include("head.inc.php"); ?>
<body>
 <?php include("header.inc.php");?>
 <div id="container" style="margin-left: 5% ; margin-right: 5% ; margin-top: 1%;">
 	<?php
	 	if ( isset($_POST['recherche']) ){
	 		echo $managerP->recherchePhoto($_POST['recherche']);
	 	}else{
	 		echo"<script type='text/javascript'>document.location.href='index.php';</script>";
	 	}
 	?>