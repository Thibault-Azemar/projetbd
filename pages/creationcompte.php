<?php 

		$bdd =new PDO("mysql:host=127.0.0.1;dbname=bddphp","root",""); 
		if(isset($_POST['boutton_creer']))
		{
			if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['datenaissance']) AND !empty($_POST['email']) AND !empty($_POST['numtel']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])AND !empty($_POST['genre']))
			{
				$nom = htmlspecialchars($_POST['nom']);
				$prenom = htmlspecialchars($_POST['prenom']);
				$email = htmlspecialchars($_POST['email']);
				$mdp = sha1($_POST['mdp']);
				$mdp2 = sha1($_POST['mdp2']);

				
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					if ($mdp == $mdp2)
					{
						echo "c'est ok";
						$insertintocompte = $bdd->prepare("INSERT INTO personne(email, date_naissance, nom, genre, num_tel, prenom) VALUES(?, ?, ?, ?, ?, ?)");
						$insertintocompte->execute(array($email, $datenaissance, $nom, $genre, $numtel, $prenom));
						$erreur = "Votre compte a bien été créé !";
					}
					else
					{
						$erreur = "Les mots de passes ne correspondent pas !";
					}
				}
				else
				{
					$erreur = "L'email n'est pas valide !";
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
  <title>Projet BDD </title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
	<font color="#000000">
	<div class="Inscription" align="center">
		<h1>Page Inscription </h1>
		<form method="POST" action="">
			<label for="formulaire">
					<table align="center">
						<tr >
							<from method="POST" action="">
							<td align="right">
								<label for="nom">Nom :</label>
							</td>
							<td>
								<input type="text" placeholder="Votre Nom" id="nom"name="nom" value="<?php if(isset($nom)) { echo $nom; }?>" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Prenom :</label>
							</td>
							<td>
								<input type="text" placeholder="Votre Prenom" id="prenom"name="prenom" value="<?php if(isset($prenom)) { echo $prenom; }?>"  />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Genre :</label>
							</td>
							<td>
								<select name="genre">
									<option>Homme </option>
									<option>Femme</option>
									<option>Autre</option>
									<option selected="yes">Non précisé</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Date de naissance :</label>
							</td>
							<td>
								<input type="date" id="datenaissance"name="datenaissance" value="<?php if(isset($datenaissance)) { echo $datenaissance; }?>" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Email :</label>
							</td>
							<td>
								<input type="email" placeholder="....@...." id="email"name="email" value="<?php if(isset($email)) { echo $email; }?>"  />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Numéro de telephone :</label>
							</td>
							<td>
								<input type="tel" placeholder="Votre numéro de telephone" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" name="numtel" value="<?php if(isset($numtel)) { echo $numtel; }?>" >
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Mot de Passe :</label>
							</td>
							<td>
								<input type="password" placeholder="Votre mot de passe"id="mdp"name="mdp" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="formulaire">Confirmer le mot de passe :</label>
							</td>
							<td>
								<input type="password" placeholder="Réécriver votre mdp" id="mdp2"name="mdp2" />
							</td>
						</tr>

						<tr>
							<td></td> 
							<td>
								</br></br>
							<input type="submit" id="boutton_creer" name="boutton_creer" value="Créer compte"/>
							</td>
						</tr>
					</table>
				</label>
			</form>
		</div>
	<?php 
		
		if(isset($erreur))
		{
			echo '<font color="red">'.$erreur."</font>"; 
		}
 	?>

</body>
</html>