   <?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=bddphp', 'root', '');
 
if(isset($_SESSION['id'])) 
{
   $idappartement = $_GET['idappartement'];

   if(isset($_POST['piece']) AND !empty($_POST['piece'])) 
   {
      $piece = htmlspecialchars($_POST['piece']);
      $insertpiece = $bdd->prepare("UPDATE appartement SET piece = ? WHERE Id_Appartement  = ? AND Id_Personne = ?");
      $insertpiece->execute(array($piece,$idappartement, $_SESSION['id']));
      header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
   }

   if(isset($_POST['degre_secu']) AND !empty($_POST['degre_secu'])) 
   {
      $degre_secu = htmlspecialchars($_POST['degre_secu']);
      $insertdegre_secu = $bdd->prepare("UPDATE appartement SET degre_de_secu = ? WHERE Id_Appartement  = ? AND Id_Personne = ?");
      $insertdegre_secu->execute(array($degre_secu,$idappartement, $_SESSION['id']));
      header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
   }
   
   if(isset($_POST['datefin']) AND !empty($_POST['datefin'])) 
   {
      $datefin = new DateTime($_POST['datefin']);
      $datefin = $datefin->format('Y-m-d');
      $insertdatefin = $bdd->prepare("UPDATE appartement SET date_fin = ? WHERE Id_Appartement  = ? AND Id_Personne = ?");
      $insertdatefin->execute(array($datefin,$idappartement, $_SESSION['id']));
      header('Location: Page_utilisateur.php?id='.$_SESSION['id']);
   }
}

?>
<html>
   <head>
      <title>Edition appartement </title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      <header>
         <ul>
            <li><a href="editionprofil.php">Editer mon profil</a></li>
            <li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page utilisateur</a></li>
            <li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
            <li><a href="page_anonyme.php">Graphiques</a></li>
            <li><a href="deconnexion.php">Se déconnecter</a></li>
         </ul>
      </header>
      <div align="center">
         <h2>Edition de mon appartement</h2>
         <div align="left">
            <form method="POST" action="" enctype="multipart/form-data">
               <table>
                  <tr>
                     <td align="right">
                        <label for="formulaire">Changer le nombre de pieces :</label>
                     </td>
                     <td>
                        <input type="number" placeholder="pieces" id="piece"name="piece" value="<?php if(isset($piece)) { echo $piece; }?>"  />
                     </td>
                  </tr>
                  <tr>
                     <td align="right">
                        <label for="Degré de sécurité">
                        Changer le degré de sécurité :</label>
                     </td>
                     <td>
                        <input type="number" min="0" max="10" placeholder="(0-10)" id="degre_secu" name="degre_secu" value="<?php if(isset($degre_secu)) { echo $degre_secu; }?>" />
                     </td>
                  </tr>
                  <tr>
                     <td align="right">
                        <label for="formulaire">Date de fin de location :</label>
                     </td>
                     <td>
                        <input type="date" id="datefin"name="datefin" />
                     </td>
                  </tr>
               </table>  
               <input type="submit" class="submit" value="Mettre à jour mon appartement !" />
            </form>
            
            <?php if(isset($msg)) { echo $msg; } ?>
         </div>
      </div>
   </body>
</html>
<?php
/*   
else {
   header("Location: connexion.php");
}
*/
?>