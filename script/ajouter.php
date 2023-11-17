<?php
    require_once('connexion.php');

	$querry = 'INSERT INTO list VALUES(null, :chemin_image, :titre, :alias, :nombre_page_lu, :fini, :ongoing, :url)';
    $requete = $db->prepare($querry);
    $requete->execute([
        'chemin_image' => $_POST['chemin_image'],
        'titre' => $_POST['titre'],
        'alias' => $_POST['alias'],
        'nombre_page_lu' => $_POST['nombre_page_lu'],
        'fini' => $_POST['fini'],
        'ongoing' => $_POST['ongoing'],
        'url' => $_POST['url'],
    ]);

    require_once('deconnexion.php');
?>