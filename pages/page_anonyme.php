<?php
session_start();  
		
		$BDD=new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		


		$reqhomme = $BDD->query('SELECT COUNT(*) AS nbhomme FROM personne WHERE genre="Homme"');
		$reqfemme=$BDD->query('SELECT COUNT(*) AS nbfemme FROM personne WHERE genre="Femme"');
		$reqautre=$BDD->query('SELECT COUNT(*) AS nbautre FROM personne WHERE genre="Autre"');
		$reqNP=$BDD->query('SELECT COUNT(*) AS nbnp FROM personne WHERE genre="Non Precise"');
		$infohomme = $reqhomme->fetch();
		$infofemme = $reqfemme->fetch();
		$infoautre = $reqautre->fetch();
		$infoNP = $reqNP->fetch();

		$count1=0;
		$count2=0; 
		$count3=0; 
		$count4=0; 
		$reqage=$BDD->query('SELECT * FROM personne'); 
		while($infoage=$reqage->fetch()){
			$dateNaissance = $infoage['date_naissance'];
  			$aujourdhui = date("Y-m-d");
  			$diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
  			if($diff->format('%y')<'25'){
  				$count1=$count1+1; 
  			}
  			if($diff->format('%y')>'24' && $diff->format('%y')<'46'){
  				$count2=$count2+1; 
  			}
  			if($diff->format('%y')>'45' && $diff->format('%y')<'66'){
  				$count3=$count3+1; 
  			}
  			if($diff->format('%y')>'64'){
  				$count4=$count4+1; 
  			}
		}

		?>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>BDD Projet</title>
  <link rel="stylesheet" href="style.css">
  <script src="package/dist/Chart.bundle.js"></script>

</head>
<body>
	<header>
			<ul>
				
				<?php
				if(isset($_SESSION['id'])) {
				?>
        <li><a href="editionprofil.php">Editer mon profil</a></li>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
        <li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
		<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
        <li><a href="deconnexion.php">Se déconnecter</a></li>
				<?php
				}
        else
        {
        ?>

        <li><a href="../main.php">Se connecter</a></li>

        <?php
        }
				?>
				
				
			</ul>
		</header>
<div align="center">
  <h1> Histogramme des genres des personnes inscrites sur le site : </h1>
	<div id="container" style="width: 50%">
	<canvas id="nbgenre"> </canvas>
</div>

<script>
var ctx = document.getElementById('nbgenre').getContext('2d');

var nbgenre = new Chart(ctx, {
    type: 'bar',
    data: {
       labels: ['Homme', 'Femme','Autre','Non Précisé'],
        datasets: [{
        	label : ['Nombre'],
            data: [<?php echo $infohomme['nbhomme'] ?>, <?php echo $infofemme['nbfemme'] ?>, <?php echo $infoautre['nbautre'] ?>, <?php echo $infoNP['nbnp'] ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',

                
            ],
            borderWidth: 1
        }],
         
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

</canvas>
<h1>Histogramme du nombre d’abonnés pour chaque tranche d'age</h1>

<div id="container" style="width: 50%;">

<canvas id="nbpersonne"> </canvas>
</div>
<script>
var ctx = document.getElementById('nbpersonne').getContext('2d');
var nbpersonne = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
       labels: ['18-24', '24-45','45-65','+65'],
        datasets: [{
        	label : ['Nombre'],
            data: [<?php echo $count1 ?>, <?php echo $count2 ?>, <?php echo $count3 ?>, <?php echo $count4 ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',

                
            ],
            borderWidth: 1
        }],
         
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<h1>La maison la plus gourmande pour chaque ressource pour un mois donné</h1>
<?php 
  $reqressource=$BDD->query('SELECT * FROM ressources'); 
    while($inforessources=$reqressource->fetch()){
      if($inforessources['libele'] != 'Null'){
      $conso_totale_elevee=0; 
    $reqmaison=$BDD->query('SELECT * FROM maison'); 
    while($infomaison=$reqmaison->fetch()){

      $reqvue_appart=$BDD->prepare('CREATE VIEW vue_appartement AS SELECT Id_Appartement FROM appartement WHERE Id_Maison=?'); 
      $reqvue_appart->execute(array($infomaison['Id_Maison'])); 
      $reqvue_piece=$BDD->query('CREATE VIEW  vue_piece AS SELECT Id_Piece FROM piece WHERE Id_Appartement IN (SELECT * FROM vue_appartement)'); 
      $reqvue_piece=$BDD->query('CREATE VIEW vue_appareil AS SELECT Id_Appareil FROM appartient_piece WHERE Id_Piece IN (SELECT * FROM vue_piece)');

      $reqselec_appareil=$BDD->prepare('SELECT DISTINCT * FROM duree_de_conso d LEFT JOIN consomme c ON (d.Id_Appareil=c.Id_Appareil) WHERE d.date_fin LIKE "2021-01%" AND c.Id_Ressources=?  AND d.Id_Appareil IN (SELECT * FROM vue_appareil)'); 
      $reqselec_appareil->execute(array($inforessources['Id_Ressources'])); 
      $conso_tot_maison=0; 
      while ($infoselect_appareil=$reqselec_appareil->fetch()){
          $reqconsomme=$BDD->prepare('SELECT * FROM consomme WHERE Id_Appareil=?'); 
          $reqconsomme->execute(array($infoselect_appareil['Id_Appareil'])); 
          $infoconsomme=$reqconsomme->fetch(); 
          $duree=date_diff(date_create($infoselect_appareil['date_fin']),date_create($infoselect_appareil['date_debut'])); 
          $duree=$duree->format('%s'); 
          $conso_tot_maison=$conso_tot_maison+$duree*$infoconsomme['Consommation_par_h'];  
          if($conso_tot_maison > $conso_totale_elevee){
            $conso_totale_elevee=$conso_tot_maison;
            $maison_gourmande=$infomaison['Id_Maison']; 
          
      }
          

          $reqsuppvuepiece=$BDD->query('DROP VIEW vue_piece'); 
          $reqsuppvueappart=$BDD->query('DROP VIEW vue_appartement'); 
          $reqsuppvueappareil=$BDD->query('DROP VIEW vue_appareil'); 
    }
     
           
          }
           echo 'La maison la plus gourmande pour la ressource '.$inforessources['libele'].' est la maison d\'identifiant'." ".$maison_gourmande.'. </br>';
            echo ' Elle a consommé au total '.$conso_totale_elevee.' '.$inforessources['description'].'.'.'</br>';   
  
  }
}
?>
<h1>La maison la plus gourmande pour chaque Substances pour un mois donné</h1>
<?php 
  $reqsubstance=$BDD->query('SELECT * FROM substances'); 
    while($infosubstances=$reqsubstance->fetch()){
      if($infosubstances['libele'] != 'Null'){
      $emis_totale_elevee=0; 
    $reqmaison=$BDD->query('SELECT * FROM maison'); 
    while($infomaison=$reqmaison->fetch()){

      $reqvue_appart=$BDD->prepare('CREATE VIEW vue_appartement AS SELECT Id_Appartement FROM appartement WHERE Id_Maison=?'); 
      $reqvue_appart->execute(array($infomaison['Id_Maison'])); 
      $reqvue_piece=$BDD->query('CREATE VIEW  vue_piece AS SELECT Id_Piece FROM piece WHERE Id_Appartement IN (SELECT * FROM vue_appartement)'); 
      $reqvue_piece=$BDD->query('CREATE VIEW vue_appareil AS SELECT Id_Appareil FROM appartient_piece WHERE Id_Piece IN (SELECT * FROM vue_piece)');

      $reqselec_appareil=$BDD->prepare('SELECT DISTINCT * FROM duree_de_conso d LEFT JOIN emet c ON (d.Id_Appareil=c.Id_Appareil) WHERE d.date_fin LIKE "2021-01%" AND c.Id_Ressources=?  AND d.Id_Appareil IN (SELECT * FROM vue_appareil)'); 
      $reqselec_appareil->execute(array($infosubstances['Id_Substances'])); 
      $emis_tot_maison=0; 
      while ($infoselect_appareil=$reqselec_appareil->fetch()){
          $reqemet=$BDD->prepare('SELECT * FROM emet WHERE Id_Appareil=?'); 
          $reqemet->execute(array($infoselect_appareil['Id_Appareil'])); 
          $infoemet=$reqemet->fetch(); 
          $duree=date_diff(date_create($infoselect_appareil['date_fin']),date_create($infoselect_appareil['date_debut'])); 
          $duree=$duree->format('%s'); 
          $emis_tot_maison=$emis_tot_maison+$duree*$infoemet['Emmission_par_h'];  
          if($emis_tot_maison > $emis_totale_elevee){
            $emis_totale_elevee=$emis_tot_maison;
            $maison_emetrice=$infomaison['Id_Maison']; 
          
      }
          

          $reqsuppvuepiece=$BDD->query('DROP VIEW vue_piece'); 
          $reqsuppvueappart=$BDD->query('DROP VIEW vue_appartement'); 
          $reqsuppvueappareil=$BDD->query('DROP VIEW vue_appareil'); 
    }
     
            echo 'La maison la plus gourmande pour la substance '.$infosubstances['libele'].' est la maison d\'identifiant'." ".$maison_emetrice.'. </br>';
            echo ' Elle a émis au total '.$emis_totale_elevee.' '.$infosubstances['description'].'.'.'</br>';   
          }
  
  }
}
  ?>
</div>

</body>
<footer class="footerchiant">
    <p>&copy; 2020 - Les Imposteurs</p>
</footer>
</html>
