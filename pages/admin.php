<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 

		if (isset($_POST['Bouton_Admin']))
		{
			$COMPTE=$_POST['COMPTE'];
			if(!empty($COMPTE))
			{
				$requser=$BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?"); 
				$requser->execute(array($COMPTE));
				$userexist=$requser->rowCount(); 
				if($userexist == 1 )
				{
					$reqadmin=$BDD->prepare("UPDATE compte SET etat = 1 WHERE Id_Compte  = ?");
					$reqadmin->execute(array($COMPTE));
				}
				else
				{
					$erreur ="L'identifiant n'existe pas veuillez vérifier dans la liste";
				}
			}
			else
			{
				$erreur = "Veuillez rentrer un identifiant de compte";
			}
		}


		if (isset($_POST['Bouton_Non_Admin']))
		{
			$ACOMPTE=$_POST['ACOMPTE'];
			if(!empty($ACOMPTE))
			{
				$requser=$BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?"); 
				$requser->execute(array($ACOMPTE));
				$userexist=$requser->rowCount(); 
				if($userexist ==1)
				{
					$reqadmin=$BDD->prepare("UPDATE compte SET etat = 0 WHERE Id_Compte  = ?");
					$reqadmin->execute(array($ACOMPTE));
				}
				else
				{
					$erreur ="L'identifiant n'existe pas veuillez vérifier dans la liste";
				}
			}
			else
			{
				$erreur = "Veuillez rentrer un identifiant de compte";
			}
		}

		
		if (isset($_POST['Bouton_Suppr']))
		{
			$Id_supprimer=$_POST['supprimer'];
			if(!empty($Id_supprimer))
			{
				$requser=$BDD->prepare("SELECT * FROM personne WHERE Id_Personne = ?"); 
				$requser->execute(array($Id_supprimer));
				$userexist=$requser->rowCount(); 
				if($userexist ==1)
				{
					$reqadmin=$BDD->prepare("DELETE FROM personne WHERE Id_personne = ?");
					$reqadmin->execute(array($Id_supprimer));
				}
				else
				{
					$erreur ="L'identifiant n'existe pas veuillez vérifier dans la liste";
				}
			}
			else
			{
				$erreur = "Veuillez rentrer un identifiant de compte";
			}
		}
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
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page utilisateur</a></li>
				<li><a href="page_anonyme.php">Graphiques</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
    	Bonjour Cher(e) Administrateur. <br/>

    	<table>

    		<caption>Liste des personnes utilisant le site </caption>

    		<thead>
    			<tr>
    				<th> Identifiant de la personne </th>
    				<th> Identifiant du compte </th>
    				<th> Date création compte </th>
    				<th> Etat (1 = admin) </th>
    				<th> Email </th>
    				<th> Date naissance </th>
    				<th> Nom </th>
    				<th> Prenom </th>
    				<th> Téléphone </th>
    			</tr>

    		</thead>

      	<?php
      		$requtil =$BDD->query("SELECT DISTINCT * FROM compte RIGHT JOIN personne ON compte.Id_Personne = personne.Id_Personne");
      		while ($donnee= $requtil->fetch())
      		{?>
      			<tr>
      				<td><?php echo $donnee['Id_Personne']; ?></td>
      				<td><?php echo $donnee['Id_Compte']; ?></td>
      				<td><?php echo $donnee['date_creation']; ?></td>
      				<td><?php echo $donnee['etat']; ?></td>
      				<td><?php echo $donnee['email']; ?></td>
      				<td><?php echo $donnee['date_naissance']; ?></td>
      				<td><?php echo $donnee['nom']; ?></td>
      				<td><?php echo $donnee['prenom']; ?></td>
      				<td><?php echo $donnee['num_tel']; ?></td>

		<?php
      	}
      	?>
		</table>


		</br>	
		<form method="POST" action="" enctype="multipart/form-data">
			<label> Entrer l'identifiant du compte à rendre administrateur : </label>
			<input type="number" name="COMPTE" placeholder="id compte"/>
			<input type="submit" id="Bouton_Admin" name="Bouton_Admin" value="Rendre Administrateur"/></br>
		</form>
		<form method="POST" action="" enctype="multipart/form-data">
			<label> Entrer l'identifiant du compte à enlever des administrateurs : </label>
			<input type="number" name="ACOMPTE" placeholder="id compte"/>
			<input type="submit" id="Bouton_Non_Admin" name="Bouton_Non_Admin" value="Enlever des Administrateurs"/></br>
		</form>
		<form method="POST" action="" enctype="multipart/form-data">
			<label> Entrer l'identifiant de la personne à supprimer :</label>
			<input type="number" name="supprimer" placeholder="id personne"/>
			<input type="submit" id="Bouton_Suppr" name="Bouton_Suppr" value="Supprimer Utilisateur"/></br>
		</form>

		<?php 
		if(isset($erreur))
		{
			echo '<font color="red">'.$erreur."</font>"; 
		}
		?>
		


    </body>


<!-- administrateur : 
			- supprimer les personnes
			- rendre compte administrateur
-->


</html>