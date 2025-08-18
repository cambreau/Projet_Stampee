import { timbresParMembreId } from "../requetes-backend.js";
import { affichageTimbres } from "../composant/carte-timbre.js";
import { statutEnchere } from "../composant/encheres.js";

async function profilInit() {
  // **** Variables **** //
  const timbres = await timbresParMembreId();
  const conteneurTimbre = document.querySelector(".conteneur-timbres");
  console.log(timbres);
  // **** Logique **** //
  if (timbres.length !== 0) {
    // Console.log montre timbres =[] lorsqu'il n'y a rien dans la BD.
    affichageTimbres(timbres, conteneurTimbre, particularitesTimbreProfil);
  } else {
    messageInformation(conteneurTimbre);
  }
}

/**
 * Fonction qui affiche un message a l'utilisateur pour l'informer qu'il n'a pas encore de timbres
 */
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

/**
 * Fonction qui gère l’appel des fonctions liées à la page profil pour l’affichage des timbres.
 * @param {Array} infoTimbre
 * @param {HTMLElement} parent
 */
const particularitesTimbreProfil = (infoTimbre, parent) => {
  basCarteTimbreProfil(infoTimbre, parent);
  boutonModifSupprimer(infoTimbre, parent);
};

/**
 * Fonction pour créer le bas de la carte timbre
 * @param {Object} timbre
 * @param {HTMLElement} parent
 */
const basCarteTimbreProfil = (timbre, parent) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  parent.appendChild(footer);
  footer.classList.add("conteneur-timbres__timbre__bas-carte-profil");

  // Création du statut de l'enchere.
  const statutValeur = statutEnchere(
    timbre["encheres"]["dateDebut"],
    timbre["encheres"]["dateFin"]
  );

  if (statutValeur == "En cours") {
    const btnEnchere = document.createElement("a");
    footer.appendChild(btnEnchere);
    btnEnchere.textContent = "Voir l’enchère";
    btnEnchere.add.classList = "bouton";
    btnEnchere.add.classList = "bouton-accent";
    btnEnchere.href = `{{base}}/timbre/fiche-detail-timbreid={{ timbre.id }}`;
  } else {
    const statut = document.createElement("p");
    footer.appendChild(statut);
    statut.classList.add("conteneur-timbres__timbre__bas-carte-profil__statut");
    statut.textContent = statutValeur;
    statut.style.color = "#ffffff";
    // Appliquer le style de fond selon le statut
    if (statutValeur === "À venir") {
      footer.style.background = "#10974b";
    } else if (statutValeur === "Terminée - Non vendu") {
      footer.style.background = "#4d4f54";
    }
  }
};

/** Fonction qui créer le conteneur et les boutons modifier et supprimer
 * @param {HTMLElement}
 */
const boutonModifSupprimer = (timbre, parent) => {
  const btnConteneur = document.createElement("div");
  btnConteneur.classList.add("conteneur-timbres__conteneur-btn-modifSuppr");
  parent.appendChild(btnConteneur);

  const btnModifierLien = document.createElement("a");
  btnModifierLien.href = `/timbre/page-modifier?id=${timbre["id"]}`;
  btnModifierLien.classList.add(
    "conteneur-timbres__conteneur-btn-modifSuppr__bouton"
  );
  btnModifierLien.classList.add("modifier");
  btnConteneur.appendChild(btnModifierLien);
  const btnModifier = document.createElement("img");
  btnModifier.src = `/public/assets/images/icon/modifier.png`;
  btnModifier.alt = `Icon modifier`;
  btnModifierLien.appendChild(btnModifier);

  const btnSupprimerLien = document.createElement("a");
  btnSupprimerLien.href = `/timbres/supprimer?id=${timbre["id"]}`;
  btnConteneur.appendChild(btnSupprimerLien);
  btnSupprimerLien.classList.add(
    "conteneur-timbres__conteneur-btn-modifSuppr__bouton"
  );
  btnSupprimerLien.classList.add("supprimer");
  const btnSupprimer = document.createElement("img");
  btnSupprimer.src = `/public/assets/images/icon/supprimer.png`;
  btnSupprimer.alt = `Icon supprimer`;
  btnSupprimerLien.appendChild(btnSupprimer);
};

// **** Execution **** //
profilInit();
