<?php
require_once('connexion.php');
$querry = 'SELECT titre FROM list'; 
$resultat = $db->prepare($querry);
$resultat->execute();
$verificationTitre = array();
while ($ligne = $resultat->fetch()) {
    $verificationTitre[] = $ligne;
}
require_once('deconnexion.php');
?>