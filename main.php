<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Salut</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
 <?php 
		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		$requette=$BDD->query("SELECT * FROM personne "); 
		$resultat =$requette->fetch(); 
		echo $resultat['Id_Personne']; 
 ?>
</body>
</html>