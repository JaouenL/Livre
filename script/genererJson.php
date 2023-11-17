<?php
require_once('connexion.php');
$querry = 'SELECT * FROM list';
$requete = $db->prepare($querry);
$requete->execute();
$i = 0;
while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $ligne;

    $id[] = $ligne['id'];
    $image[] = $ligne['image'];
    $image_sans_lien[] = substr($ligne['image'], 6, -4);
    $titre[] = $ligne['titre'];
    $alias[] = $ligne['alias'];
    $nombre_page_lu[] = $ligne['nombre_page_lu'];
    $fini[] = $ligne['fini'];
    $ongoing[] = $ligne['ongoing'];
    $url[] = $ligne['url'];

    $arr[] = array(
        'id' => $id[$i],
        'image' => $image_sans_lien[$i],
        'titre' => $titre[$i],
        'alias' => $alias[$i],
        'nombre_page_lu' => $nombre_page_lu[$i],
        'fini' => $fini[$i],
        'ongoing' => $ongoing[$i],
        'url' => $url[$i]
    );

    $arr2[] = array(
        'id' => $id[$i],
        'image' => $image[$i],
        'titre' => $titre[$i],
        'alias' => $alias[$i],
        'nombre_page_lu' => $nombre_page_lu[$i],
        'fini' => $fini[$i],
        'ongoing' => $ongoing[$i],
        'url' => $url[$i]
    );

    $i++;
}

require_once('deconnexion.php');

$encode_donnees = json_encode($arr);
file_put_contents("../json/jsonTel.json", $encode_donnees);
$encode_donnees = json_encode($arr2);
file_put_contents("../json/jsonSearch.json", $encode_donnees);
