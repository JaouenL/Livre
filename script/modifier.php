<?php
require_once('connexion.php');

$querry = 'UPDATE list SET 
                            image = :chemin_image,
                            titre = :titre_modifier,
                            alias = :alias_modifier, 
                            nombre_page_lu = :nombre_page_lu, 
                            fini = :fini,
                            ongoing = :ongoing,
                            url = :url
                            WHERE titre=:titre';

$requete = $db->prepare($querry);

try {
    $requete->execute([
        'chemin_image' => $_POST['chemin_image'],
        'titre_modifier' => $_POST['titre_modifier'],
        'alias_modifier' => $_POST['alias'],
        'nombre_page_lu' => $_POST['nombre_page_lu'],
        'fini' => $_POST['fini'],
        'ongoing' => $_POST['ongoing'],
        'titre' => $_POST['titre'],
        'url' => $_POST['url'],
    ]);
} catch (Exception $e) {
    echo $e;
}
require_once('deconnexion.php');
