<?php
if (!empty($_POST['idElementModifier']) && ctype_digit($_POST['idElementModifier'])) {
    require_once('connexion.php');

    $querry = 'SELECT * FROM list WHERE id = :idElementModifier';
    $requete = $db->prepare($querry);
    $requete->execute([
        'idElementModifier' => $_POST['idElementModifier'],
    ]);
    $resultatAfficherModifier = $requete->fetch();


    $resultatAfficherModifierTitre = $resultatAfficherModifier['titre'];
    $resultatAfficherModifierAlias = $resultatAfficherModifier['alias'];
    $resultatAfficherModifierCheminImage = $resultatAfficherModifier['image'];
    $resultatAfficherModifierNombrePageLu = $resultatAfficherModifier['nombre_page_lu'];
    $resultatAfficherModifierFini = $resultatAfficherModifier['fini'];
    $resultatAfficherModifierOngoing = $resultatAfficherModifier['ongoing'];
    $resultatAfficherModifierUrl = $resultatAfficherModifier['url'];

    require_once('deconnexion.php');

    $arr = array(
        'resultatAfficherModifierTitre' => $resultatAfficherModifierTitre,
        'resultatAfficherModifierAlias' => $resultatAfficherModifierAlias,
        'resultatAfficherModifierCheminImage' => $resultatAfficherModifierCheminImage,
        'resultatAfficherModifierNombrePageLu' => $resultatAfficherModifierNombrePageLu,
        'resultatAfficherModifierFini' => $resultatAfficherModifierFini,
        'resultatAfficherModifierOngoing' => $resultatAfficherModifierOngoing,
        'resultatAfficherModifierUrl' => $resultatAfficherModifierUrl
    );
    echo json_encode($arr);
}
