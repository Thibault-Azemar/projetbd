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
	  <link rel="stylesheet" href="style.css">
   </head>
   <body>
		<header>
			<ul>
				<li><a href="editionprofil.php">Editer mon profil</a></li>
				<?php
				if(isset($_SESSION['id']) AND $compteinfo['Id_Compte'] == $_SESSION['id']) {
				?>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<?php
				}
				?>
				<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="page_anonyme.php">Graphiques</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
      <div align="center">
         <h2>Profil de <?php echo $personneinfo['nom']." ".$personneinfo['prenom']." | "."Mail : ".$compteinfo['email']?>; <br/> Identifiant : <?php echo $compteinfo['Id_Compte'];?>    <?php if ($compteinfo['etat'] == 1) { echo "Administrateur"; } ?>  </h2>

         <a href="page_creation_maison.php"><font color="#0000FF">Ajouter une maison</a>
         </br>
         	<a href="page_creation_appart">Ajouter un appartement</a>
         	 </br>
         	</font>

         <br /><br />
         <TABLE border=6 cellspacing=12 cellpadding=20><!--<tr>-->
         	<?php 
          $reqmaison=$BDD->prepare("SELECT * FROM maison WHERE Id_Personne=?"); 
          $reqmaison->execute(array($getid)); 
          $infomaison=$reqmaison->fetch();
          ?>
          <?php
         	/**while($infomaison=$reqmaison->fetch())
          {
        	   $reqville=$BDD->prepare("SELECT ville.Nom FROM ville RIGHT JOIN maison ON ville.Id_Ville=maison.Id_Ville WHERE maison.Id_Ville= ? "); 

        	   $reqville->execute(array($infomaison['Id_Ville'])); 
        	   $infoville=$reqville->fetch(); 
        	
        	   if($infomaison['Id_Maison']!='1')
        	   {
        	     ?> <tr><td> <?php
        	   } 
        	   echo "Maison n°".$infomaison['Id_Maison']." ".$infomaison['Num_rue']." ".$infomaison['Rue']." ".$infoville['Nom']; 
        	
         	
            */

			       $reqappart = $BDD->prepare("SELECT * FROM appartement WHERE appartement.Id_Personne  = ? /*AND appartement.Id_Maison= ?*/ ");
   			      $reqappart->execute(array($getid/*,$infomaison['Id_Maison']*/)); 
   			

   	          {
   					  while ($num_appart = $reqappart->fetch())
   		         {   
   					      ?>
                  <tr>
                   <td><?php echo "Appartement n°".$num_appart['Id_Appartement']."</br>"; 
                  $_SESSION['idappartement']= $num_appart['Id_Appartement']; 
                  $reqville=$BDD->prepare("SELECT ville.Nom FROM ville RIGHT JOIN maison ON ville.Id_Ville=maison.Id_Ville WHERE maison.Id_Ville= ? "); 

                  $reqville->execute(array($infomaison['Id_Ville'])); 
                  $infoville=$reqville->fetch();	
                   echo $infomaison['Num_rue']." ".$infomaison['Rue']." ".$infoville['Nom'];
                   ?>  
                   <br/>
                   <a href="page_creation_piece.php?idappartement=<?php echo $_SESSION['idappartement'];?>">Ajouter une piece</a> <?php
   						     $reqpiece=$BDD->prepare("SELECT * FROM piece WHERE Id_Appartement = ?");
						        $reqpiece->execute(array($num_appart['Id_Appartement']));   
   						     ?>
                  <br/>
                  <br/>
                  <a href="editionappartement.php?idappartement=<?php echo $_SESSION['idappartement'];?>">Modifier appartement</a></li>
   					      </td>
   						   <?php
   						 
   				         while($pieceinfo=$reqpiece->fetch())
   			          {
   				           $reqtype_piece=$BDD->prepare("SELECT nom_type from type_piece LEFT JOIN piece ON type_piece.Id_Type_piece = piece.Id_Type_piece WHERE Id_Appartement = ? AND piece.Id_Piece= ? "); 
   				           $reqtype_piece->execute(array($num_appart['Id_Appartement'],$pieceinfo["Id_Piece"])); 
   				           $type_piece_info=$reqtype_piece->fetch(); 
   				           ?><td><?php echo $pieceinfo['libelle']." "."(".$type_piece_info['nom_type'].")"."</br>"; 
                      $_SESSION['idpiece']= $pieceinfo['Id_Piece'];
                      ?>  <a href="page_creation_appareil.php?idpiece=<?php echo $_SESSION['idpiece'];?>">Ajouter un appareil</a> 




                     <br/>
                      <br/>
                    <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_SESSION['id']."&"."idpiece=".$pieceinfo['Id_Piece'];?>" method="post">

                     <input type="submit" class="submit" id="SupprimerA" name="SupprimerA" value="Supprimer">

                      </form>   
                  

                    <?php 

                    
                      if (!empty($_POST['SupprimerA']))
                      {
                        $reqapp=$BDD->prepare("SELECT * FROM appartient_piece WHERE Id_Piece = ?");
                        $reqapp->execute(array($pieceinfo['Id_Piece']));
                        $appexist=$reqapp->rowCount();

                        if($appexist==0)
                        {
                          $reqsupp = $BDD->prepare("DELETE FROM piece WHERE Id_Piece = ?");
                          $reqsupp->execute(array($pieceinfo['Id_Piece']));

                          $reqsupp2=$BDD->prepare("DELETE FROM appartient_piece WHERE Id_Piece = ?");
                          $reqsupp2->execute(array($pieceinfo['Id_Piece']));
                        }
                        else
                        {
                          $erreur="la piece n'est pas vide";
                          echo $erreur;
                        }


                      }
                   
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
   					            ?><td><?php echo $appareilinfo['libelle'];
   					            $reqvideo=$BDD->prepare("SELECT * FROM video WHERE Id_Appareil=? "); 
   					            $reqvideo->execute(array($appareilinfo['Id_Appareil'])); 
   					            $infovideo=$reqvideo->fetch(); 
   					 
                        ?>
                       <div>
            		
                        <form action="<?php echo "Page_utilisateur.php?id=".$_SESSION['id']."&"."idappareil=".$appareilinfo['Id_Appareil'];?>" method="post">
                         <input type="submit" class="submit" id="Demarrer<?php echo $appareilinfo['Id_Appareil'];?>" name="Demarrer" value="Demarrer">
                         </form>   
                         <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_SESSION['id']."&"."idappareil=".$appareilinfo['Id_Appareil'];?>" method="post">
                         <input type="submit" class="submit" id="Arreter" name="Arreter" value="Arreter">
                        </form>   
                        </div>

                        <?php 
                        $NouveauD="Demarrer".$appareilinfo['Id_Appareil'];
                        if(!empty($_POST['Demarrer'])) 
                        {
                          if($_GET['idappareil']==$appareilinfo['Id_Appareil'])
                          {
                            $date_depart = new DateTime();
                            $date_depart = $date_depart->format('Y-m-d H:i:s');
                            echo "Date de Démarrage : ".$date_depart;

                            $insertintodureeconso = $BDD->prepare("INSERT INTO duree_de_conso(Id_Appareil, date_debut, date_fin) VALUES (?, ?, ?)");
                            $insertintodureeconso->execute(array($appareilinfo['Id_Appareil'], $date_depart, $date_depart));
                          }
                        }
                        ?>



                        <?php
                        if(!empty($_POST['Arreter'])) 
                        {
                          if($_GET['idappareil']==$appareilinfo['Id_Appareil'])
                          {
                            $date_fin = new DateTime();
                            $date_fin = $date_fin->format('Y-m-d H:i:s');
                            echo "Date d'arrêt : ".$date_fin;
                            $insertintodureeconso=$BDD->prepare("UPDATE duree_de_conso SET date_fin=? WHERE Id_Appareil=? AND date_debut = date_fin");
                            $insertintodureeconso->execute(array($date_fin, $appareilinfo['Id_Appareil']));
                          }
                        }
                        ?>

                        <form action="<?php echo "Page_utilisateur.php?id=".$_SESSION['id']."&"."idappareil=".$appareilinfo['Id_Appareil'];?>" method="post">
                        <input type="submit" class="submit" id="Supprimer" name="Supprimer" value="Supprimer">

                         </form>   

                        <?php 

                    
                        if (!empty($_POST['Supprimer']))
                        {
                        
                          

                          $reqsupp2=$BDD->prepare("DELETE FROM emet WHERE Id_Appareil = ?");
                          $reqsupp2->execute(array($appareilinfo['Id_Appareil']));

                          $reqsupp3=$BDD->prepare("DELETE FROM consomme WHERE Id_Appareil = ?");
                          $reqsupp3->execute(array($appareilinfo['Id_Appareil']));

                          $reqsupp4=$BDD->prepare("DELETE FROM appartient_piece WHERE Id_Appareil = ?");
                          $reqsupp4->execute(array($appareilinfo['Id_Appareil']));

                          $reqsupp = $BDD->prepare("DELETE FROM appareil WHERE Id_Appareil = ?");
                          $reqsupp->execute(array($appareilinfo['Id_Appareil']));
                          
                          header("Location: Page_utilisateur.php?id=".$_SESSION['id']);

                          
                      }


                      ?>


                 

   				             </br>
   					          <a href="<?php echo $infovideo['Lien']; ?>"target="_blank">video</a> <?php
   					
   					          ?><td> <?php 
					             echo "Conso :  "."</br>"; 
   					          while($infoconso=$reqconso->fetch())
                      { 
   					            $reqressources=$BDD->prepare("SELECT * FROM ressources WHERE Id_Ressources= ?"); 
   					            $reqressources->execute(array($infoconso['Id_Ressources'])); 
   							        $ressourcesinfo=$reqressources->fetch(); 
   							
   							        echo $ressourcesinfo['libele']." : ".$infoconso["Consommation_par_h"]." ".$ressourcesinfo['description']."</br>";
   							   
   				             } 
                       echo "------"."</br>";
   					          echo "Emission : "."</br>"; 
   					          while($infoemission=$reqemission->fetch())
                      {
   						           $reqsubstances=$BDD->prepare("SELECT * FROM substances WHERE Id_Substances= ? "); 
   						           $reqsubstances->execute(array($infoemission['Id_Substances'])); 
   						           $infosubstances=$reqsubstances->fetch(); 
   						
   						           echo $infosubstances['libele']." : ".$infoemission['Emmission_par_h']." ".$infosubstances['description']; 
   					          }
   				       }?><!--</tr>--><!--<td></td>--> <?php 
			           ?> <!--<td>--> <?php } ?> <?php
   		           ?> <!--</td></tr><td>-->	<?php }
   	        /**}*/
 ?> </tr> <?php }
   			?>
   		</td></td></TABLE>
         <br />

       </div>
   </body>
</html>
<?php   
}
?>