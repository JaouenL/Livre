<?php
require_once('connexion.php');

$option = isset($_COOKIE["filtreSelect"]) ? $_COOKIE["filtreSelect"] : false;
$selectedFilter = $option;

if ($selectedFilter == "fini") {
    $query = 'SELECT image, titre, nombre_page_lu, fini, ongoing FROM `list` WHERE fini="O" LIMIT :limite OFFSET :debut';
    $totalParam = 'WHERE fini="O"';
} else if ($selectedFilter == "pas fini") {
    $query = 'SELECT image, titre, nombre_page_lu, fini, ongoing FROM `list` WHERE fini="N" LIMIT :limite OFFSET :debut';
    $totalParam = 'WHERE fini="N"';
} else {
    $query = 'SELECT image, titre, nombre_page_lu, fini, ongoing FROM `list` LIMIT :limite OFFSET :debut';
    $totalParam = "";
}

$resultat = $totalParam == "" ? $db->query('SELECT count(id) FROM `list`') : $db->query('SELECT count(id) FROM `list` ' . $totalParam . '');
$limite = 50;
$nombredElementsTotal = $resultat->fetchColumn();

if ($nombredElementsTotal <= 50) {
    $_GET['page'] = 1;
    echo '<script>window.history.replaceState("", "", "http://localhost:8081/PourGit/Livre/?page=1") </script>';
}
$nombreDePages = ceil($nombredElementsTotal / $limite);

$page = (!empty($_GET['page']) ? $_GET['page'] : 1);

$debut = ($page - 1) * $limite;

$query = $db->prepare($query);
$query->bindValue('debut', $debut, PDO::PARAM_INT);
$query->bindValue('limite', $limite, PDO::PARAM_INT);
$query->execute();

require_once('deconnexion.php');
