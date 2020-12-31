<?php 

		$BDD =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		if(isset($_POST['Boutton_Connex']))
		{
			echo "ok";
			if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['date_de_naissance']) AND !empty($_POST['email']) AND !empty($_POST['numtel']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) /** AND ($genre != NULL) **/)
			{
				echo "good";
			}
		}
		else
		{
			echo "pas ok";
		}
 ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>BDD Projet</title>
  <link rel="stylesheet" href="style.css">
</head>
	<body>
		<div align="center">
				<h1>Inscription</h1>
			</br></br>
			<from method="POST" action="">
				<label for="formulaire">
					<table align="center">
						<tr >
							<td align="right">
								<label for="nom">Nom :</label>
							</td>
							<td>
								<input type="text" placeholder="Votre Nom" id="nom"name="nom" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Prenom :</label>
							</td>
							<td>
								<input type="text" placeholder="Votre Prenom" id="prenom"name="prenom" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Genre :</label>
							</td>
							<td>
								<div class="reponses">
									<input type="radio" name="homme" value="homme"> Homme<br/>
									<input type="radio" name="femme" value="femme"> Femme<br/>
									<input type="radio" name="non_precise" value="non_precise"> Non précisé<br/>
									<input type="radio" name="autre" value="autre"> Autre<br/>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Date de naissance :</label>
							</td>
							<td>
								<input type="date" id="datenaissance"name="date_de_naissance" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Email :</label>
							</td>
							<td>
								<input type="email" placeholder="....@...." id="email"name="email" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Numéro de telephone :</label>
							</td>
							<td>
								<input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" name="numtel">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Mot de Passe :</label>
							</td>
							<td>
								<input type="password" id="mdp"name="mdp" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Confirmer le mot de passe :</label>
							</td>
							<td>
								<input type="password" id="mdp2"name="mdp2" />
							</td>
						</tr>
						<tr>
						</tr>
					</table>
					<input type="submit" id="Boutton_Connex" name="Boutton_Connex" value="Confirmer"/>
				</label>
			</from>
			<?php
			if(isset($erreur))
			{
				echo '<font color="red">'.$erreur."</font>";
			}
			?>
		</div>
	</body>
</html>