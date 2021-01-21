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
    	Bonjour cher(e) propriétaire. 
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
      				$reqville=$BDD->prepare("SELECT ville.Nom FROM ville RIGHT JOIN maison ON ville.Id_Ville=maison.Id_Ville WHERE maison.Id_Ville= ? "); 

        			$reqville->execute(array($maison['Id_Ville'])); 
        			$ville=$reqville->fetch(); 
      				echo "Maison n°".$maison['Id_Maison']." ".$maison['Num_rue']." ".$maison['Rue']." </br>".$ville['Nom']; 

      				//afficher les infos de la maison
      				
   					$reqpersonne = $BDD->prepare("SELECT personne.Id_Personne, personne.nom, personne.prenom, personne.num_tel FROM appartement RIGHT JOIN personne ON appartement.Id_Personne=personne.Id_Personne WHERE  appartement.Id_Maison = ?");
   					$reqpersonne->execute(array($maison['Id_Maison'] ));
      				?>
      				
      			</td> 
      			<td>
      				<?php
      				while ($personne= $reqpersonne->fetch())
      				{
      				?>
      					</br>
      						<?php
      						$reqmail = $BDD->prepare("SELECT * FROM compte INNER JOIN personne ON compte.Id_Personne = personne.Id_Personne WHERE personne.Id_Personne = ?");
      						$reqmail->execute(array($personne['Id_Personne']));
      						$mail = $reqmail->fetch();

      						echo " ".$personne['nom']." ".$personne['prenom']."</br> Numéro de tel : ".$personne['num_tel']."</br> Email : ".$mail['email'];
      						?>
      					</br>
      				<?php 
      				}
      				?>
      			</td>
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