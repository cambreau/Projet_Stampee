import { recupererMisesParId } from "../requetes-backend.js";
import { imageZoom } from "../composant/zoom.js";
import {
  affichageMises,
  messageAucuneMise,
  creationHTMLBoutonMise,
  creationHTMLStatutTemps,
} from "../composant/mises.js";
import { statutEnchere } from "../composant/encheres.js";

async function ficheDetailEnchere() {
  // **** Variables **** //
  // FAV const boutonsFavoris = document.querySelectorAll(".alerte-ajout");
  const idEnchere = document.querySelector(".detail-timbre__mises").dataset
    .enchereId;
  const dateDebut = document.querySelector(".detail-timbre__temps").dataset
    .dateDebut;
  const dateFin = document.querySelector(".detail-timbre__temps").dataset
    .dateFin;
  const statut = statutEnchere(dateDebut, dateFin);
  let mises = await recupererMisesParId(idEnchere);
  const conteneurMises = document.querySelector(".conteneur-mises");

  // **** Logique **** //
  if (statut === "En cours") {
    //Mises
    if (mises.length == 0) {
      messageAucuneMise(conteneurMises);
    } else {
      affichageMises(mises, conteneurMises, 3);
    }
    //Bout mises:
    const sectionMiseHTML = document.querySelector(".detail-timbre__mises");
    creationHTMLBoutonMise(sectionMiseHTML);
  }
  //Mise a jour du compteur:
  const sectionTempsHTML = document.querySelector(".detail-timbre__temps");
  creationHTMLStatutTemps(sectionTempsHTML, statut, dateFin, dateDebut);

  imageZoom("myimage", "myresult");
  // boutonsFavoris.forEach((btn) => {
  //   btn.addEventListener("click", ajoutFavoris);
  // });
  // Mises.
}

const ajoutFavoris = (evenement) => {
  const idTimbre = evenement.currentTarget.dataset.timbreId;
};

// **** Execution **** //
ficheDetailEnchere();
// detail-timbre__conteneur-mises
