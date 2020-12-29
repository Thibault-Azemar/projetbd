<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Projet BDD </title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Page D'Accueil </h1>
	<div align="right" class="Page_anonyme">
		 <a href="pages/page_anonyme.php"><font color="#0000FF">Page anonyme | </a>
		 	<a href="pages/Page_Administrateur.php"><font color="#0000FF">Administrateur</a>
	</div>
	<font color="#000000">
	<div class="Connexion">
		<h2>Connexion</h2>
		<form method="POST" action="pages/Page_utilisateur.php">
			<label for="formulaire_connexion">
			Identifiant:</label>
			<input type="text"  id="Identifiant" name="Identifiant" />
		</br></br>
			<label for="formulaire_connexion">
			Mot de passe:</label>
			<input type="password" id="MDP" name="MotDePasse" />
		</br></br>
		<input type="submit" id="boutton" name="boutton" value="Connexion"/>
	</div>
	<div class="Création de Compte">
		<a href="pages/creationcompte.php"><font color="#0000FF">Vous ne possèdez aucun compte ?</a>
	</div>
<?php 
		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		
 ?>
</body>
</html>