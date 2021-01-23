<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 

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
				labels: [	'0h00', '1h00', '2h00', '3h00', '4h00', '5h00', '6h00', '7h00', '8h00',
							'9h00', '10h00', '11h00', '12h00', '13h00', '14h00', '15h00', '16h00', 
							'17h00', '18h00', '19h00', '20h00', '21h00', '22h00', '23h00'
						],
				datasets: 
				[{
					label: 'Aujourd\'hui',
					data: [12, 19, 3, 5, 2, 3],
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
