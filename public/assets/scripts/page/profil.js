import { timbresParMembreId } from "../requetes-backend.js";
import { affichageTimbres } from "../composant/carte-timbre.js";

async function profilInit() {
  // **** Variables **** //
  const timbres = await timbresParMembreId();
  const conteneurTimbre = document.querySelector(".conteneur-timbres");
  console.log(timbres);
  // **** Logique **** //
  if (timbres.length !== 0) {
    // Console.log montre timbres =[] lorsqu'il n'y a rien dans la BD.
    affichageTimbres(timbres, conteneurTimbre);
  } else {
    messageInformation(conteneurTimbre);
  }
}

/** Fonction qui affiche un message a l'utilisateur pour l'informer qu'il n'a pas encore de timbres */
const messageInformation = (conteneurTimbre) => {
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
  p.textContent = `Vous n'avez pas encore de timbre`;
  div.appendChild(p);
  p.classList.add("message__contenu");
  //Modifier le css du conteneur timbre
  conteneurTimbre.style.display = "flex";
};

// **** Execution **** //
profilInit();
