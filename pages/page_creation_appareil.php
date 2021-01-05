<?php 

	session_start();
	
	$BDD = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');
	
	if(isset($_POST['boutton_appareil']))
	{
		$libelle = htmlspecialchars($_POST['libelle']);
		$desc = htmlspecialchars($_POST['desc']);
		$type_appareil = htmlspecialchars($_POST['type_appareil']);
		$conso = htmlspecialchars($_POST['conso']);
		$emission = htmlspecialchars($_POST['emission']);
		$ressource = htmlspecialchars($_POST['ressource']);
		$substance = htmlspecialchars($_POST['substance']);
		
		if(!empty($_POST['libelle']) AND !empty($_POST['desc']) AND !empty($_POST['type_appareil']) AND !empty($_POST['conso']) AND !empty($_POST['emission']) AND !empty($_POST['ressource']) AND !empty($_POST['substance']))
		{
			
			$desclength = strlen($desc);
			
			if($desclength <= 30)
			{
				echo 'bravo';
			}
			else
			{
				$erreur = "La description doit faire maximum 30 caractères !";
			}
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
	  <title>creation appareil</title>
	  <link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div align="center">
			<h1>Ajout d'un appareil</h1>
			</br></br>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="Libellé">
							Libellé:</label>
						</td>
						<td>
							<input type="text" placeholder="Entrer le libellé de l'appareil" id="libelle" name="libelle" value="<?php if(isset($libelle)) { echo $libelle; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Description">
							Description:</label>
						</td>
						<td>
							<input type="text" placeholder="Description de la position de l'appareil" id="desc" name="desc" value="<?php if(isset($desc)) { echo $desc; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Type appareil">
							Type appareil:</label>
						</td>
						<td>
							<input type="number" placeholder="Id du type d'appareil" id="type_appareil" name="type_appareil" value="<?php if(isset($type_appareil)) { echo $type_appareil; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Consommation">
							Consommation:</label>
						</td>
						<td>
							<input type="number" placeholder="Consommation par heure" id="conso" name="conso" value="<?php if(isset($conso)) { echo $conso; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Emission">
							Emission:</label>
						</td>
						<td>
							<input type="number" placeholder="Emission" id="emission" name="emission" value="<?php if(isset($emission)) { echo $emission; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Ressource">
							Ressource:</label>
						</td>
						<td>
							<input type="text" placeholder="Ressource consommée" id="ressource" name="ressource" value="<?php if(isset($ressource)) { echo $ressource; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Substance">
							Substance:</label>
						</td>
						<td>
							<input type="text" placeholder="Substance émise" id="substance" name="substance" value="<?php if(isset($substance)) { echo $substance; }?>" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<input type="submit" id="boutton_appareil" name="boutton_appareil" value="J'ajoute mon appareil" />
						</td>
					</tr>
				</table>
			</form>
		</div>
		<?php
			if(isset($erreur))
			{
				echo $erreur;
			}
		?>
	</body>
</html>