<?php 

	$bdd = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');
	
	if(isset($_POST['bouton_maison']))
	{
		if(!empty($_POST['nommaison']) AND !empty($_POST['rue']) AND !empty($_POST['ville']) AND !empty($_POST['cp']) AND !empty($_POST['dept']) AND !empty($_POST['region']))
		{
			$nommaison = htmlspecialchars($_POST['nommaison']);
			$rue = htmlspecialchars($_POST['rue']);
			$ville = htmlspecialchars($_POST['ville']);
			$cp = htmlspecialchars($_POST['cp']);
			$dept = htmlspecialchars($_POST['dept']);
			$region = htmlspecialchars($_POST['region']);
		}
		else
		{
			$erreur = "Tous les champs ne sont pas complétés !";
		}
	}
?>
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>page création maison</title>
	  <link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div align="center">
			<h1>Création maison</h1>
			</br></br>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="Nom de la maison">
							Nom de la maison:</label>
						</td>
						<td>
							<input type="text" placeholder="Entrer le nom de la maison" id="nommaison" name="nommaison" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Rue">
							Rue:</label>
						</td>
						<td>
							<input type="text" placeholder="Adresse de la maison" id="rue" name="rue" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Ville">
							Ville:</label>
						</td>
						<td>
							<input type="text" placeholder="Ville" id="ville" name="ville" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Code Postale">
							Code Postale:</label>
						</td>
						<td>
							<input type="number" placeholder="Code Postale" id="cp" name="cp" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Département">
							Département:</label>
						</td>
						<td>
							<input type="text" placeholder="Département" id="dept" name="dept" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Région">
							Région:</label>
						</td>
						<td>
							<input type="text" placeholder="Région" id="region" name="region" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<input type="submit" id="bouton_maison" name="bouton_maison" value="J'inscris ma maison" />
						</td>
					</tr>
				</table>
			</form>
			<?php
				if(isset($erreur))
				{
					echo $erreur;
				}
			?>
		</div>
	</body>
</html>