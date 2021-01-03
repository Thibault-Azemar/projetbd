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
      <div align="center">
         <h2>Profil de <?php echo $personneinfo['nom']." ".$personneinfo['prenom']; ?></h2>
         <br /><br />
         Mail = <?php echo $compteinfo['email']; ?>
         <br />
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