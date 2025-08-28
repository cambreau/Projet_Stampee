import { statutEnchere, calculTempsRestant } from "./encheres.js";
import { formatDateTime } from "./date.js";
import { gestionFavoris } from "../composant/favoris.js";
import { recupererSession } from "../requetes-backend.js";

/** Fonction qui gere l'affichage des timbres */
export const affichageTimbre = async (
  timbre,
  enchere = null,
  parent,
  particularitesTimbre
) => {
  // 1. Création de la carte pour chaque timbre
  const sectionTimbre = document.createElement("section");
  sectionTimbre.classList.add("conteneur-timbres__timbre");
  parent.appendChild(sectionTimbre);
  // Création des elements de la carte
  imageTimbre(timbre["principale"]["lien"], timbre["nom"], sectionTimbre);
  titreTimbre(timbre["nom"], sectionTimbre);
  particularitesTimbre(timbre, enchere, sectionTimbre);
  badgeFavCoupCoeur(enchere, sectionTimbre);
};

/** Fonction pour créer l'image du timbre
 * @param {Object} timbre - L'objet représentant le timbre
 * @param {HTMLElement} section - L'élément parent dans lequel ajouter l'image
 */
const imageTimbre = (timbreLien, timbreNom, section) => {
  const picture = document.createElement("picture");
  picture.classList.add("conteneur-timbres__timbre__image");
  section.appendChild(picture);
  const img = document.createElement("img");
  img.src = `/public/assets/images/images-timbre/${timbreLien}`;
  img.alt = `Image principale du timbre : ${timbreNom}`;
  picture.appendChild(img);
};

/** Fonction pour créer le titre du timbre
 * @param {Object} timbre - L'objet représentant le timbre
 * @param {HTMLElement} section - L'élément parent dans lequel ajouter le titre
 */
const titreTimbre = (timbreNom, section) => {
  const titre = document.createElement("h3");
  titre.textContent = `${timbreNom}`;
  titre.classList.add("conteneur-timbres__timbre__titre");
  section.appendChild(titre);
};

/**
 * Fonction pour créer le bas de la carte enchere
 * @param {Object} timbre
 * @param {HTMLElement} parent
 */
export const basCarteEnchere = (timbre, enchere, parent) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  footer.classList.add("conteneur-timbres__timbre__bas-carte");
  parent.appendChild(footer);
  // Statut de l'enchere et temps restant:
  const dates = document.createElement("p");
  dates.textContent = `Du ${formatDateTime(
    enchere["dateDebut"]
  )} au ${formatDateTime(enchere["dateFin"])}`;
  dates.classList.add(
    "conteneur-timbres__timbre__bas-carte-enchere__prix-dates"
  );
  const statutValeur = statutEnchere(enchere["dateDebut"], enchere["dateFin"]);
  footer.appendChild(dates);
  const statut = document.createElement("p");
  footer.appendChild(statut);
  statut.classList.add("detail-timbre__compteur");
  const statutEnchereLabel = document.createElement("span");
  statut.appendChild(statutEnchereLabel);

  if (statutValeur === "En cours") {
    // affichage immédiat
    statut.textContent = `Temps restant: ${calculTempsRestant(
      enchere["dateFin"]
    )}`;
    // Mise à jour toutes les secondes
    const chrono = setInterval(() => {
      statut.textContent = `Temps restant : ${calculTempsRestant(
        enchere["dateFin"]
      )}`;
    }, 1000);
  } else {
    statut.textContent = statutValeur;
  }

  const prixEnchere = document.createElement("p");
  footer.appendChild(prixEnchere);
  prixEnchere.classList.add(
    "conteneur-timbres__timbre__bas-carte-enchere__prix-dates"
  );
  const prixEnchereLabel = document.createElement("span");
  prixEnchere.appendChild(prixEnchereLabel);
  prixEnchereLabel.textContent =
    statutValeur !== "Terminée" ? "Prix plancher :" : null;
  const prixEnchereValeur = document.createTextNode(
    ` ${enchere["prixPlancher"]} CAD`
  );
  prixEnchere.appendChild(prixEnchereValeur);

  if (statutValeur == "En cours") {
    const btnEnchere = document.createElement("a");
    btnEnchere.textContent = "Voir l’enchère";
    btnEnchere.classList.add("bouton");
    btnEnchere.classList.add("bouton-accent");
    btnEnchere.href = `/enchere/fiche-detail-enchere?id=${timbre["id"]}`;
    footer.appendChild(btnEnchere);
  }
};

/** Fonction badge coup de coeur et favoris */
export const badgeFavCoupCoeur = async (enchere, parent) => {
  if (enchere["coupCoeurLord"] === 1 || enchere["favoris"] === 1) {
    const divBadge = document.createElement("div");
    divBadge.classList.add("badges");
    parent.appendChild(divBadge);
    if (enchere["coupCoeurLord"] === 1) {
      const badgeCCL = document.createElement("pciture");
      badgeCCL.classList.add("icon_grand");
      divBadge.appendChild(badgeCCL);
      const imgCCL = document.createElement("img");
      imgCCL.src = "/public/assets/images/icon/badgeCcl.svg";
      imgCCL.alt = "Icon pour coup de coeur du Lord";
      imgCCL.classList.add("img");
      badgeCCL.appendChild(imgCCL);
    }

    const session = await recupererSession();
    if (session.length !== 0) {
      let btnFav = document.createElement("picture");
      btnFav.classList.add("icon_grand", "icon-hover-agrandit");
      divBadge.appendChild(btnFav);

      btnFav.addEventListener("click", gestionFavoris);

      let imgFav = document.createElement("img");
      imgFav.classList.add("img");
      btnFav.appendChild(imgFav);

      btnFav.dataset.idEnchere = enchere["id"];

      console.log(enchere);
      // configurer l'image selon l'état favoris
      if (enchere["favoris"] === 1) {
        btnFav.dataset.gestionFavoris = "supprimer";
        imgFav.src = "/public/assets/images/icon/suppr-fav.svg";
        imgFav.alt = "Icône pour supprimer un favori";
      } else {
        btnFav.dataset.gestionFavoris = "ajout";
        imgFav.src = "/public/assets/images/icon/ajout-fav.svg";
        imgFav.alt = "Icône pour ajouter un favori";
      }
    }
  }
};
