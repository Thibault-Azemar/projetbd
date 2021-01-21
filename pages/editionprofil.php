   <?php
session_start();
 
$BDD = new PDO('mysql:host=127.0.0.1;dbname=bddphp', 'root', '');
 
if(isset($_SESSION['id'])) {
   $reqcompte = $BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?");
   $reqcompte->execute(array($_SESSION['id']));
   $compteinfo = $reqcompte->fetch();
   $reqpersonne = $BDD->prepare('SELECT * FROM personne WHERE Id_Personne = ?');
   $reqpersonne->execute(array($_SESSION['id']));
   $personneinfo = $reqpersonne->fetch();
   if(isset($_POST['NNom']) AND !empty($_POST['NNom']) AND $_POST['NNom'] != $personneinfo['nom']) {
      $NNOM = htmlspecialchars($_POST['NNom']);
      $insertNNOM = $BDD->prepare("UPDATE personne SET Nom = ? WHERE Id_Personne  = ?");
      $insertNNOM->execute(array($NNOM, $_SESSION['id']));
      header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['NPrenom']) AND !empty($_POST['NPrenom']) AND $_POST['NPrenom'] != $personneinfo['prenom']) {
      $NPRENOM = htmlspecialchars($_POST['NPrenom']);
      $insertNPRENOM = $BDD->prepare("UPDATE personne SET prenom = ? WHERE Id_Personne  = ?");
      $insertNPRENOM->execute(array($NPRENOM, $_SESSION['id']));
      header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
   }
  if(isset($_POST['NMail']) AND !empty($_POST['NMail']) AND $_POST['NMail'] != $compteinfo['email']) {
      $NMAIL = htmlspecialchars($_POST['NMail']);
      $insertNMAIL = $BDD->prepare("UPDATE compte SET email = ? WHERE Id_Compte = ?");
      $insertNMAIL->execute(array($NMAIL, $_SESSION['id']));
      header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['NMdp1']) AND !empty($_POST['NMdp1']) AND isset($_POST['NMdp2']) AND !empty($_POST['NMdp2'])) {
      $NMDP1 = sha1($_POST['NMdp1']);
      $NMDP2 = sha1($_POST['NMdp2']);
      if($NMDP1 == $NMDP2) {
         $insertMDP = $BDD->prepare("UPDATE compte SET motdepasse = ? WHERE Id_Compte = ?");
         $insertMDP->execute(array($NMDP1, $_SESSION['id']));
         header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }
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
				if(isset($_SESSION['id'])) {
				?>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<?php
				}
				?>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page utilisateur</a></li>
            <li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="page_anonyme.php">Graphiques</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
      <div align="center">
         <h2>Edition de mon profil</h2>
         <div align="left">
            <form method="POST" action="" enctype="multipart/form-data">
               <label>Nom :</label>
               <input type="text" name="NNom" placeholder="Nouveau nom" value="<?php echo $personneinfo['nom']?>" />
               <br /><br />
               <label>Prénom :</label>
               <input type="text" name="NPrenom" placeholder="Nouveau Prénom" value="<?php echo $personneinfo['prenom']?>" />
               <br /><br />
               <label>Mail :</label>
               <input type="text" name="NMail" placeholder="Nouveau Mail" value="<?php echo $compteinfo['email']?>" />
               <br /><br />
               <label>Mot de passe :</label>
               <input type="password" name="NMdp1" placeholder=" Nouveau mot de passe"/><br /><br />
               <label>Confirmation - mot de passe :</label>
               <input type="password" name="NMdp2" placeholder="Confirmation du mot de passe" /><br /><br />
               <input type="submit" value="Mettre à jour mon profil !" />
            </form>
            
            <a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page utilisateur</a>
            <?php if(isset($msg)) { echo $msg; } ?>
         </div>
      </div>
   </body>
</html>
<?php   
}
else {
   header("Location: connexion.php");
}
?>