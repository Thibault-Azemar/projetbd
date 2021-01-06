<?php
session_start();  
		
		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
				if(isset($_GET['id']) AND 	$_GET['id'] > 0) 
				{
   $getid = intval($_GET['id']);
   $reqcompte = $BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?");
   $reqcompte->execute(array($getid));
   $compteinfo = $reqcompte->fetch();
   $reqpersonne = $BDD->prepare('SELECT * FROM personne WHERE Id_Personne = ?');
   $reqpersonne->execute(array($getid));
   $personneinfo = $reqpersonne->fetch();

?>
<html>
   <head>
      <title>Projet BDD</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">
         <h2>Profil de <?php echo $personneinfo['nom']." ".$personneinfo['prenom']." | "."Mail : ".$compteinfo['email']?>; </h2>

         <a href="page_creation_maison.php"><font color="#0000FF">Ajouter une maison</a>
         </br>
         	<a href="page_creation_appart">Ajouter un appartement</a>
         	 </br>
         		<a href="page_creation_appareil">Ajouter un appareil</a>
         	</font>

         <br /><br />
         <?php 
         	$reqmaison=$BDD->prepare("SELECT * FROM maison WHERE Id_Personne=?"); 
         	$reqmaison->execute(array($getid)); 

         	?><TABLE border=6 cellspacing=12 cellpadding=20><tr><td>
         	<?php
         	while($infomaison=$reqmaison->fetch())
        {
        	$reqville=$BDD->prepare("SELECT ville.Nom FROM ville RIGHT JOIN maison ON ville.Id_Ville=maison.Id_Ville WHERE maison.Id_Ville= ? "); 

        	$reqville->execute(array($infomaison['Id_Ville'])); 
        	$infoville=$reqville->fetch(); 
        	
        	if($infomaison['Id_Maison']!='1')
        	{
        	?> <tr><td> <?php
        	} 
        	echo "Maison n°".$infomaison['Id_Maison']." ".$infomaison['Num_rue']." ".$infomaison['Rue']." ".$infoville['Nom']; 
        	
         	


			$reqappart = $BDD->prepare("SELECT * FROM appartement WHERE appartement.Id_Personne  = ? AND appartement.Id_Maison= ? ");
   			$reqappart->execute(array($getid,$infomaison['Id_Maison'])); 
   			

   	{
   					while ($num_appart = $reqappart->fetch())
   		{   
   					?> <td><?php echo "Appartement n°".$num_appart['Id_Appartement']; 
                  $_SESSION['idappartement']= $num_appart['Id_Appartement']; 	
                   ?>  <a href="page_creation_piece.php?idappartement=<?php echo $_SESSION['idappartement'];?>">Ajouter une piece</a> <?php
   						$reqpiece=$BDD->prepare("SELECT * FROM piece WHERE Id_Appartement = ?");
						$reqpiece->execute(array($num_appart['Id_Appartement']));   
   						?>
   					</td>
   						<?php
   						 
   				while($pieceinfo=$reqpiece->fetch())
   			{
   				$reqtype_piece=$BDD->prepare("SELECT nom_type from type_piece LEFT JOIN piece ON type_piece.Id_Type_piece = piece.Id_Type_piece WHERE Id_Appartement = ? AND piece.Id_Piece= ? "); 
   				$reqtype_piece->execute(array($num_appart['Id_Appartement'],$pieceinfo["Id_Piece"])); 
   				$type_piece_info=$reqtype_piece->fetch(); 
   				?><td><?php echo $pieceinfo['libelle']." "."(".$type_piece_info['nom_type'].")"."</br>"; 
                  
   	  			  ?>
               

                 </td><?php
   						 
   				$reqappareil=$BDD->prepare("SELECT * FROM appareil LEFT JOIN appartient_piece ON appareil.Id_Appareil=appartient_piece.Id_Appareil WHERE appartient_piece.Id_Piece=?"); 
   				$reqappareil->execute(array($pieceinfo['Id_Piece'])); 
   				while ($appareilinfo=$reqappareil->fetch())
   				{
   					$reqconso=$BDD->prepare("SELECT * FROM consomme WHERE Id_appareil= ?"); 
   							$reqconso->execute(array($appareilinfo['Id_Appareil'])); 
   					$reqemission=$BDD->prepare("SELECT * FROM emet WHERE Id_Appareil=? "); 
   					$reqemission->execute(array($appareilinfo['Id_Appareil'])); 
   					?><td><?php echo $appareilinfo['description'];
   					$reqvideo=$BDD->prepare("SELECT * FROM video WHERE Id_Appareil=? "); 
   					$reqvideo->execute(array($appareilinfo['Id_Appareil'])); 
   					$infovideo=$reqvideo->fetch(); 
   					?>
            		
            <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_SESSION['id'];?>" method="post">
                  <input type="submit" id="Demarrer<?php echo $appareilinfo['Id_Appareil'];?>" name="Demarrer" value="Demarrer">
                  <form>   
                  <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_SESSION['id'];?>" method="post">
                  <input type="submit" id="Arreter" name="Arreter" value="Arreter">
                  <form>   


                  <?php 
                  $NouveauD="Demarrer".$appareilinfo['Id_Appareil'];
                     if(!empty($_POST['Demarrer'])) {
                        $date_depart = new DateTime();
                        $date_depart = $date_depart->format('Y-m-d H:i:s');
                        echo "Date de Démarrage : ".$date_depart;

                        $insertintodureeconso = $BDD->prepare("INSERT INTO duree_de_conso(Id_Appareil, date_debut, date_fin) VALUES (?, ?, ?)");
                        $insertintodureeconso->execute(array($appareilinfo['Id_Appareil'], $date_depart, $date_depart));
                     }
                  ?>



                  <?php
                     if(!empty($_POST['Arreter'])) {
                        $date_fin = new DateTime();
                        $date_fin = $date_fin->format('Y-m-d H:i:s');
                        echo "Date d'arrêt : ".$date_fin;
                        $insertintodureeconso=$BDD->prepare("UPDATE duree_de_conso SET date_fin=? WHERE Id_Appareil=? AND date_debut = date_fin");
                        $insertintodureeconso->execute(array($date_fin, $appareilinfo['Id_Appareil']));
                     }
                  ?>

   				    </br>
   					<a href="<?php echo $infovideo['Lien']; ?>"> video</a> <?php
   					
   					?><td> <?php 
					echo "Conso :  "."</br>"; 
   					while($infoconso=$reqconso->fetch()){ 
   					$reqressources=$BDD->prepare("SELECT * FROM ressources WHERE Id_Ressources= ?"); 
   					$reqressources->execute(array($infoconso['Id_Ressources'])); 
   							$ressourcesinfo=$reqressources->fetch(); 
   							
   							echo $infoconso["Consommation_par_h"]." ".$ressourcesinfo['libele']."</br>";
   							   
   				} 	echo "------"."</br>";
   					echo "Emission : "."</br>"; 
   					while($infoemission=$reqemission->fetch()){
   						$reqsubstances=$BDD->prepare("SELECT * FROM substances WHERE Id_Substances= ? "); 
   						$reqsubstances->execute(array($infoemission['Id_Substances'])); 
   						$infosubstances=$reqsubstances->fetch(); 
   						
   						echo $infoemission['Emmission_par_h']." ".$infosubstances['libele']; 
   					}
   				}?><tr><td></td> <?php 
			?> <td> <?php } ?> <?php
   		?> </td></tr><td>	<?php }
   	}
 ?> </tr> <?php }
   			?>
   		</td></td></TABLE>
         <?php
         if(isset($_SESSION['id']) AND $compteinfo['Id_Compte'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="editionprofil.php">Editer mon profil</a>
         <a href="deconnexion.php">Se déconnecter</a>
         <a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a>

         <?php
         }
         ?>
       </div>
   </body>
</html>
<?php   
}
?>