<?php
require_once('script/pagination.php')
?>

<!DOCTYPE html>
<html>

<head>
	<title>MML</title>
	<link rel="icon" href="icons/mml.ico" type="image/x-icon" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="styles/styles.css">

	<script src="script/jquery-3.6.0.min.js"></script>
	<script type="module" src="script/COOKIE/node_modules/js-cookie/dist/js.cookie.mjs"></script>
	<script nomodule defer src="script/COOKIE/node_modules/js-cookie/dist/js.cookie.js"></script>
</head>

<body>
	<div>
		<div id="add-area">
			<div class="row-1">
				<div class="box">
					<div> <span>Titre</span> </div>
					<div id="titre-input">
						<input list="titres" name="titre" id="titre" autocomplete="off" required>
						<button id="clear-icon-2" type="button">
							<img src="icons/clear-button.png" class="icon-clear" alt="clear button"></button>
						<datalist id="titres">
							<?php
							require('script/connexion.php');
							$resultat = $db->query('SELECT titre FROM list');
							while ($ligne = $resultat->fetch()) {
								echo "<option> " . $ligne['titre'] . " </option>";
							}
							require('script/deconnexion.php');
							?>
						</datalist>
					</div>
				</div>

				<div id="alias-boutton"><button type="button" id="plus"></button></div>

				<div class="box left-space">
					<div id="nombre-page-lu-description"> <span>Nombre page lu</span> </div>
					<div> <input type="number" step="any" min=0 id="nombre-page-lu" value="0"> </div>
				</div>
				<div class="box left-space">
					<div class="fini-description"> <span>Fini</span> </div>
					<div> <input type="text" id="fini"> </div>
				</div>
				<div class="box left-space">
					<div> <span>Ongoing</span> </div>
					<div> <input type="text" id="ongoing"> </div>
				</div>
				<div class="box left-space">
					<div id="url_description"> <span>URL</span> </div>
					<div id="url_input"> <input type="url" id="url"> </div>
				</div>

				<div class="boutton">
					<button type="button" id="ajouter">Ajouer</button>
					<button type="button" id="supprimer">Supprimer</button>
				</div>
			</div>

			<div class="box hidden" id="alias-box">
				<div> <span>Alias</span> </div>
				<div> <input type="text" id="alias"> </div>
			</div>

			<div class="row-1">
				<div class="box">
					<div> <span>Titre</span> </div>
					<div id="titre_input_modifier2">
						<input type="text" name="titre" autocomplete="off" required id="titre-input-list">
						<button id="clear-icon" type="button">
							<img src="icons/clear-button.png" class="icon-clear" alt="clear button">
						</button>
						<div id="resultat-recherche" class="visually-hidden">
							<ul id="search_display_id" class="search_display"></ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row-1">
				<div class="box">
					<div id="titre_description_modifier"> <span>Titre modifier</span> </div>
					<div id="titre_input_modifier"> <input type="text" name="titre" autocomplete="off" id="titre-input-list-modifier"> </div>
				</div>

				<div class="box left-space">
					<div id="chemin-image-description"> <span>Chemin image</span> </div>
					<div id="chemin-image-input"> <input type="text" id="chemin-image"> </div>
				</div>

				<div class="box left-space">
					<div id="nombre-page-lu-description-modifier"> <span>Nombre page lu</span> </div>
					<div> <input type="number" step="any" min=0 id="nombre_page_lu_modifier"> </div>
				</div>

				<div class="box left-space">
					<div class="fini-description"> <span>Fini</span> </div>
					<div> <input type="text" id="fini-modifier"> </div>
				</div>

				<div class="box left-space">
					<div> <span>Ongoing</span> </div>
					<div> <input type="text" id="ongoing-modifier"> </div>
				</div>

				<div class="boutton">
					<button type="button" id="modifier">Modifier</button>
				</div>
			</div>

			<div class="row-1">
				<div class="box">
					<div> <span>Alias</span> </div>
					<div> <input type="text" id='alias-modifier'> </div>
				</div>
				<div class="box left-space">
					<div id="url_description_modifier"> <span>URL</span> </div>
					<div id="url_input_modifier"> <input type="text" class="url" id='url_modifier'> </div>
				</div>
				<div id="boutton-dump">
					<button type="button" id="dump">DUMP</button>
					<span id="last-dump">
						<?php
						if (isset($_COOKIE["last_dump_livre"])) {
							echo ($_COOKIE["last_dump_livre"]);
						} else {
							echo "+30 jours";
						}
						?>
					</span>
				</div>
				<div id="boutton-json">
					<button type="button" id="json">JSON</button>
				</div>
			</div>

			<div class="info-box hidden info-box-postion" id="box">
				<div class="box-info">
					<p>Ok!</p>
				</div>
			</div>
			<div class="info-box hidden info-box-postion-2" id="box2">
				<div class="box-info">
					<p>Ok!</p>
				</div>
			</div>
		</div>

		<nav class="pagination">
			<?php
			if ($page > 1) :
			?>
				<a href="?page=<?php echo 1; ?>">&laquo;</a>
				<a href="?page=<?php echo $page - 1; ?>">&lsaquo;</a>
			<?php
			endif;

			for ($i = 1; $i <= $nombreDePages; $i++) :
			?>
				<a <?php if ($page == $i) {
						echo 'class="page-actuelle"';
					} ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
			endfor;

			if ($page < $nombreDePages) :
			?>
				<a href="?page=<?php echo $page + 1; ?>">&rsaquo;</a>
				<a href="?page=<?php echo $nombreDePages; ?>">&raquo;</a>
			<?php
			endif;
			?>
		</nav>

		<div id="filtre-box">
			<hr style="margin-right: 0;">

			<?php
			if (!isset($_COOKIE["filtreSelect"])) {
				$_COOKIE["filtreSelect"] = "tout";
			}
			echo "
	<form method='POST' id='formFiltre' action=''>
		<select name='filtre' onchange=filter(this.value)>
			<option " . (($_COOKIE["filtreSelect"] == "tout") ? "selected " : "") . " value='tout'>Tout</option>
			<option " . (($_COOKIE["filtreSelect"] == "fini") ? "selected " : "") . "value='fini'>Fini</option>
			<option " . (($_COOKIE["filtreSelect"] == "pas fini") ? "selected " : "") . "value='pas fini'>Pas Fini</option>
		</select>
	</form>";
			?>

			<hr style="margin-left: 0;">
		</div>

		<div id="contenu">
			<?php
			require_once('script/affichageMain.php')
			?>
		</div>

		<hr>

		<nav class="pagination">
			<?php
			if ($page > 1) :
			?>
				<a href="?page=<?php echo 1; ?>">&laquo;</a>
				<a href="?page=<?php echo $page - 1; ?>">&lsaquo;</a>
			<?php
			endif;

			for ($i = 1; $i <= $nombreDePages; $i++) :
			?>
				<a <?php if ($page == $i) {
						echo 'class="page-actuelle"';
					} ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
			endfor;

			if ($page < $nombreDePages) :
			?>
				<a href="?page=<?php echo $page + 1; ?>">&rsaquo;</a>
				<a href="?page=<?php echo $nombreDePages; ?>">&raquo;</a>
			<?php
			endif;
			?>
		</nav>

		<div id="to-top" class="to-top"></div>
	</div>
	<script type="text/javascript" src="script/script.js"></script>
</body>

</html>