<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 

	$getid = $_SESSION['id'];
  if(isset($_SESSION['id']) AND   $getid > 0)
  {
    $reqcompte = $BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?");
    $reqcompte->execute(array($getid));
    $compteinfo = $reqcompte->fetch();
    $reqpersonne = $BDD->prepare('SELECT * FROM personne WHERE Id_Personne = ?');
    $reqpersonne->execute(array($getid));
    $personneinfo = $reqpersonne->fetch();

	$reqmaison = $BDD->prepare("SELECT * FROM maison WHERE maison.Id_Personne  = ? ");
   	$reqmaison->execute(array($getid));



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
				<?php
				if(isset($_SESSION['id'])) {
				?>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<?php
				}
				?>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
				<li><a href="tableau_de_bord.php?id=<?php echo $_SESSION['id'];?>">Tableau de Bord</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
    <div align="center">
    	<h2>Bonjour <?php echo $personneinfo['prenom']?> </h2>
      <a class="link" href="page_creation_maison.php">Ajouter une maison</a>
          </br>
          </br>

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
  </div>
		</br>	
		
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


<!-- administrateur : 
			- supprimer les personnes
			- rendre compte administrateur
-->
<?php
  }
?>

</html>