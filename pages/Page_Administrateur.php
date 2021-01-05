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
<!doctype html>
<html lang="fr">

	<head>
  		<meta charset="utf-8">
  		<title>Projet BDD </title>
  		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		
		<?php
		
		$reqadmin = $bdd->prepare("SELECT etat FROM compte WHERE Id_Compte= ?");
   		$reqadmin->execute(array($_SESSION['id']));
   		$infoadmin = $reqadmin->fetch();
   		if($infoadmin == '0')
   		{
   			echo "Vous n'êtes pas administrateur vous ne pouvez pas avoir accès à cette page.";
   		
   		?>
   		
   		<a href="../Page_utilisateur.php">page utilisateur</a>




	</body>
</html>
<?php
}
}
?>