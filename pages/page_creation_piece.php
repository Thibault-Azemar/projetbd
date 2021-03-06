<?php 

	session_start();
	
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');

	$idpersonne = $_SESSION['id'];
	
	if(isset($_POST['bouton_piece']))
	{
		if(!empty($_POST['typepiece']) AND !empty($_POST['libele']))
		{
			$typepiece = htmlspecialchars($_POST['typepiece']);
			$libele = htmlspecialchars($_POST['libele']);

			//récupération de id type piece

			$reqtypepiece=$bdd->prepare("SELECT * FROM type_piece WHERE nom_type = ?"); 
			$reqtypepiece->execute(array($typepiece));
			$typepieceexist=$reqtypepiece->rowCount();
					
			if($typepieceexist==0)
			{
				$inserttypepiece = $bdd->prepare("INSERT INTO type_piece(nom_type) VALUES(?)");
				$inserttypepiece->execute(array($typepiece));
			}

			$reqidtypepiece = $bdd->prepare("SELECT * FROM type_piece WHERE nom_type = ?");
			$reqidtypepiece->execute(array($typepiece));
			$idtypepiece = $reqidtypepiece->fetch();
			$reqidtypepiece->closeCursor();

			$idappartement = $_GET['idappartement']; //récuperer l'id appart

			//ajout de la piece

			$insertintopiece = $bdd->prepare("INSERT INTO piece(libelle, Id_Type_piece, Id_Appartement) VALUES(?, ?, ?)");
			$insertintopiece->execute(array($libele, $idtypepiece['Id_Type_piece'], $idappartement));

			$erreur = "l'appartement a bien été ajouté!";

			header("Location: Page_utilisateur.php?id=".$_SESSION['id']);

		}
		else
		{
			$erreur = "Tous les champs ne sont pas remplis!";
		}
	}
?>
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>page ajout piece</title>
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
			<h1>Création piece</h1>
			</br></br>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="nompiece"> Type de piece:</label>
						</td>
						<td>
							<input type="text" placeholder="Type de piece" id="typepiece"name="typepiece" value="<?php if(isset($typepiece)) { echo $typepiece; }?>"  />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="libele">Description :</label>
						</td>
						<td>
							<input type="text" placeholder="Description de la piece" id="libele"name="libele" value="<?php if(isset($libele)) { echo $libele; }?>"  />
						</td>
					</tr>
					<tr>
						 
							<td  colspan="2" align="center">
							</br></br>
							<input type="submit" id="bouton_piece" name="bouton_piece" value="J'ajoute ma piece" />
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