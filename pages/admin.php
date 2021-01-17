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


		<?php 
		if (isset($_POST['Bouton_Admin']))
		{
			$COMPTE=$_POST['COMPTE'];
			if(!empty($COMPTE))
			{
				$requser=$BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?"); 
				$requser->execute(array($COMPTE));
				$userexist=$requser->rowCount(); 
				if($userexist ==1)
				{
					$reqadmin=$BDD->prepare("UPDATE compte SET etat = 1 WHERE Id_Compte  = ?");
					$admin->execute(array($COMPTE));
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
					$admin->execute(array($ACOMPTE));
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
			$Identifiant_compte=$_POST['Identifiant_compte'];
			if(!empty($Identifiant_compte))
			{
				$requser=$BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?"); 
				$requser->execute(array($COMPTE));
				$userexist=$requser->rowCount(); 
				if($userexist ==1)
				{
					$reqadmin=$BDD->prepare("UPDATE compte SET etat = 0 WHERE Id_Compte  = ?");
					$admin->execute(array($ACOMPTE));
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
		</br>	
		<form method="POST" action="" enctype="multipart/form-data">
			<label> Entrer l'identifiant du compte à rendre administrateur : </label>
			<input type="number" name="COMPTE" placeholder="id compte"/>
			<input type="submit" id="Bouton_Admin" value="Rendre Administrateur"/></br>
		</form>
		<form method="POST" action="" enctype="multipart/form-data">
			<label> Entrer l'identifiant du compte à enlever des administrateurs : </label>
			<input type="number" name="ACOMPTE" placeholder="id compte"/>
			<input type="submit" id="Bouton_Non_Admin" value="Enlever des Administrateurs"/></br>
		</form>
		<form method="POST" action="" enctype="multipart/form-data">
			<label> Entrer l'identifiant de la personne à supprimer :</label>
			<input type="number" name="supprimer" placeholder="id personne"/>
			<input type="submit" id="Bouton_Suppr" value="Supprimer Utilisateur"/></br>
		</form>


		


    </body>


<!-- administrateur : 
			- supprimer les personnes
			- rendre compte administrateur
-->


</html>