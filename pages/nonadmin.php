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
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
				<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="tableau_de_bord.php?id=<?php echo $_SESSION['id'];?>">Tableau de Bord</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
    	Désolé votre compte n'est pas enregistré comme administrateur. <br/> Vous avez la possivilité de faire une demande à l'adresse mail suivante : <br/>
    	....@etu.univ-tours.com <br/>

    	 


    </body>
</html>

