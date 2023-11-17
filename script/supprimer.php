<?php
    require_once('connexion.php');

	$querry = 'DELETE FROM list WHERE titre = :titre';
    $requete = $db->prepare($querry);
    $requete->execute([
        'titre' => $_POST['titre'],
    ]);

    require_once('deconnexion.php');
