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
			Nom:</label>
			<input type="text" placeholder="Votre Nom" id="nom"name="nom" />
		</br></br>
			<label for="formulaire">
			Prenom:</label>
			<input type="text" placeholder="Votre Prenom" id="prenom"name="prenom" />
		</br></br>
		<label for="formulaire">
			Genre:</label>
			<div class="reponses">
				<input type="radio" name="quest1" value="homme"> Homme<br/>
				<input type="radio" name="quest1" value="femme"> Femme<br/>
				<input type="radio" name="quest1" value="non_precise"> Non précisé<br/>
				<input type="radio" name="quest1" value="autre"> Autre<br/>
			</div>
		</br></br>
			<label for="formulaire">
			Date de naissance:</label>
			<input type="date" id="datenaissance"name="date_de_naissance" />
		</br></br>
			<label for="formulaire">
			Email:</label>
			<input type="email" placeholder="....@...." id="email"name="email" />
		</br></br>
			<label for="formulaire">
			Numéro de telephone:</label>
			<input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$">

		</br></br>


</body>
</html>