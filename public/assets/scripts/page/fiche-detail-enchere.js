import { recupererMisesParId, recupererSession } from "../requetes-backend.js";
import { imageZoom } from "../composant/zoom.js";
import { statutEnchere } from "../composant/encheres.js";
import { tableauMises } from "../composant/tableau-mise.js";
import { btnEncherir } from "../composant/btn-encherir.js";

async function ficheDetailEnchere() {
  // **** Variables **** //
  const idEnchere = document.querySelector(".detail-timbre__mises").dataset
    .enchereId;
  const dateDebut = document.querySelector(".detail-timbre__temps").dataset
    .dateDebut;
  const dateFin = document.querySelector(".detail-timbre__temps").dataset
    .dateFin;
  const statut = statutEnchere(dateDebut, dateFin);
  let mises = await recupererMisesParId(idEnchere);
  const conteneurMises = document.querySelector(".conteneur-mises");
  // L'utilisateur :
  const session = await recupererSession();
  // Timbre :
  const idTimbre = document.getElementById("fiche-detail-enchere").dataset
    .timbreId;
  const proprietaiteId = document.getElementById("fiche-detail-enchere").dataset
    .proprietaireId;

  // **** Logique **** //
  const tabMises = new tableauMises(mises, conteneurMises, 3, session);
  if (statut === "En cours") {
    //Mises
    if (mises.length == 0) {
      tabMises.messageAucuneMise();
    } else {
      tabMises.affichageMises();
    }
    //Bout mises:
    const sectionMiseHTML = document.querySelector(".detail-timbre__mises");
    const btnPlacerMise = new btnEncherir(
      sectionMiseHTML,
      session,
      idTimbre,
      idEnchere
    );
    if (proprietaiteId != session["membre_id"]) {
      btnPlacerMise.creationHTMLBoutonMise();
    }
  }
  //Mise a jour du compteur:
  const sectionTempsHTML = document.querySelector(".detail-timbre__temps");
  tabMises.creationHTMLStatutTemps(
    sectionTempsHTML,
    statut,
    dateFin,
    dateDebut
  );

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
