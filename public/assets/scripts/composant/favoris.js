import {
  ajoutTimbreFavoris,
  supprimerTimbreFavoris,
} from "../requetes-backend.js";

/* Ref: https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/Array/some */
export const estFavoris = (enchere, arrayFavoris) => {
  return arrayFavoris.some((fav) => fav.Enchere_id === enchere.id);
};

export const gestionFavoris = (evenement) => {
  const picture = evenement.currentTarget;
  const action = picture.dataset.gestionFavoris;
  const enchereId = picture.dataset.idEnchere;
  const imgFav = picture.querySelector("img");

  if (action === "ajout") {
    ajoutTimbreFavoris(enchereId);
    picture.dataset.gestionFavoris = "supprimer";
    imgFav.src = "/public/assets/images/icon/suppr-fav.svg";
    imgFav.alt = "Icône pour Favoris";
  } else if (action === "supprimer") {
    supprimerTimbreFavoris(enchereId);
    picture.dataset.gestionFavoris = "ajout";
    imgFav.src = "/public/assets/images/icon/ajout-fav.svg";
    imgFav.alt = "Icône pour ajouter un favori";
  }
};
