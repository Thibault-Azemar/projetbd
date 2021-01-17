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

		$reqage=$BDD->query('SELECT * FROM personne'); 
		while($infoage=$reqage->fetch()){
			$dateNaissance = "15-06-1995";
  			$aujourdhui = date("Y-m-d");
  			$diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
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
				<li><a href="editionprofil.php">Editer mon profil</a></li>
				<?php
				if(isset($_SESSION['id'])) {
				?>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<?php
				}
				?>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page utilisateur</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
	Ceci est une page anonyme 
	<canvas id="nbgenre"> </canvas>

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

<canvas id="nbpersonne"> </canvas>

<script>
var ctx = document.getElementById('nbpersonne').getContext('2d');
var nbpersonne = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
       labels: ['18-24', '24-45','45-65','+65'],
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


</body>
</html>
