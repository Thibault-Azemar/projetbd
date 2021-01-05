
 

<!doctype html>
<html lang="fr">
<head>
        <meta charset="utf-8">
       
    </head>
    <body>
 <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <input type="submit" id="Demarrer" name="Demarrer" value="Demarrer">
<form>   
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <input type="submit" id="Arreter" name="Arreter" value="Arreter">
<form>   


<?php
if(!empty($_POST['Demarrer'])) {
    $date_depart = new DateTime();
    echo "Date de Démarrage : \n".$date_depart->format('Y-m-d H:i:s')."\n";

    $insertintodureeconso = $BDD->prepare("INSERT INTO duree_de_conso(Id_Appareil, date_debut, date_fin) VAlUES (?, ?, ?)");
    $insertintodureeconso->execute(array($reqappareil['Id_Appareil'], $date_depart));
	}
?>



<?php
if(!empty($_POST['Arreter'])) {
    $date_fin = new DateTime();
    echo "Date d'arrêt : \n".$date_fin->format('Y-m-d H:i:s')."\n";;
    $insertintodureeconso=$BDD->prepare("SELECT * FROM duree_de_conso LEFT JOIN appareil ON appareil.Id_Appareil=duree_de_conso.Id_Appareil WHERE duree_de_conso.date_fin=?");
    $insertintodureeconso->execute(array($date_fin));
}
?>

       
    </body>

</html>

        
        
            