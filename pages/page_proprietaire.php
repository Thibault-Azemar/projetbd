<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 

	$idpersonne = $_SESSION['id'];

	$reqmaison = $BDD->prepare("SELECT * FROM maison WHERE maison.Id_Personne  = ? ");
   	$reqmaison->execute(array($idpersonne));


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
    	Bonjour Cher(e) propriétaire. 
    	<br/>

    	<table>

    		<caption>Liste des personnes occupant vos maisons </caption>

    		<thead>
    			<tr>
    				<th> Maisons </th>
    				<th> Locataires </th>
    			</tr>

    		</thead>

      	<?php
      		while ($maison= $reqmaison->fetch())
      		{?>
      			<tr>
      			<td>
      				<?php
      				echo "Maison n°".$maison['Id_Maison']." ".$maison['Num_rue']." ".$maison['Rue']." ".$ville['Nom']; 

      				//afficher les infos de la maison

      				$reqhabitant = $BDD->prepare("SELECT * FROM appartement WHERE appartement.Id_Maison = ?");
   					$reqhabitant->execute(array($maison['Id_Maison']));
   					$habitant= $reqhabitant->fetch()

   					$reqpersonne = $BDD->prepare("SELECT * FROM personne WHERE personne.Id_Personne = ?");
   					$reqpersonne->execute(array($habitant['Id_Personne']));
      				?>
      			</td> 
      				<?php
      				while ($personne= $reqpersonne->fetch())
      				{
      				?>
      					<td>
      						<?php 
      						echo "Nom : ".$personne['nom']." Prenom : ".$personne['prenom']."</br> Numéro de tel : ".$personne['num_tel'];
      						?>
      					</td>
      				<?php
      				}
      				?>
      			</tr>
		<?php
      	}
      	?>
		</table>

		</br>	
		
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