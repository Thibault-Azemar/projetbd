<?php
session_start();  

		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
				if(isset($_GET['id']) AND $_GET['id'] > 0) 
				{
   $getid = intval($_GET['id']);
   $requser = $BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?");
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
   $requser2 = $BDD->prepare('SELECT * FROM personne WHERE Id_Personne = ?');
   $requser2->execute(array($getid));
   $userinfo2 = $requser2->fetch();
?>
<html>
   <head>
      <title>Projet BDD</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">
         <h2>Profil de <?php echo $userinfo2['nom']." ".$userinfo2['prenom']; ?></h2>
         <br /><br />
         Mail = <?php echo $userinfo['email']; ?>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['Id_Compte'] == $_SESSION['id']) {
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