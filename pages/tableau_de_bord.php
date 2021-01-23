<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
	
	$reqidappart=$BDD->prepare('SELECT Id_Appartement FROM appartement WHERE Id_Personne = ?');
	$reqidappart=execute(array($_SESSION['id']));
	while($infoidappart=$reqidappart->fetch())
	{
		$reqidpiece=$BDD->prepare('SELECT Id_Piece FROM piece WHERE Id_Appartement = ?');
		$reqidpiece=execute(array($infoidappart));
		while($infoidpiece=$reqidpiece->fetch())
		{
			$reqidappareil=$BDD->prepare('SELECT Id_Appareil FROM appartient_piece WHERE Id_Piece = ?');
			$reqidappareil=execute(array($infoidpiece));
			while($infoidappareil=$reqidappareil->fetch())
			{
				$reqconsomme=$BDD->prepare('SELECT Consommation_par_h FROM consomme WHERE Id_Appareil = ?');
				$reqconsomme=execute(array($infoidappareil));
				
				$infoconsomme=$reqconsomme->fetch();
				
				$reqdureeconsofin=$BDD->prepare('SELECT date_fin FROM duree_de_conso WHERE Id_Appareil = ?');
				$reqdureeconsofin=execute(array($infoidappareil));
				$infodureeconsofin=$reqdureeconsofin->fetch();
				$infodureeconsofin=format("Y:m:d");
				$aujourdhui = date("Y-m-d");
				if ($infodureeconsofin != $aujourdhui)
				{
					
				}
			}
		}
	}
?>
<html>
   <head>

      <title>Projet BDD</title>
      <meta charset="utf-8">
	    <link rel="stylesheet" href="style.css">
		<script src="package/dist/Chart.bundle.js"></script>

   </head>

   <body>

		<header>

			<ul>

				<li><a href="editionprofil.php">Editer mon profil</a></li>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
				<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>		


				
				
			</ul>

		</header>
		<h2>Tableau de consommation total des ressources:</h2>
		<div id="container" style="width: 50%">
		<canvas id="nbgenre"> </canvas>
		</div>
		<script>
		var ctx = document.getElementById('nbgenre').getContext('2d');
		var myLineChart = new Chart(ctx, 
		{
			type: 'line',
			data: 
			{
				labels: [	'0h00-2h00', '2h00-4h00', '4h00-6h00', '6h00-8h00',
							'8h00-10h00', '10h00-12h00', '12h00-14h00', '14h00-16h00', 
							'16h00-18h00', '18h00-20h00', '20h00-22h00', '22h00-23h59'
						],
				datasets: 
				[{
				label: 'Aujourd\'hui',
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: 
					[
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: 
					[
						'rgba(255, 99, 132, 1)',
					],
					borderWidth: 1
				},
				{
					label: 'hier',
					data: [19, 3, 5, 2, 3, 12],
					backgroundColor: 
					[
						'rgba(75, 192, 192, 0.2)',
					],
					borderColor: 
					[
						'rgba(75, 192, 192, 1)',
					],
					borderWidth: 1
				}]
				
			},
			options: 
			{
				scales: 
				{
					yAxes: 
					[{
						ticks: 
						{
							beginAtZero: true
						}
					}]
				}
			}
		});
		</script>

		</canvas>
	</body>
</html>
