<?php
  session_start();  
		
	$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
	
	$idpersonne = $_GET['id'];
	
	$aujourdhui1 = 0;
	$aujourdhui2 = 0;
	$aujourdhui3 = 0;
	$aujourdhui4 = 0;
	$aujourdhui5 = 0;
	$aujourdhui6 = 0;
	$aujourdhui7 = 0;
	$aujourdhui8 = 0;
	$aujourdhui9 = 0;
	$aujourdhui10 = 0;
	$aujourdhui11 = 0;
	$aujourdhui12 = 0;
	
	$reqidappart=$BDD->prepare('SELECT Id_Appartement FROM appartement WHERE Id_Personne = ?');
	$reqidappart->execute(array($idpersonne));
	while($infoidappart=$reqidappart->fetch())
	{
		$reqidpiece=$BDD->prepare('SELECT Id_Piece FROM piece WHERE Id_Appartement = ?');
		$reqidpiece->execute(array($infoidappart['Id_Appartement']));
		while($infoidpiece=$reqidpiece->fetch())
		{
			$reqidappareil=$BDD->prepare('SELECT Id_Appareil FROM appartient_piece WHERE Id_Piece = ?');
			$reqidappareil->execute(array($infoidpiece['Id_Piece']));
			while($infoidappareil=$reqidappareil->fetch())
			{
				$reqconsomme=$BDD->prepare('SELECT Consommation_par_h FROM consomme WHERE Id_Appareil = ?');
				$reqconsomme->execute(array($infoidappareil['Id_Appareil']));
				
				$infoconsomme=$reqconsomme->fetch();
				$reqdureeconsofin=$BDD->prepare('SELECT date_fin FROM duree_de_conso WHERE Id_Appareil = ?');
				$reqdureeconsofin->execute(array($infoidappareil['Id_Appareil']));
				$infodureeconsofin=$reqdureeconsofin->fetch();
				
				$dureefin=date_create($infodureeconsofin[0]);
				
				$comparedureefin = date_format($dureefin, 'Y-m-d');
				
				$aujourdhui = date("Y-m-d");
				
				$compte = 0;
				
				if ($comparedureefin == $aujourdhui)
				{
					$reqdureeconsodeb=$BDD->prepare('SELECT date_debut FROM duree_de_conso WHERE Id_Appareil = ?');
					$reqdureeconsodeb->execute(array($infoidappareil['Id_Appareil']));
					$infodureeconsodeb=$reqdureeconsodeb->fetch();
					
					$dureedeb=date_create($infodureeconsodeb[0]);
				
					$comparedureedeb = date_format($dureedeb, 'Y-m-d');
					
					$finaldureefin = date_format($dureefin, 'Y-m-d H:i:s');
					
					if ($comparedureedeb == $aujourdhui)
					{
						$finaldureedeb = date_format($dureedeb, 'Y-m-d H:i:s');
						
						$comptes = date_diff(date_create($finaldureedeb), date_create($finaldureefin))->format('%s');
						$comptem = date_diff(date_create($finaldureedeb), date_create($finaldureefin))->format('%m');
						$compteh = date_diff(date_create($finaldureedeb), date_create($finaldureefin))->format('%H');
						$comptetotal = $comptes + $comptem*60 + $compteh*36000;
					}
					else
					{
						$comptes = date_diff(date_create($aujourdhui), date_create($finaldureefin))->format('%s');
						$comptem = date_diff(date_create($aujourdhui), date_create($finaldureefin))->format('%m');
						$compteh = date_diff(date_create($aujourdhui), date_create($finaldureefin))->format('%H');
						$comptetotal = $comptes + $comptem*60 + $compteh*36000;
					}
					$horaire = date_format($dureefin, 'H');
					if ($horaire < '23')
					{
						if ($horaire < '22')
						{
							if ($horaire < '20')
							{
								if ($horaire < '18')
								{
									if ($horaire < '16')
									{
										if ($horaire < '14')
										{
											if ($horaire < '12')
											{
												if ($horaire < '10')
												{
													if ($horaire < '8')
													{
														if ($horaire < '6')
														{
															if ($horaire < '4')
															{
																if ($horaire < '2')
																{
																	$aujourdhui1 = $comptetotal*$infoconsomme[0];
																}
																else
																{
																	$aujourdhui2 = $comptetotal*$infoconsomme[0];
																}
															}
															else
															{
																$aujourdhui3 = $comptetotal*$infoconsomme[0];
															}
														}
														else
														{
															$aujourdhui4 = $comptetotal*$infoconsomme[0];
														}
													}
													else
													{
														$aujourdhui5 = $comptetotal*$infoconsomme[0];
													}
												}
												else
												{
													$aujourdhui6 = $comptetotal*$infoconsomme[0];
												}
											}
											else
											{
												$aujourdhui7 = $comptetotal*$infoconsomme[0];
											}
										}
										else
										{
											$aujourdhui8 = $comptetotal*$infoconsomme[0];
										}
									}
									else
									{
										$aujourdhui9 = $comptetotal*$infoconsomme[0];
									}
								}
								else
								{
									$aujourdhui10 = $comptetotal*$infoconsomme[0];
								}
							}
							else
							{
								$aujourdhui11 = $comptetotal*$infoconsomme[0];
							}
						}
						else
						{
							$aujourdhui12 = $comptetotal*$infoconsomme[0];
						}
					}
				}
			}
		}
	}
	$hier1 = 0;
	$hier2 = 0;
	$hier3 = 0;
	$hier4 = 0;
	$hier5 = 0;
	$hier6 = 0;
	$hier7 = 0;
	$hier8 = 0;
	$hier9 = 0;
	$hier10 = 0;
	$hier11 = 0;
	$hier12 = 0;
	
	$reqidappart=$BDD->prepare('SELECT Id_Appartement FROM appartement WHERE Id_Personne = ?');
	$reqidappart->execute(array($idpersonne));
	while($infoidappart=$reqidappart->fetch())
	{
		$reqidpiece=$BDD->prepare('SELECT Id_Piece FROM piece WHERE Id_Appartement = ?');
		$reqidpiece->execute(array($infoidappart['Id_Appartement']));
		while($infoidpiece=$reqidpiece->fetch())
		{
			$reqidappareil=$BDD->prepare('SELECT Id_Appareil FROM appartient_piece WHERE Id_Piece = ?');
			$reqidappareil->execute(array($infoidpiece['Id_Piece']));
			while($infoidappareil=$reqidappareil->fetch())
			{
				$reqconsomme=$BDD->prepare('SELECT Consommation_par_h FROM consomme WHERE Id_Appareil = ?');
				$reqconsomme->execute(array($infoidappareil['Id_Appareil']));
				
				$infoconsomme=$reqconsomme->fetch();
				$reqdureeconsofin=$BDD->prepare('SELECT date_fin FROM duree_de_conso WHERE Id_Appareil = ?');
				$reqdureeconsofin->execute(array($infoidappareil['Id_Appareil']));
				$infodureeconsofin=$reqdureeconsofin->fetch();
				
				$dureefin=date_create($infodureeconsofin[0]);
				
				$comparedureefin = date_format($dureefin, 'Y-m-d');
				
				$aujourdhui = date("Y-m-d", ( time() - 86400));
				
				$compte = 0;
				
				if ($comparedureefin == $aujourdhui)
				{
					$reqdureeconsodeb=$BDD->prepare('SELECT date_debut FROM duree_de_conso WHERE Id_Appareil = ?');
					$reqdureeconsodeb->execute(array($infoidappareil['Id_Appareil']));
					$infodureeconsodeb=$reqdureeconsodeb->fetch();
					
					$dureedeb=date_create($infodureeconsodeb[0]);
				
					$comparedureedeb = date_format($dureedeb, 'Y-m-d');
					
					$finaldureefin = date_format($dureefin, 'Y-m-d H:i:s');
					
					if ($comparedureedeb == $aujourdhui)
					{
						$finaldureedeb = date_format($dureedeb, 'Y-m-d H:i:s');
						
						$comptes = date_diff(date_create($finaldureedeb), date_create($finaldureefin))->format('%s');
						$comptem = date_diff(date_create($finaldureedeb), date_create($finaldureefin))->format('%m');
						$compteh = date_diff(date_create($finaldureedeb), date_create($finaldureefin))->format('%H');
						$comptetotal = $comptes + $comptem*60 + $compteh*36000;
					}
					else
					{
						$comptes = date_diff(date_create($aujourdhui), date_create($finaldureefin))->format('%s');
						$comptem = date_diff(date_create($aujourdhui), date_create($finaldureefin))->format('%m');
						$compteh = date_diff(date_create($aujourdhui), date_create($finaldureefin))->format('%H');
						$comptetotal = $comptes + $comptem*60 + $compteh*36000;
					}
					$horaire = date_format($dureefin, 'H');
					if ($horaire < '23')
					{
						if ($horaire < '22')
						{
							if ($horaire < '20')
							{
								if ($horaire < '18')
								{
									if ($horaire < '16')
									{
										if ($horaire < '14')
										{
											if ($horaire < '12')
											{
												if ($horaire < '10')
												{
													if ($horaire < '8')
													{
														if ($horaire < '6')
														{
															if ($horaire < '4')
															{
																if ($horaire < '2')
																{
																	$hier1 = $comptetotal*$infoconsomme[0];
																}
																else
																{
																	$hier2 = $comptetotal*$infoconsomme[0];
																}
															}
															else
															{
																$hier3 = $comptetotal*$infoconsomme[0];
															}
														}
														else
														{
															$hier4 = $comptetotal*$infoconsomme[0];
														}
													}
													else
													{
														$hier5 = $comptetotal*$infoconsomme[0];
													}
												}
												else
												{
													$hier6 = $comptetotal*$infoconsomme[0];
												}
											}
											else
											{
												$hier7 = $comptetotal*$infoconsomme[0];
											}
										}
										else
										{
											$hier8 = $comptetotal*$infoconsomme[0];
										}
									}
									else
									{
										$hier9 = $comptetotal*$infoconsomme[0];
									}
								}
								else
								{
									$hier10 = $comptetotal*$infoconsomme[0];
								}
							}
							else
							{
								$hier11 = $comptetotal*$infoconsomme[0];
							}
						}
						else
						{
							$hier12 = $comptetotal*$infoconsomme[0];
						}
					}
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
					data: [	$aujourdhui1, $aujourdhui2, $aujourdhui3, $aujourdhui4, $aujourdhui5, $aujourdhui6, $aujourdhui7, 
							$aujourdhui8, $aujourdhui9, $aujourdhui10, $aujourdhui11, $aujourdhui12],
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
