<?php 

	session_start();
	
	$BDD = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');
	
	if(isset($_POST['boutton_maison']))
	{
		if(!empty($_POST['nommaison']) AND !empty($_POST['rue']) AND !empty($_POST['ville']) AND !empty($_POST['cp']) AND !empty($_POST['dept']) AND !empty($_POST['region']) AND !empty($_POST['degre_isolation']) AND !empty($_POST['eco_immeuble']))
		{
			$nommaison = htmlspecialchars($_POST['nommaison']);
			$rue = htmlspecialchars($_POST['rue']);
			$numrue = htmlspecialchars($_POST['numrue']);
			$ville = htmlspecialchars($_POST['ville']);
			$cp = htmlspecialchars($_POST['cp']);
			$dept = htmlspecialchars($_POST['dept']);
			$region = htmlspecialchars($_POST['region']);
			$degre_isolation = htmlspecialchars($_POST['degre_isolation']);
			$eco_immeuble = htmlspecialchars($_POST['eco_immeuble']);
			
			$cplength = strlen($cp);
			
			if($cplength == 5)
			{
				$reqrue=$BDD->prepare("SELECT * FROM maison WHERE rue = ? AND numrue = ?"); 
				$reqrue->execute(array($rue , $numrue));
				$rueexist=$reqrue->rowCount();
				
				if($rueexist==0)
				{
					$reqregion=$BDD->prepare("SELECT * FROM region WHERE Nom = ?"); 
					$reqregion->execute(array($region));
					$regionexist=$reqregion->rowCount();
					
					if($regionexist==0)
					{
						$insertregion = $BDD->prepare("INSERT INTO region(Nom) VALUES(?)");
						$insertregion->execute(array($region));
					}
					
					
					$reqidregion = $BDD->prepare("SELECT Id_Region FROM region WHERE Nom = ?");
					$reqidregion->execute(array($region));
					$idregion = $reqidregion->fetch();
					$reqidregion->closeCursor();
					
					$reqdept=$BDD->prepare("SELECT * FROM departement WHERE Nom = ? AND Id_Region = ?"); 
					$reqdept->execute(array($dept, $idregion['Id_Region']));
					$deptexist=$reqdept->rowCount();
					
					if($deptexist==0)
					{
						$insertdept = $BDD->prepare("INSERT INTO departement(Nom, Id_Region ) VALUES(?, ?)");
						$insertdept->execute(array($dept, $idregion['Id_Region']));
					}
					
					
					$reqiddept = $BDD->prepare("SELECT Id_Departement FROM departement WHERE Nom = ?");
					$reqiddept->execute(array($dept));
					$iddept = $reqiddept->fetch();
					$reqiddept->closeCursor();
					
					$reqville=$BDD->prepare("SELECT * FROM ville WHERE Nom = ? AND CP = ? AND Id_Departement = ?"); 
					$reqville->execute(array($ville, $cp, $iddept['Id_Departement']));
					$villeexist=$reqville->rowCount();
					
					if($villeexist==0)
					{
						$insertville = $BDD->prepare("INSERT INTO ville(Nom, CP, Id_Departement) VALUES(?, ?, ?)");
						$insertville->execute(array($ville, $cp, $iddept['Id_Departement']));
					}
					
					
					$reqidville = $BDD->prepare("SELECT Id_Ville FROM ville WHERE Nom = ? AND CP = ?");
					$reqidville->execute(array($ville, $cp));
					$idville = $reqidville->fetch();
					$reqidville->closeCursor();
					
					$insertmaison = $BDD->prepare("INSERT INTO maison(Nom, Rue, Num_rue, degre_isolation, eco_immeuble, Id_Ville) VALUES(?, ?, ?, ?, ?, ?)");
					$insertmaison->execute(array($nommaison, $rue, $numrue, $degre_isolation, $eco_immeuble, $idville['Id_Ville']));
					echo 'bravo';
					/*header("Location: Page_utilisateur.php".$_SESSION['id']);*/
				}
				else
				{
					$erreur = "Cette maison est déjà référencé !";
				}
			}
			else
			{
				$erreur = "Le code postale n'est pas de bonne taille !";
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
							<label for="Numéro de Rue">
							Numéro de Rue:</label>
						</td>
						<td>
							<input type="number" placeholder="Numéro de la rue" id="numrue" name="numrue" />
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
						<td align="right">
							<label for="Degré Isolation">
							Degré d'isolation:</label>
						</td>
						<td>
							<input type="number" placeholder="Entrer le degré d'isolation" id="degre_isolation" name="degre_isolation" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="Eco Immeuble">
							Eco immeuble:</label>
						</td>
						<td>
							<input type="number" placeholder="Entrer le degré d'isolation" id="eco_immeuble" name="eco_immeuble" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<input type="submit" id="boutton_maison" name="boutton_maison" value="J'inscris ma maison" />
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