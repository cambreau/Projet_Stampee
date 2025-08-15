import { timbresParMembreId } from "../requetes-backend.js";
import { affichageTimbres } from "../composant/carte-timbre.js";

async function profilInit() {
  // **** Variables **** //

  const timbres = await timbresParMembreId();
  const conteneurTimbre = document.querySelector(".conteneur-timbres");

  // **** Logique **** //
  affichageTimbres(timbres, conteneurTimbre);
}

// **** Execution **** //
profilInit();
