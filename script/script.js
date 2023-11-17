const btnAjouter = document.getElementById("ajouter");
btnAjouter.addEventListener("click", ajouter);

function ajouter() {
	if (document.getElementById("titre").value == "") {
		alert("Titre manquant");
		return;
	} else {
		titre = document.getElementById("titre").value;
	}

	chemin_image = document.getElementById("titre").value;
	chemin_image = chemin_image.replace("-", "_");
	chemin_image = chemin_image.replace(".", "");
	chemin_image = chemin_image.replace(",", "");
	chemin_image = chemin_image.replace("'", "_");
	chemin_image = chemin_image.replace(":", "");
	chemin_image = chemin_image.replace("?", "");
	chemin_image = chemin_image.replace("!", "");
	chemin_image = chemin_image.replace("~", "");
	chemin_image = chemin_image.replace(/\s+/g, "_");
	chemin_image = chemin_image.replace(/(_)\1{1,}/g, "_");
	chemin_image = chemin_image.toLowerCase();
	chemin_image = "Image/" + chemin_image + ".webp";

	nombre_page_lu = document.getElementById("nombre-page-lu").value;

	if (document.getElementById("fini").value == "" || (document.getElementById("fini").value != "O" && document.getElementById("fini").value != "N")) {
		alert("Erreur pour le champ fini");
		return;
	} else {
		fini = document.getElementById("fini").value;
	}

	if (document.getElementById("ongoing").value == "" || (document.getElementById("ongoing").value != "O" && document.getElementById("ongoing").value != "N")) {
		alert("Erreur pour le champ ongoing");
		return;
	} else {
		ongoing = document.getElementById("ongoing").value;
	}

	url = document.getElementById("url").value;

	alias = document.getElementById("alias").value;

	$.ajax({
		type: "POST",
		url: "script/ajouter.php",
		data: {
			chemin_image: chemin_image,
			titre: titre,
			alias: alias,
			nombre_page_lu: nombre_page_lu,
			fini: fini,
			ongoing: ongoing,
			url: url,
		},

		success: function (output) {
			gestionErreur(output, "ajouter");
		},
		error: function () {
			alert("Erreur requête ajouter");
		},
	});
}

const btnSupprimer = document.getElementById("supprimer");
btnSupprimer.addEventListener("click", supprimer);

function supprimer() {
	if (document.getElementById("titre").value == "") {
		document.getElementById("titre").classList.toggle("champ-erreur");
		return;
	} else {
		titre = document.getElementById("titre").value;
	}

	$.ajax({
		type: "POST",
		url: "script/supprimer.php",
		data: { titre: titre },

		success: function (output) {
			gestionErreur(output, "supprimer");
		},
		error: function () {
			alert("Erreur requête");
		},
	});
}

function mouseover(event) {
	let selection = document.getElementById(event);
	selection.classList.add("selected");
}

function mouseout(event) {
	let selection = document.getElementById(event);
	selection.classList.remove("selected");
}

function search(event) {
	if (event != "") {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "script/afficherElementModifier.php",
			data: { idElementModifier: event },

			success: function (resultSucces, output) {
				var resultatAfficherModifierTitre = resultSucces.resultatAfficherModifierTitre;
				var resultatAfficherModifierAlias = resultSucces.resultatAfficherModifierAlias;
				var resultatAfficherModifierCheminImage = resultSucces.resultatAfficherModifierCheminImage;
				var resultatAfficherModifierNombrePageLu = resultSucces.resultatAfficherModifierNombrePageLu;
				var resultatAfficherModifierFini = resultSucces.resultatAfficherModifierFini;
				var resultatAfficherModifierOngoing = resultSucces.resultatAfficherModifierOngoing;
				var resultatAfficherModifierUrl = resultSucces.resultatAfficherModifierUrl;

				document.getElementById("titre-input-list").value = resultatAfficherModifierTitre;
				document.getElementById("titre-input-list-modifier").value = resultatAfficherModifierTitre;
				document.getElementById("alias-modifier").value = resultatAfficherModifierAlias;
				document.getElementById("chemin-image").value = resultatAfficherModifierCheminImage;
				document.getElementById("nombre_page_lu_modifier").value = resultatAfficherModifierNombrePageLu;
				document.getElementById("fini-modifier").value = resultatAfficherModifierFini;
				document.getElementById("ongoing-modifier").value = resultatAfficherModifierOngoing;
				document.getElementById("url_modifier").value = resultatAfficherModifierUrl;
				gestionErreur(output, "search");
			},
			error: function () {
				alert("Erreur inconnu");
			},
		});
	}
}

document.getElementById("titre-input-list").addEventListener("focusout", function () {
	var who = document.getElementById("resultat-recherche");
	if (who.classList.contains("visually-visible")) {
		who.classList.remove("visually-visible");
		who.classList.add("visually-hidden");
	}
});

document.getElementById("titre_input_modifier2").addEventListener("focusin", function () {
	let who = document.getElementById("resultat-recherche");
	if (who.classList.contains("visually-hidden")) {
		who.classList.remove("visually-hidden");
		who.classList.add("visually-visible");
	}
});

document.getElementById("titre_input_modifier2").addEventListener("keyup", function () {
	var titreElementModifierLength = document.getElementById("titre-input-list").value.length;
	if (titreElementModifierLength < 3) {
		return;
	}

	var titreElementModifier = document.getElementById("titre-input-list").value;

	var requestURL = "http://localhost:8081/PourGit/Livre/Json/jsonSearch.json";
	var request = new XMLHttpRequest();
	request.open("GET", requestURL);
	request.responseType = "json";
	request.send();
	request.onload = function () {
		var jsonResponse = request.response;
		var li_search = "";
		titreJson = [];
		aliasJson = [];
		titreJsonMatch = [];
		aliasJsonMatch = [];

		for (var i = 0; i < jsonResponse.length; i++) {
			titreJson[i] = jsonResponse[i].titre.toLowerCase();
			aliasJson[i] = jsonResponse[i].alias.toLowerCase();
		}
		regex = titreElementModifier.toLowerCase();
		var y = 0;

		for (var i = 0; i < titreJson.length; i++) {
			if (titreJson[i].match(regex)) {
				titreJsonMatch[y] = titreJson[i];
				y++;
			} else if (aliasJson[i].match(regex)) {
				aliasJsonMatch[y] = aliasJson[i];
				y++;
			}
		}

		titreLength = titreJsonMatch.length;
		aliasLength = aliasJsonMatch.length;

		if (regex.length) {
			for (var i = 0; i < jsonResponse.length; i++) {
				if (jsonResponse[i].titre.toLowerCase().match(regex) || jsonResponse[i].alias.toLowerCase().match(regex)) {
					li_search +=
						'<li onclick="search(' +
						jsonResponse[i].id +
						');" onmouseover="mouseover(' +
						jsonResponse[i].id +
						');" onmouseout="mouseout(' +
						jsonResponse[i].id +
						');" id="' +
						jsonResponse[i].id +
						'" ><img class="search-img" src="' +
						jsonResponse[i].image +
						'" /><div class="search-text-container"><p class="search-title">' +
						jsonResponse[i].titre +
						"</p></div></li>";
				}
			}
		}
		// ? fonctionne ?
		// ? !li_search.length
		if (!li_search.length) {
			li_search += '<li><div class="search-text-container"><p class="search-title">No search results</p></div></li>';
		}
		$(".search_display").empty().prepend(li_search);
	};
});

const btnModifier = document.getElementById("modifier");
btnModifier.addEventListener("click", modifier);

function modifier() {
	if (document.getElementById("titre-input-list").value == "") {
		document.getElementById("titre_inout_list").classList.toggle("champ-erreur");
		return;
	} else {
		titre = document.getElementById("titre-input-list").value;

		alias = document.getElementById("alias-modifier").value;

		titre_modifier = document.getElementById("titre-input-list-modifier").value;

		chemin_image = document.getElementById("chemin-image").value;

		nombre_page_lu = document.getElementById("nombre_page_lu_modifier").value;

		fini = document.getElementById("fini-modifier").value;

		ongoing = document.getElementById("ongoing-modifier").value;

		url = document.getElementById("url_modifier").value;

		document.getElementById("json").style.color = "red";

		$.ajax({
			type: "POST",
			url: "script/modifier.php",
			data: {
				titre: titre,
				alias: alias,
				titre_modifier: titre_modifier,
				chemin_image: chemin_image,
				nombre_page_lu: nombre_page_lu,
				fini: fini,
				ongoing: ongoing,
				url: url,
			},

			success: function (output) {
				document.getElementById("titre-input-list").value = "";
				gestionErreur(output, "modifier");
			},
			error: function () {
				alert("Erreur modification");
			},
		});
	}
}

const btnJson = document.getElementById("json");
btnJson.addEventListener("click", jsonCreate);

function jsonCreate() {
	$.ajax({
		url: "script/genererJson.php",

		success: function (output) {
			gestionErreur(output, "json");
			document.getElementById("box").classList.toggle("hidden");
			document.getElementById("box").classList.toggle("visible-height-40");
			setTimeout(boxInfoAction, 2000, "box");
			btnJson.style.color = "black";
		},

		error: function () {
			alert("Erreur");
		},
	});
}

const btnAlias = document.getElementById("alias-boutton");
btnAlias.addEventListener("click", aliasShow);

function aliasShow() {
	let addArea = document.getElementById("add-area");
	let alias_box = document.getElementById("alias-box");

	document.getElementById("plus").classList.toggle("rotate");

	if (alias_box.classList.contains("hidden")) {
		alias_box.classList.remove("hidden");
		alias_box.classList.add("visually-visible");
		addArea.style.height = "220px";
	} else {
		alias_box.classList.add("hidden");
		alias_box.classList.remove("visually-visible");
		addArea.style.height = "175px";
	}
}

window.addEventListener("scroll", function () {
	let box = document.getElementById("to-top");
	if (window.scrollY > 0) {
		box.classList.add("visible-height-40");
	} else if (window.scrollY === 0) {
		box.classList.remove("visible-height-40");
	}
});

$("#to-top").on("click", function () {
	window.scrollTo({ top: 0, behavior: "smooth" });
});

const btnClear = document.getElementById("clear-icon");
btnClear.addEventListener("click", function () {
	clearCross(btnClear);
});
const btnClear2 = document.getElementById("clear-icon-2");
btnClear2.addEventListener("click", function () {
	clearCross(btnClear2);
});

function clearCross(btnId) {
	e = $(btnId).siblings("input")[0];
	e.value = "";
	var who = document.getElementById("resultat-recherche");
	if (who.classList.contains("visually-visible")) {
		who.classList.remove("visually-visible");
		who.classList.add("visually-hidden");
	}
}

const btnDump = document.getElementById("dump");
btnDump.addEventListener("click", dumpDb);

function dumpDb() {
	fetch("script/dump.php")
		.then((response) => response.json())
		.then((data) => (document.getElementById("last-dump").textContent = data.date));

	document.getElementById("box2").classList.toggle("hidden");
	document.getElementById("box2").classList.toggle("visible-height-40");
	setTimeout(boxInfoAction, 2000, "box2");
}

function gestionErreur(erreur, origine) {
	let errorToFind = ["exception", "error", "warning"];
	if (errorToFind.some((i) => erreur.toLowerCase().includes(i))) {
		alert(
			erreur
				.replace(/<b>/g, "")
				.replace(/<\/b>/g, "")
				.replace(/<br \/>/g, "")
		);
	} else if (origine == "search") {
		return;
	} else if (origine == "json") {
		return;
	} else {
		alert("Requête " + origine + " effectuée");
	}
}

const input = document.querySelectorAll("input");
input.forEach((eachInput) => {
	eachInput.addEventListener("input", inputCouleur);
});

function inputCouleur() {
	if (this.classList.contains("champ-erreur")) {
		this.classList.toggle("champ-erreur");
	}
}

function boxInfoAction(boxId) {
	document.getElementById(boxId).classList.toggle("hidden");
	document.getElementById(boxId).classList.toggle("visible-height-40");
}

function filter(opt) {
	document.cookie = "filtreSelect=" + opt + "; SameSite=Strict; Secure";
	$("#formFiltre").submit();
}
