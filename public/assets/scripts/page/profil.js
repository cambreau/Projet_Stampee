import {
  timbresParMembreId,
  recupererEncheresFavorites,
} from "../requetes-backend.js";
import { affichageTimbre } from "../composant/carte-timbre.js";
import { statutEnchere } from "../composant/encheres.js";
import { Catalogue } from "../composant/catalogue.js";

async function profilInit() {
  // **** Variables **** //
  const timbres = await timbresParMembreId();
  const conteneurTimbre = document.querySelector(".timbre-profil");
  const favoris = await recupererEncheresFavorites();
  const conteneurFavoris = document.querySelector(".favoris-profil");

  // **** Logique **** //
  if (timbres.length !== 0) {
    // Console.log montre timbres =[] lorsqu'il n'y a rien dans la BD.
    timbres.forEach((timbre) => {
      affichageTimbre(
        timbre,
        null,
        conteneurTimbre,
        particularitesTimbreProfil
      );
    });
  } else {
    messageInformation(conteneurTimbre, "Vous n'avez pas encore de timbre");
  }

  if (favoris.length !== 0) {
    console.log(favoris);
    const catalogueFav = new Catalogue(favoris, conteneurFavoris);
    catalogueFav.affichageSectionTimbres();
  } else {
    messageInformation(conteneurFavoris, "Vous n'avez pas encore de favoris");
  }
}

/**
 * Fonction qui affiche un message a l'utilisateur pour l'informer qu'il n'a pas encore de timbres
 */
const messageInformation = (conteneurTimbre, message) => {
  const div = document.createElement("div");
  conteneurTimbre.appendChild(div);
  div.classList.add("message__information__conteneur");
  const picture = document.createElement("picture");
  div.appendChild(picture);
  picture.classList.add("message__information__image");
  const img = document.createElement("img");
  img.src = "/public/assets/images/timbre.png";
  img.alt = "Illustration d'un timbre";
  picture.appendChild(img);
  const p = document.createElement("p");
  p.textContent = message;
  div.appendChild(p);
  p.classList.add("message__contenu");
  //Modifier le css du conteneur timbre
  conteneurTimbre.style.display = "flex";
};

/**
 * Fonction qui gère l’appel des fonctions liées à la page profil pour l’affichage des timbres.
 * @param {Array} infoTimbre
 * @param {HTMLElement} parent
 */
const particularitesTimbreProfil = (infoTimbre, enchere = null, parent) => {
  basCarteTimbreProfil(infoTimbre, parent);
  boutonModifSupprimer(infoTimbre, parent);
};

/**
 * Fonction pour créer le bas de la carte timbre
 * @param {Object} timbre
 * @param {HTMLElement} parent
 */
const basCarteTimbreProfil = (timbre, parent) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  parent.appendChild(footer);
  footer.classList.add("conteneur-timbres__timbre__bas-carte");

  // Création du statut de l'enchere.
  let statutValeur;
  if (timbre.encheres.length > 0) {
    statutValeur = statutEnchere(
      timbre["encheres"][0]["dateDebut"],
      timbre["encheres"][0]["dateFin"]
    );
  } else {
    statutValeur = "Aucune enchère";
  }

  if (statutValeur == "En cours") {
    const btnEnchere = document.createElement("a");
    footer.appendChild(btnEnchere);
    btnEnchere.textContent = "Voir l’enchère";
    btnEnchere.classList.add("bouton");
    btnEnchere.classList.add("bouton-accent");
    btnEnchere.href = `/enchere/fiche-detail-enchere?id=${timbre["id"]}`;
  } else {
    const statut = document.createElement("p");
    footer.appendChild(statut);
    statut.classList.add("conteneur-timbres__timbre__bas-carte__statut");
    statut.textContent = statutValeur;
    // Appliquer le style de fond selon le statut
    if (statutValeur === "À venir") {
      footer.style.background = "#b3ddc5";
    } else {
      footer.style.background = " #adb2bd";
    }
  }
};

/** Fonction qui créer le conteneur et les boutons modifier et supprimer
 * @param {HTMLElement}
 */
const boutonModifSupprimer = (timbre, parent) => {
  const btnConteneur = document.createElement("div");
  btnConteneur.classList.add("bouton-haut-droite__conteneur");
  parent.appendChild(btnConteneur);

  const btnModifierLien = document.createElement("a");
  btnModifierLien.href = `/timbre/page-modifier?id=${timbre["id"]}`;
  btnModifierLien.classList.add("bouton-haut-droite");
  btnModifierLien.classList.add("classique");
  btnConteneur.appendChild(btnModifierLien);
  const btnModifier = document.createElement("img");
  btnModifier.src = `/public/assets/images/icon/modifier.png`;
  btnModifier.alt = `Icon modifier`;
  btnModifierLien.appendChild(btnModifier);

  const btnSupprimerLien = document.createElement("a");
  btnSupprimerLien.href = `/timbre/supprimer?id=${timbre["id"]}`;
  btnConteneur.appendChild(btnSupprimerLien);
  btnSupprimerLien.classList.add("bouton-haut-droite");
  btnSupprimerLien.classList.add("accent");
  const btnSupprimer = document.createElement("img");
  btnSupprimer.src = `/public/assets/images/icon/supprimer.png`;
  btnSupprimer.alt = `Icon supprimer`;
  btnSupprimerLien.appendChild(btnSupprimer);
};

// **** Execution **** //
profilInit();
