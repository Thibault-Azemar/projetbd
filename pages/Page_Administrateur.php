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

      $reqadmin = $BDD->prepare("SELECT * FROM compte WHERE Id_Compte = ?");
   		$reqadmin->execute(array($_SESSION['id']));
   		$infoadmin = $reqadmin->fetch();

        if($infoadmin['etat'] == '1')
      {
        /*echo "Vous n'êtes pas administrateur vous ne pouvez pas avoir accès à cette page.";*/
        header('location: admin.php');
        exit;
      }
        else
      {
        header('location: nonadmin.php');
        exit;
      }
    }
?>
    