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
					$requser2=$BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ? AND motdepasse = ?"); 
					$requser2->execute(array($Identifiant_Connex , $Mdp_modif));
					$userexist2=$requser2->rowCount();
					if($userexist2==1)
					{
						$userinfo2 = $requser2->fetch();
						$_SESSION['id'] = $userinfo2['Id_Compte'];
						$_SESSION['email'] = $userinfo2['email'];
						header("Location: pages/Page_utilisateur.php?id=".$_SESSION['id']);
					}
					else
					{
						$erreur="Mauvais identifiant ou mot de passe";
					}
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
	<header>
			<ul>
				<li><a href="pages/creationcompte.php">Vous ne possèdez aucun compte ?</a></li>
				
			</ul>
		</header>
<div class="Connexion" align="center">
	<h1>Page D'Accueil </h1>
	<font color="#000000">
	
		<h2>Connexion</h2>
		<form method="POST" action="">
			<label for="formulaire_connexion">
			Identifiant:</label>
			<input type="text"  id="Identifiant_Connex" name="Identifiant_Connex" />
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
<footer>
		<p>&copy; 2020 - Les Imposteurs</p>
	</footer>
</body>
</html>