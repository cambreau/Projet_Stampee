import { tousTimbres } from "../requetes-backend.js";
import { affichageTimbres } from "../composant/carte-timbre.js";
import { statutEnchere, calculTempsRestant } from "../composant/encheres.js";

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
  footer.classList.add("conteneur-timbres__timbre__bas-carte");
  parent.appendChild(footer);
  // Statut de l'enchere et temps restant:
  console.log(timbre);
  const statutValeur = statutEnchere(
    timbre["enchere"]["dateDebut"],
    timbre["enchere"]["dateFin"]
  );
  const statut = document.createElement("p");
  footer.appendChild(statut);
  statut.classList.add("detail-timbre__compteur");
  const statutEnchereLabel = document.createElement("span");
  statut.appendChild(statutEnchereLabel);
  if (statutValeur === "En cours") {
    // affichage immédiat
    statut.textContent = `Temps restant: ${calculTempsRestant(
      timbre["enchere"]["dateFin"]
    )}`;
    // Mise à jour toutes les secondes
    const chrono = setInterval(() => {
      statut.textContent = `Temps restant : ${calculTempsRestant(
        timbre["enchere"]["dateFin"]
      )}`;
    }, 1000);
  } else {
    statut.textContent = statutValeur;
  }

  const prixEnchere = document.createElement("p");
  footer.appendChild(prixEnchere);
  prixEnchere.classList.add(
    "conteneur-timbres__timbre__bas-carte-enchere__prix"
  );
  const prixEnchereLabel = document.createElement("span");
  prixEnchere.appendChild(prixEnchereLabel);
  prixEnchereLabel.textContent =
    statutValeur !== "Terminée" ? "Prix plancher :" : null;
  const prixEnchereValeur = document.createTextNode(
    ` ${timbre["enchere"]["prixPlancher"]} CAD`
  );
  prixEnchere.appendChild(prixEnchereValeur);

  if (statutValeur == "En cours") {
    const btnEnchere = document.createElement("a");
    btnEnchere.textContent = "Voir l’enchère";
    btnEnchere.classList.add("bouton");
    btnEnchere.classList.add("bouton-accent");
    btnEnchere.href = `/enchere/fiche-detail-enchere?id=${timbre["id"]}`;
    footer.appendChild(btnEnchere);
  }
};

// **** Execution **** //
CatalogueInit();
