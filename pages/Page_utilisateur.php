<?php
session_start();  
		
		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
				if(isset($_GET['id']) AND $_GET['id'] > 0) 
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
      <div>
         <h2>Profil de <?php echo $personneinfo['nom']." ".$personneinfo['prenom']." | "."Mail : ".$compteinfo['email']?>; </h2>
         <br /><br />
         <?php 
			$reqappart = $BDD->prepare("SELECT * FROM appartement WHERE Id_Personne  = ?");
   			$reqappart->execute(array($getid)); 
   			

   	{
   					while ($num_appart = $reqappart->fetch())
   		{   
   					?> <TABLE border=6 cellspacing=12 cellpadding=20><tr><td><?php echo "Appartement n°".$num_appart['Id_Appartement']; 	
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
   				?><td><?php echo $pieceinfo['libelle']." "."(".$type_piece_info['nom_type'].")"; 
   				?></td><?php
   						 
   				$reqappareil=$BDD->prepare("SELECT * FROM appareil LEFT JOIN appartient_piece ON appareil.Id_Appareil=appartient_piece.Id_Appareil WHERE appartient_piece.Id_Piece=?"); 
   				$reqappareil->execute(array($pieceinfo['Id_Piece'])); 
   				while ($appareilinfo=$reqappareil->fetch())
   				{
   					$reqconso=$BDD->prepare("SELECT * FROM consomme WHERE Id_appareil= ?"); 
   							$reqconso->execute(array($appareilinfo['Id_Appareil'])); 
   					?><td><?php echo $appareilinfo['description'];?><td> <?php 

   					while($infoconso=$reqconso->fetch()){ 
   					$reqressources=$BDD->prepare("SELECT * FROM ressources WHERE Id_Ressources= ?"); 
   					$reqressources->execute(array($infoconso['Id_Ressources'])); 
   							$ressourcesinfo=$reqressources->fetch(); 
   							echo $infoconso["Consommation_par_h"]." ".$ressourcesinfo['libele']."</br>";  
   				} 	
   				}?><tr><td></td> <?php 
			}
   		}
   	}
   			?>
   		</tr></TABLE>
         <?php
         if(isset($_SESSION['id']) AND $compteinfo['Id_Compte'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="editionprofil.php">Editer mon profil</a>
         <a href="deconnexion.php">Se déconnecter</a>
         <?php
         }
         ?>
       </div>
   </body>
</html>
<?php   
}
?>