<?php
session_start();  

		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		if(isset($_POST['Boutton_Connex']))
		{

			$Identifiant_Connex=htmlspecialchars($_POST['Identifiant_Connex']); 
			$MotDePasse_Connex=$_POST['MotDePasse_Connex']; 
			$Mdp_modif=sha1($MotDePasse_Connex);
			if(!empty($Identifiant_Connex) AND !empty($MotDePasse_Connex))
			{
				$requser=$BDD->prepare("SELECT * FROM compte WHERE email = ? AND motdepasse = ?"); 
				$requser->execute(array($Identifiant_Connex , $Mdp_modif));
				$userexist=$requser->rowCount();  
				if($userexist==1)
				{
					$userinfo = $requser->fetch();
         			$_SESSION['id'] = $userinfo['Id_Compte'];
         			$_SESSION['email'] = $userinfo['email'];
         			header("Location: pages/Page_utilisateur.php?id=".$_SESSION['id']);
				}
				else{
					$erreur="Mauvais identifiant ou mot de passe"; 
				}
			}
			else
			{
				$erreur="Tous les champs doivent être complètés !"; 
			}
		}
 ?>
 <!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Projet BDD </title>
  <link rel="stylesheet" href="pages/style.css">
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
		<form method="POST" action="">
			<label for="formulaire_connexion">
			Identifiant:</label>
			<input type="email"  id="Identifiant_Connex" name="Identifiant_Connex" />
		</br></br>
			<label for="formulaire_connexion">
			Mot de passe:</label>
			<input type="password" id="MotDePasse_Connex" name="MotDePasse_Connex" />
		</br></br>
		<input type="submit" id="Boutton_Connex" name="Boutton_Connex" value="Connexion"/>
	</div>
	
	<?php 
		
		if(isset($erreur))
		{
			echo '<font color="red">'.$erreur."</font>"; 
		}
 ?>
	<div class="Création de Compte">
		<a href="pages/creationcompte.php"><font color="#0000FF">Vous ne possèdez aucun compte ?</a>
	</div>

</body>
</html>