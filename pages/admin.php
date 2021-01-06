<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
?>
<html>
    <head>
       <title>Projet BDD</title>
       <meta charset="utf-8">
    </head>
    <body>
    	Bonjour Cher(e) Administrateur. <br/>
      <?php
      $requtil =$BDD->prepare("SELECT DISTINCT * FROM compte RIGHT JOIN personne ON compte.Id_Personne = personne.Id_Personne")
      ?>

    </body>
</html>