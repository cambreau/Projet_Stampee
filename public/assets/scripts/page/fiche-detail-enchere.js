import { recupererMisesParId } from "../requetes-backend.js";
import { imageZoom } from "../composant/zoom.js";
import {
  affichageMises,
  messageAucuneMise,
  creationHTMLBoutonMise,
} from "../composant/mises.js";
import { statutEnchere, calculTempsRestant } from "../composant/encheres.js";

async function ficheDetailEnchere() {
  // **** Variables **** //
  const boutonsFavoris = document.querySelectorAll(".alerte-ajout");
  const idEnchere = document.querySelector(".btn-mise").dataset.enchereId;
  const dateDebut = document.querySelector(".detail-timbre__temps").dataset
    .dateDebut;
  const dateFin = document.querySelector(".detail-timbre__temps").dataset
    .dateFin;
  const statut = statutEnchere(dateDebut, dateFin);
  let mises = await recupererMisesParId(idEnchere);
  const conteneurMises = document.querySelector(
    ".detail-timbre__conteneur-mises"
  );

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
    //Mise a jour du compteur:
    const sectionTempsHTML = document.querySelector(".detail-timbre__temps");
    // 1. Date de fin:
    const dateFinHTML = document.createElement(p);
    const labelDateFin = document.createElement(span);
    labelDateFin.textContent = "Date de fin :";
    dateFinHTML.appendChild(labelDateFin);
    const valeurDateFin = document.createTextNode(dateFin);
    dateFinHTML.appendChild(valeurDateFin);
    sectionTempsHTML.appendChild(dateFinHTML);
    // 2.  Chrono:
    const chronoHTML = document.createElement("p");
    // affichage immédiat
    chronoHTML.textContent = `Temps restant: ${calculTempsRestant(
      dateFinHTML
    )}`;
    // Mise à jour toutes les secondes
    const chrono = setInterval(() => {
      chronoHTML.textContent = `Temps restant : ${calculTempsRestant(
        dateFinHTML
      )}`;
    }, 1000);
    sectionTempsHTML.appendChild(chronoHTML);
  } else {
    const dateHTML = document.createElement(p);
    const labelDate = document.createElement(span);
    labelDate.textContent = statut;
    dateHTML.appendChild(labelDate);
    const valeurDate =
      statut === "À venir"
        ? document.createTextNode(dateDebut)
        : document.createTextNode(dateFin);
    dateHTML.appendChild(valeurDate);
    sectionTempsHTML.appendChild(dateHTML);
  }

  imageZoom("myimage", "myresult");
  boutonsFavoris.forEach((btn) => {
    btn.addEventListener("click", ajoutFavoris);
  });
  // Mises.
}

const ajoutFavoris = (evenement) => {
  const idTimbre = evenement.currentTarget.dataset.timbreId;
};

// **** Execution **** //
ficheDetailEnchere();
// detail-timbre__conteneur-mises
