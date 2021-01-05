<?php 

	session_start();
	
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=bddphp','root','');

	$idpersonne = $_SESSION['id'];
	
	if(isset($_POST['boutton_piece']))
	{
		
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
		<div align="center">
			<h1>Création piece</h1>
			</br></br>
			<form method="POST" action="">
				<table>

					<tr>
						<td></td> 
							<td>
							</br></br>
							<input type="submit" id="boutton_piece" name="boutton_piece" value="J'ajoute ma piece" />
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
	</body>
</html>