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

				
				<?php
				if(isset($_SESSION['id']) AND $compteinfo['Id_Compte'] == $_SESSION['id']) 
        {
				?>

          <li><a href="editionprofil.php">Editer mon profil</a></li>
				  <li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
          <li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
          <li><a href="deconnexion.php">Se déconnecter</a></li>		
		  <li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page utilisateur</a></li>

        <?php
				}
				?>
				
				
			</ul>

		</header>
	</body>
</html>
<?php   
}
?>