import { tousTimbres } from "../requetes-backend.js";
import { affichageTimbres } from "../composant/carte-timbre.js";
import { statutEnchere } from "../composant/encheres.js";

async function CatalogueInit() {
  // **** Variables **** //
  const timbres = await tousTimbres();
  const conteneurTimbre = document.querySelector(".conteneur-timbres");
  // **** Logique **** //
  // Console.log montre timbres =[] lorsqu'il n'y a rien dans la BD.
  affichageTimbres(timbres, conteneurTimbre, basCarteEnchere);
}

/**
 * Fonction pour créer le bas de la carte enchere
 * @param {Object} timbre
 * @param {HTMLElement} parent
 */
const basCarteEnchere = (timbre, parent) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  footer.classList.add("conteneur-timbres__timbre__bas-carte-enchere");
  parent.appendChild(footer);
  // Statut de l'enchere et temps restant:
  const statutValeur = statutEnchere(
    timbre["encheres"]["dateDebut"],
    timbre["encheres"]["dateFin"]
  );
  const tempsRestant =
    statutValeur == "En cours" ?? tempsRestant(timbre["encheres"]["dateFin"]);
  const statut = document.createElement("p");
  footer.appendChild(statut);
  const statutEnchereLabel = document.createElement("span");
  statut.appendChild(statutEnchereLabel);
  statutEnchereLabel.textContent =
    statutValeur == "En cours" ? "Temps restant :" : "Statut :";
  statut.textContent = statutValeur == "En cours" ? tempsRestant : statutValeur;

  const prixEnchere = document.createElement("p");
  footer.appendChild(prixEnchere);
  const prixEnchereLabel = document.createElement("span");
  prixEnchere.appendChild(prixEnchereLabel);
  prixEnchereLabel.textContent =
    statutValeur != "Terminée" ?? "Prix plancher :";
  prixEnchere.textContent = `${timbre["prix"]} CAD`;

  if (statutValeur == "En cours") {
    const btnEnchere = document.createElement("a");
    footer.appendChild(btnEnchere);
    btnEnchere.textContent = "Voir l’enchère";
    btnEnchere.add.classList = "bouton";
    btnEnchere.add.classList = "bouton-accent";
    btnEnchere.href = `{{base}}/timbre/fiche-detail-timbreid={{ timbre.id }}`;
  }
};

// **** Execution **** //
CatalogueInit();
