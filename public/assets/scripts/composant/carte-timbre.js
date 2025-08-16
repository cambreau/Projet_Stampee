import { statutEnchere } from "./encheres.js";

/** Fonction qui gere l'affichage des timbres */
export const affichageTimbres = async (listeTimbres, parent) => {
  // 1. Création de la carte pour chaque timbre
  listeTimbres.forEach((timbre) => {
    const sectionTimbre = document.createElement("a");
    sectionTimbre.classList.add("conteneur-timbres__timbre");
    sectionTimbre.href = `{{base}}/timbre/fiche-detail-timbreid={{ timbre.id }}`;
    parent.appendChild(sectionTimbre);
    // Création des elements de la carte
    imageTimbre(timbre["principale"]["lien"], timbre["nom"], sectionTimbre);
    titreTimbre(timbre["nom"], sectionTimbre);
    basTimbreProfil(timbre, sectionTimbre);
  });
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
  console.log(timbreLien);
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
 * Fonction pour créer le bas de la carte timbre
 * @param {Object} timbre
 * @param {HTMLElement} section
 */
const basTimbreProfil = (timbre, section) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  footer.classList.add("conteneur-timbres__timbre__bas-carte-profil");

  // Création du statut de l'enchere.
  const statutValeur = statutEnchere(
    timbre["encheres"]["dateDebut"],
    timbre["encheres"]["dateFin"]
  );
  const statut = document.createElement("p");
  statut.classList.add("conteneur-timbres__timbre__bas-carte-profil__statut");
  statut.textContent = statutValeur;
  statut.style.color = "#ffffff";

  // Appliquer le style de fond selon le statut
  if (statutValeur === "À venir") {
    footer.style.background = "#10974b";
  } else if (statutValeur === "En cours") {
    footer.style.background = "#a52a2a";
  } else if (statutValeur === "Terminée - Non vendu") {
    footer.style.background = "#4d4f54";
  }

  section.appendChild(footer);
  footer.appendChild(statut);
};
