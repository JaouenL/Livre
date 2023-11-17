<?php
while ($ligne = $query->fetch()) {
	echo '<div class="conteneur">
			 <div class="afficher-image"> <img src=' . htmlspecialchars($ligne['image']) . ' itemprop="image" onerror="this.onerror=null;this.src=' . "'Image/404_mml.webp'" . ';" alt="affiche"> ' . '</div>' .
		'<div class="afficher-titre"> <span class="centrer-info">' . htmlspecialchars($ligne['titre']) . '</span> </div>' .
		'<div class="afficher-nombre-page-lu"> <span class="centrer-info">' . htmlspecialchars($ligne['nombre_page_lu']) . '</span> </div>' .
		'<div class="afficher-fini"> <span class="centrer-info">' . htmlspecialchars($ligne['fini']) . '</span> </div>' .
		'<div class="afficher-ongoing"> <span class="centrer-info">' . htmlspecialchars($ligne['ongoing']) . '</span> </div>' .
		'</div>';
}
