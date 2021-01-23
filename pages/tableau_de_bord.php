<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 

?>
<html>
   <head>

      <title>Projet BDD</title>
      <meta charset="utf-8">
	    <link rel="stylesheet" href="style.css">

   </head>

   <body>

		<header>

			<ul>

				<li><a href="editionprofil.php">Editer mon profil</a></li>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
				<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>		


				
				
			</ul>

		</header>
		
	</body>
</html>
