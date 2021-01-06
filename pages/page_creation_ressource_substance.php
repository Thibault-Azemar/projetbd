<?php 
session_start();
	
	$BDD = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');
	
	if(isset($_POST['boutton_substance']))
	{
		$libellesub = htmlspecialchars($_POST['libellesub']);
		$descsub = htmlspecialchars($_POST['descsub']);
		$valeurmin = htmlspecialchars($_POST['valeurmin']);
		$valeurmax = htmlspecialchars($_POST['valeurmax']);
		$valeurcrit = htmlspecialchars($_POST['valeurcrit']);
		$valeuride = htmlspecialchars($_POST['valeuride']);
		
		if(!empty($_POST['libellesub']) AND !empty($_POST['descsub']) AND !empty($_POST['valeurmin']) AND !empty($_POST['valeurmax']) AND !empty($_POST['valeurcrit']) AND !empty($_POST['valeuride']))
		{
			$reqsubstance=$BDD->prepare("SELECT * FROM substances WHERE libele = ?"); 
			$reqsubstance->execute(array($libellesub));
			$substanceexist=$reqsubstance->rowCount();
			if($substanceexist == 0)
			{
				$insertsub = $BDD->prepare("INSERT INTO substances(libele, description, valeur_min_par_j, valeur_max_par_j, valeur_critique_par_j, valeur_ideale_par_j) VALUES(?, ?, ?, ?, ?, ?)");
				$insertsub->execute(array($libellesub, $descsub, $valeurmin, $valeurmax, $valeurcrit, $valeuride));
				
				$erreur = "Votre substance à bien été ajoutée";
				header("Location: Page_utilisateur.php?id=".$_SESSION['id']);
			}
			else
			{
				$erreur = "Cette substance existe déjà !";
			}
		}
		else
		{
			$erreur = "Tous les champs ne sont pas complétés !";
		}
	}
	
	if(isset($_POST['boutton_ressource']))
	{
		$libelleres = htmlspecialchars($_POST['libelleres']);
		$descres = htmlspecialchars($_POST['descres']);
		$valeurminres = htmlspecialchars($_POST['valeurminres']);
		$valeurmaxres = htmlspecialchars($_POST['valeurmaxres']);
		$valeurcritres = htmlspecialchars($_POST['valeurcritres']);
		$valeurideres = htmlspecialchars($_POST['valeurideres']);
		
		if(!empty($_POST['libelleres']) AND !empty($_POST['descres']) AND !empty($_POST['valeurminres']) AND !empty($_POST['valeurmaxres']) AND !empty($_POST['valeurcritres']) AND !empty($_POST['valeurideres']))
		{
			$reqres=$BDD->prepare("SELECT * FROM ressources WHERE libele = ?"); 
			$reqres->execute(array($libelleres));
			$resexist=$reqres->rowCount();
			if($resexist == 0)
			{
				$insertres = $BDD->prepare("INSERT INTO ressources(libele, description, valeur_min_par_j, valeur_max_par_j, valeur_critique_par_j, valeur_ideale_par_j) VALUES(?, ?, ?, ?, ?, ?)");
				$insertres->execute(array($libelleres, $descres, $valeurminres, $valeurmaxres, $valeurcritres, $valeurideres));
				
				$erreur = "Votre ressource à bien été ajoutée";
				header("Location: Page_utilisateur.php?id=".$_SESSION['id']);
			}
			else
			{
				$erreur = "Cette ressource existe déjà !";
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
			<h1>Ajout d'une substance</h1>
			</br></br>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="Libellé de la substance">
							Libellé de la substance:</label>
						</td>
						<td>
							<input type="text" placeholder="Entrer le libellé de la substance" id="libellesub" name="libellesub" value="<?php if(isset($libellesub)) { echo $libellesub; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Description de la substance">
							Description de la substance:</label>
						</td>
						<td>
							<input type="text" placeholder="Description de la sustance" id="descsub" name="descsub" value="<?php if(isset($descsub)) { echo $descsub; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur minimale par jour de la substance">
							Valeur minimale par jour de la substance:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur minimale par jour de la substance" id="valeurmin" name="valeurmin" value="<?php if(isset($valeurmin)) { echo $valeurmin; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur maximale par jour de la substance">
							Valeur maximale par jour de la substance:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur maximale par jour de la substance" id="valeurmax" name="valeurmax" value="<?php if(isset($valeurmax)) { echo $valeurmax; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur critique par jour de la substance">
							Valeur critique par jour de la substance:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur critique par jour de la substance" id="valeurcrit" name="valeurcrit" value="<?php if(isset($valeurcrit)) { echo $valeurcrit; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur idéale par jour de la substance">
							Valeur idéale par jour de la substance:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur idéale par jour de la substance" id="valeuride" name="valeuride" value="<?php if(isset($valeuride)) { echo $valeuride; }?>" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<input type="submit" id="boutton_substance" name="boutton_substance" value="J'ajoute une nouvelle substance" />
						</td>
					</tr>
				</table>
			</form>
			<h1>Ajout d'une ressource</h1>
			</br></br>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="Libellé de la ressource">
							Libellé de la ressource:</label>
						</td>
						<td>
							<input type="text" placeholder="Entrer le libellé de la ressource" id="libelleres" name="libelleres" value="<?php if(isset($libelleres)) { echo $libelleres; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Description de la ressource">
							Description de la ressource:</label>
						</td>
						<td>
							<input type="text" placeholder="Description de la ressource" id="descres" name="descres" value="<?php if(isset($descres)) { echo $descres; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur minimale par jour de la ressource">
							Valeur minimale par jour de la ressource:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur minimale par jour de la ressource" id="valeurminres" name="valeurminres" value="<?php if(isset($valeurminres)) { echo $valeurminres; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur maximale par jour de la ressource">
							Valeur maximale par jour de la ressource:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur maximale par jour de la ressource" id="valeurmaxres" name="valeurmaxres" value="<?php if(isset($valeurmaxres)) { echo $valeurmaxres; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur critique par jour de la ressource">
							Valeur critique par jour de la ressource:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur critique par jour de la ressource" id="valeurcritres" name="valeurcritres" value="<?php if(isset($valeurcritres)) { echo $valeurcritres; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Valeur idéale par jour de la ressource">
							Valeur idéale par jour de la ressource:</label>
						</td>
						<td>
							<input type="number" placeholder="Valeur idéale par jour de la ressource" id="valeurideres" name="valeurideres" value="<?php if(isset($valeurideres)) { echo $valeurideres; }?>" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<input type="submit" id="boutton_ressource" name="boutton_ressource" value="J'ajoute une nouvelle ressource" />
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