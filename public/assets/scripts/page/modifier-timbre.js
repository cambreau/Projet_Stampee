import { supprimerImageBD } from "../requetes-backend.js";

function modifierTimbreInit() {
  const boutonImageTimbreHTML = document.querySelectorAll(
    ".form__visuel-image .bouton-haut-droite__conteneur .bouton-haut-droite"
  );

  boutonImageTimbreHTML.forEach((bouton) => {
    bouton.addEventListener("click", supprimerImageTimbreBD);
  });
}

/**
 * Fonction qui appel une requete pour supprimer une image dans la BD.
 * @param {Event} evenement
 */
const supprimerImageTimbreBD = (evenement) => {
  const idImage = evenement.currentTarget.dataset.imageId;
  const imageHTML = evenement.currentTarget.closest(".form__visuel-image");
  console.log(idImage);
  supprimerImageBD(idImage, imageHTML);
};

// **** Execution **** //
modifierTimbreInit();
