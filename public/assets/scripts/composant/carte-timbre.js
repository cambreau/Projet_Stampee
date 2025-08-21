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
