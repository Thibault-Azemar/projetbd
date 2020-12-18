<?php
// requetes non préparées avec myslqi
function insertUser($bd, $email, $datenaissance, $nom, $genre, $numtel, $prenom)
{
	$requete = "insert into personne (email, datenaissance, nom, genre, numtel, prenom)" . "values ('$email', '$datenaissance', '$nom',      '$genre', '$numtel', '$prenom')";
	$reponse = mysqli_query($bd, $requete);
	return $reponse;
}
?>