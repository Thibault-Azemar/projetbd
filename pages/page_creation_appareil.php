<?php 
session_start();
	
	$BDD = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');
	
	$idpiece = $_GET['idpiece'];
	
	if(isset($_POST['boutton_ressource_substance']))
	{
		header("Location: page_creation_ressource_substance.php?id=".$_SESSION['id']);
	}
	
	if(isset($_POST['boutton_appareil']))
	{
		$emmission = 0;
		
		$libelle = htmlspecialchars($_POST['libelle']);
		$desc = htmlspecialchars($_POST['desc']);
		$type_appareil = htmlspecialchars($_POST['type_appareil']);

		


		$reqidtype=$BDD->prepare("SELECT Id_Type_appareil FROM type_appareil WHERE nom_appareil = ?");
		$reqidtype->execute(array($type_appareil));
		$type=$reqidtype->fetch();
		$reqidtype->closeCursor();
		echo $type['Id_Type_appareil'];
		


		



		$conso = htmlspecialchars($_POST['conso']);
		if(!empty($_POST['emmission']))
		{
			$emission = htmlspecialchars($_POST['emission']);
		}
		
		$substance = htmlspecialchars($_POST['substance']);
		
			
		$ressource = htmlspecialchars($_POST['ressource']);
			
		$lien = htmlspecialchars($_POST['lien']);
		
		if(!empty($_POST['libelle']) AND !empty($_POST['desc']) AND !empty($_POST['type_appareil']) AND !empty($_POST['conso']) AND !empty($_POST['ressource']))
		{
			
			$desclength = strlen($desc);
			
			if($desclength <= 30)
			{
				$reqressource=$BDD->prepare("SELECT * FROM ressources WHERE libele = ?"); 
				$reqressource->execute(array($ressource));
				$ressourceexist=$reqressource->rowCount();
				if($ressourceexist == 1)
				{
					$reqsubstance=$BDD->prepare("SELECT * FROM substances WHERE libele = ?"); 
					$reqsubstance->execute(array($substance));
					$substanceexist=$reqsubstance->rowCount();
					if($substanceexist == 1)
					{
						$reqtypeappareil=$BDD->prepare("SELECT * FROM type_appareil WHERE Id_Type_appareil = ?"); 
						$reqtypeappareil->execute(array($type['Id_Type_appareil']));
						$typeappareilexist=$reqtypeappareil->rowCount();
						
						if($typeappareilexist == 0 )
						{
							$inserttypeappareil = $BDD->prepare("INSERT INTO type_appareil(Id_Type_appareil) VALUES(?)");
							$inserttypeappareil->execute(array($type['Id_Type_appareil']));
						}
						
						$insertappareil = $BDD->prepare("INSERT INTO appareil(description, libelle, Id_Type_appareil , conso_par_h, emission_par_h) VALUES(?, ?, ?, ?, ?)");
						$insertappareil->execute(array($desc, $libelle, $type['Id_Type_appareil'], $conso, $emission));
						
						$reqidappareil = $BDD->prepare("SELECT Id_Appareil FROM appareil WHERE description = ?");
						$reqidappareil->execute(array($desc));
						$idappareil = $reqidappareil->fetch();
						$reqidappareil->closeCursor();
						
						$reqidsubstance = $BDD->prepare("SELECT Id_Substances FROM substances WHERE libele = ?");
						$reqidsubstance->execute(array($substance));
						$idsubstance = $reqidsubstance->fetch();
						$reqidsubstance->closeCursor();
						
						$reqidressource = $BDD->prepare("SELECT Id_Ressources FROM ressources WHERE libele = ?");
						$reqidressource->execute(array($ressource));
						$idressource = $reqidressource->fetch();
						$reqidressource->closeCursor();
						
						$insertlien = $BDD->prepare("INSERT INTO video(Lien, Id_Appareil) VALUES(?, ?)");
						$insertlien->execute(array($lien, $idappareil['Id_Appareil']));
						
						$insertemet = $BDD->prepare("INSERT INTO emet(Id_Appareil, Id_Substances, Emmission_par_h) VALUES(?, ?, ?)");
						$insertemet->execute(array($idappareil['Id_Appareil'], $idsubstance['Id_Substances'], $emission));
						
						$insertconso = $BDD->prepare("INSERT INTO consomme(Id_Appareil, Id_Ressources, Consommation_par_h) VALUES(?, ?, ?)");
						$insertconso->execute(array($idappareil['Id_Appareil'], $idressource['Id_Ressources'], $conso));
						
						$insertpiece = $BDD->prepare("INSERT INTO appartient_piece(Id_Piece, Id_Appareil) VALUES(?, ?)");
						$insertpiece->execute(array($idpiece['idpiece'] ,$idappareil['Id_Appareil']));
						
						$erreur = "Votre appareil à bien été ajouté";
						header("Location: Page_utilisateur.php?id=".$_SESSION['id']);
					}
					else
					{
						$erreur = "Cette substance n'est pas dans notre base de données, ajouter la !";
					}
				}
				else
				{
					$erreur = "Cette ressource n'est pas dans notre base de données, ajouter la !";
				}
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
		<header>
			<ul>
				<li><a href="editionprofil.php">Editer mon profil</a></li>
				<?php
				if(isset($_SESSION['id'])) {
				?>
				<li><a href="Page_Administrateur.php?id=<?php echo $_SESSION['id'];?>">Page Administrateur</a></li>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
				<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="tableau_de_bord.php?id=<?php echo $_SESSION['id'];?>">Tableau de Bord</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
				<?php
				}
				?>
				
			</ul>
		</header>
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
					<!--<tr>
						<td align="right">
							<label for="Type appareil">
							Type appareil:</label>
						</td>
						<td>
							<input type="number" placeholder="Id du type d'appareil" id="type_appareil" name="type_appareil" value="<?php if(isset($type_appareil)) { echo $type_appareil; }?>" />
						</td>
					</tr>-->
					<tr>
						<td align="right">
							<label for="Type appareil">
							Type appareil:</label>
						</td>
						<td>
							<?php
								$reqtypes = "SELECT * FROM type_appareil";
								$listeress=$BDD->query($reqtypes);
							?>
							<select name="type_appareil">
								<?php 
							
									while($ligness=$listeress->fetch())
									{
								?>
										<option><?php echo $ligness['nom_appareil'];?></option>
								<?php
									}
								?>
							</select>
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
					<!--
					<tr>
						<td align="right">
							<label for="Ressource">
							Ressource:</label>
						</td>
						<td>
							<input type="text" placeholder="Ressource consommée" id="ressource" name="ressource" value="<?php if(isset($ressource)) { echo $ressource; }?>" />
						</td>
					</tr>
					-->
					<tr>
						<td align="right">
							<label for="Ressource">
							Ressource:</label>
						</td>
						<td>
							<?php
								$reqressource = "SELECT * FROM ressources";
								$listeres=$BDD->query($reqressource);
							?>
							<select name="ressource">
								<?php 
							
									while($ligne=$listeres->fetch())
									{
								?>
										<option><?php echo $ligne['libele'];?></option>
								<?php
									}
								?>
							</select>
						</td>


					</tr>



					<!--<tr>
						<td align="right">
							<label for="Substance">
							Substance:</label>
						</td>
						<td>
							<input type="text" placeholder="Null si jamais rien n'est émis" id="substance" name="substance" value="<?php if(isset($substance)) { echo $substance; }?>" />
						</td>
					</tr>-->
					<tr>
						<td align="right">
							<label for="Substance">
							Substance:</label>
						</td>
						<td>
							<?php
								$reqsubstance = "SELECT * FROM substances";
								$listesub=$BDD->query($reqsubstance);
							?>
							<select name="substance">
								<?php 
							
									while($lignes=$listesub->fetch())
									{
								?>
										<option><?php echo $lignes['libele'];?></option>
								<?php
									}
								?>
							</select>
						</td>


					</tr>
					<tr>
						<td align="right">
							<label for="Lien vidéo">
							Lien vidéo:</label>
						</td>
						<td>
							<input type="text" placeholder="Lien de la vidéo descriptive" id="lien" name="lien" value="<?php if(isset($lien)) { echo $lien; }?>" />
						</td>
					</tr>
					<tr>
						
						<td  colspan="2" align="center">
							<input type="submit" id="boutton_appareil" name="boutton_appareil" value="J'ajoute mon appareil" />
						</td>
					</tr>
				</table>
			</form>
			<form method="POST" action="">
				<input type="submit" id="boutton_ressource_substance" name="boutton_ressource_substance" value="J'ajoute une substance ou une ressource" />
			</form>
		</div>
		<?php
			if(isset($erreur))
			{
				echo $erreur;
			}
		?>
		<footer>
		<p>&copy; 2020 - Les Imposteurs</p>
	</footer>
	</body>
</html>