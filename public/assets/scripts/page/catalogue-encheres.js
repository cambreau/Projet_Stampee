import { tousEncheres } from "../requetes-backend.js";
import { affichageTimbre } from "../composant/carte-timbre.js";
import { statutEnchere, calculTempsRestant } from "../composant/encheres.js";
import {
  retirerStyleFiltre,
  trierMisesDatePrix,
  filtreParPrix,
  filtrerPar,
} from "../composant/filtres.js";

async function CatalogueInit() {
  // **** Variables **** //
  const encheres = await tousEncheres();
  const conteneurTimbre = document.querySelector(".conteneur-timbres");
  // **** Logique **** //
  // Console.log montre timbres =[] lorsqu'il n'y a rien dans la BD.
  encheres.forEach((enchere) => {
    affichageTimbre(
      enchere["timbre"],
      enchere,
      conteneurTimbre,
      basCarteEnchere
    );
  });
  gestionFiltre(encheres);
}

/**
 * Fonction pour créer le bas de la carte enchere
 * @param {Object} timbre
 * @param {HTMLElement} parent
 */
const basCarteEnchere = (timbre, enchere, parent) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  footer.classList.add("conteneur-timbres__timbre__bas-carte");
  parent.appendChild(footer);
  // Statut de l'enchere et temps restant:
  const dates = document.createElement("p");
  dates.textContent = `${enchere["dateDebut"]} - ${enchere["dateFin"]}`;
  const statutValeur = statutEnchere(enchere["dateDebut"], enchere["dateFin"]);
  const statut = document.createElement("p");
  footer.appendChild(statut);
  statut.classList.add("detail-timbre__compteur");
  const statutEnchereLabel = document.createElement("span");
  statut.appendChild(statutEnchereLabel);
  if (statutValeur === "En cours") {
    // affichage immédiat
    statut.textContent = `Temps restant: ${calculTempsRestant(
      enchere["dateFin"]
    )}`;
    // Mise à jour toutes les secondes
    const chrono = setInterval(() => {
      statut.textContent = `Temps restant : ${calculTempsRestant(
        enchere["dateFin"]
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
    ` ${enchere["prixPlancher"]} CAD`
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

const gestionFiltre = (arrayEncheres) => {
  //Filtre sur index associatif:
  const boutonsFiltres = document.querySelectorAll(".TriIndexAssociatif");
  boutonsFiltres.forEach((btn) => {
    btn.addEventListener("change", () => {
      retirerStyleFiltre();
      const nomAssociatifIndex = btn.closest("select").id;
      const encheresFiltrees = filtrerPar(
        arrayEncheres,
        nomAssociatifIndex,
        btn.value
      );
      encheresFiltrees.forEach((enchere) => {
        affichageTimbre(
          enchere["timbre"],
          enchere,
          conteneurTimbre,
          basCarteEnchere
        );
      });
    });
  });
  //Filtre sur prix:
  const boutonsPrix = document.querySelectorAll(".filtre-prix");
  console.log(boutonsPrix);
  boutonsPrix.forEach((btn) => {
    btn.addEventListener("change", () => {
      retirerStyleFiltre();
      console.log("Je suis dans le event");
      const nomAssociatifIndex = btn.closest("select").id;
      const encheresFiltrees = filtreParPrix(
        arrayEncheres,
        nomAssociatifIndex,
        btn.value
      );
      encheresFiltrees.forEach((enchere) => {
        affichageTimbre(
          enchere["timbre"],
          enchere,
          conteneurTimbre,
          basCarteEnchere
        );
      });
    });
  });
  //Filtre sur date:
  const boutonsDate = document.querySelectorAll(".filtre-date");
  boutonsDate.forEach((btn) => {
    btn.addEventListener("change", () => {
      retirerStyleFiltre();
      const nomAssociatifIndex = btn.closest("label").id;
      trierMisesDatePrix(arrayEncheres, nomAssociatifIndex, btn.value, false);
    });
  });
  //Filtre sur favoris et coup de coeur du lord:
  const boutonsValeurBooleen = document.querySelectorAll(".filtre-booleen");
  boutonsValeurBooleen.forEach((btn) => {
    btn.addEventListener("click", () => {
      retirerStyleFiltre();
      const nomAssociatifIndex = btn.id;
      const btnValue = btn.data.filtreBool;
      filtrerPar(arrayEncheres, nomAssociatifIndex, btnValue);
    });
  });
};

// **** Execution **** //
CatalogueInit();
