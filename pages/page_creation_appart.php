<?php 

	session_start();
	
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');

	$idpersonne = $_SESSION['id'];
	
	if(isset($_POST['boutton_appart']))
	{
		if(!empty($_POST['degre_secu']) AND !empty($_POST['nbpiece']) AND !empty($_POST['dateentre']) AND !empty($_POST['rue']) AND !empty($_POST['numrue']) AND !empty($_POST['cp']) AND !empty($_POST['ville']))
		{
			$degre_secu = htmlspecialchars($_POST['degre_secu']);
			$nbpiece = htmlspecialchars($_POST['nbpiece']);
			$dateentre = new DateTime($_POST['dateentre']);
			$rue = htmlspecialchars($_POST['rue']);
			$numrue = htmlspecialchars($_POST['numrue']);
			$cp = htmlspecialchars($_POST['cp']);
			$ville = htmlspecialchars($_POST['ville']);

			/* requete pour avoir id ville*/
			$requidville=$bdd->prepare("SELECT * FROM ville WHERE Nom = ? AND CP = ? "); 
			$requidville->execute(array($ville, $cp));
			$idville=$requidville->fetch();
			$villeexist=$requidville->rowCount();
			if($villeexist != 0)
			{
				/* requete pour avoir id maison*/
				$requid=$bdd->prepare("SELECT * FROM maison WHERE Rue = ? AND Num_rue = ? AND Id_Ville = ?"); 
				$requid->execute(array($rue , $numrue, $idville['Id_Ville']));
				$idmaison=$requid->fetch();
				$maisonexist=$requid->rowCount();  
				if($maisonexist != 0)
				{
					/* ajout  de l'appartement dans la base de donnée */
					$dateentre = $dateentre->format('Y-m-d');
					$idtypeappart = 0;
					$insertintoappart = $bdd->prepare("INSERT INTO appartement(degre_de_secu, piece, Id_Maison, Id_type_appart, Id_Personne, date_debut, date_fin) VALUES(?, ?, ?, ?, ?,?,?)");
					$insertintoappart->execute(array($degre_secu, $nbpiece, $idmaison['Id_Maison'], $idtypeappart, $idpersonne, $dateentre, $dateentre));
					$erreur = "votre piece a bien été ajouté!";
					header("Location: Page_utilisateur.php?id=".$_SESSION['id']);

				}
				else
				{
					$erreur = "la maison n'existe pas, veuillez la créer";
				}
			}
			else
			{
				$erreur = "La ville n'existe pas";
			}
		}
		else
		{
			$erreur = "Veuillez remplir tous les champs !";
		}
	}
?>
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>page création appartement</title>
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
				<?php
				}
				?>
				<li><a href="Page_utilisateur.php?id=<?php echo $_SESSION['id'];?>" >Page locataire</a></li>
				<li><a href="page_proprietaire.php?id=<?php echo $_SESSION['id'];?>">Page Propriétaire</a></li>
				<li><a href="tableau_de_bord.php?id=<?php echo $_SESSION['id'];?>">Tableau de Bord</a></li>
				<li><a href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</header>
		<div align="center">
			<h1>Création appartement</h1>
			</br></br>
			<form method="POST" action="">
				<table>
					<!--infos pour appartement-->
					<tr>
						<td align="right">
							<label for="Degré de sécurité">
							Degré de sécurité :</label>
						</td>
						<td>
							<input type="number" min="0" max="10" placeholder="0(faible)-10(fort)" id="degre_secu" name="degre_secu" value="<?php if(isset($degre_secu)) { echo $degre_secu; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="NbPiece">
							Nombre de pièces :</label>
						</td>
						<td>
							<input type="number" placeholder="Entrer le nombre de piece" id="nbpiece" name="nbpiece" min="0" value="<?php if(isset($nbpiece)) { echo $nbpiece; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="dateentre">Date d'entrée dans l'appartement :</label>
						</td>
						<td>
							<input type="date" id="dateentre"name="dateentre" />
						</td>
					</tr>
					<!--infos pour retrouver la maison-->
					<tr>
						<td align="right">
							<label for="rue">Nom de rue :</label>
						</td>
						<td>
							<input type="text" placeholder="Adresse" id="rue"name="rue" value="<?php if(isset($rue)) { echo $rue; }?>"  />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="numrue">
							Numéro de rue :</label>
						</td>
						<td>
							<input type="number" placeholder="Numéro de rue" id="numrue" name="numrue" min="0" value="<?php if(isset($numrue)) { echo $numrue; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="CP">
							Code Postal :</label>
						</td>
						<td>
							<input type="number" placeholder="Code Postal" id="cp" name="cp" min="0" value="<?php if(isset($cp)) { echo $cp; }?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="ville">Ville :</label>
						</td>
						<td>
							<input type="text" placeholder="Ville" id="ville"name="ville" value="<?php if(isset($ville)) { echo $ville; }?>" value="<?php if(isset($ville)) { echo $ville; }?>"  />
						</td>
					</tr>
					<!--boutton submit-->
					<tr>
						
							<td colspan="2" align="center">
							</br></br>
							<input type="submit" id="boutton_appart" name="boutton_appart" value="J'inscris mon appartement" />
							</td>
						</tr>
				</table>
			</form>
		</div>
		<?php
			if(isset($erreur))
			{
				echo '<font color="red">'.$erreur."</font>"; 
			}
		?>
		<footer>
		<p>&copy; 2020 - Les Imposteurs</p>
	</footer>
	</body>
</html>