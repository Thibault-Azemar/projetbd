<?php
session_start();  
		
		$BDD=new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		


		$reqhomme = $BDD->query('SELECT COUNT(*) AS nbhomme FROM personne WHERE genre="Homme"');
		$reqfemme=$BDD->query('SELECT COUNT(*) AS nbfemme FROM personne WHERE genre="Femme"');
		$infohomme = $reqhomme->fetch();
		$infofemme = $reqfemme->fetch();
		?>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>BDD Projet</title>
  <link rel="stylesheet" href="style.css">
  <script src="package/dist/Chart.bundle.js"></script>
</head>
<body>
	Ceci est une page anonyme 
	<canvas id="myChart"></canvas>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
       
        datasets: [{
            label: '# of Votes',
            data: [<?php echo $infohomme['nbhomme'] ?>, <?php echo $infofemme['nbfemme'] ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                
            ],
            borderWidth: 1
        }],
         labels: ['Homme', 'Femme']
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
