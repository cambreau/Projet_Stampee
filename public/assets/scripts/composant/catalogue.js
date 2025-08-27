import { affichageTimbre } from "./carte-timbre.js";
import { statutEnchere, calculTempsRestant } from "./encheres.js";
import { trierMisesDatePrix, filtrerPar } from "./filtres.js";

export class Catalogue {
  constructor(arrayEncheres, sectionHTMLTimbres) {
    this.arrayEncheres = arrayEncheres; // Jamais filtrer cet array => Array d'origine.
    this.arrayEncheresFiltre = arrayEncheres;
    this.sectionHTMLTimbres = sectionHTMLTimbres;
  }

  /**
   * Fonction qui affiche les timbres dans la section timbres du catalogue
   */
  affichageSectionTimbres() {
    this.arrayEncheresFiltre.forEach((enchere) => {
      affichageTimbre(
        enchere["timbre"],
        enchere,
        this.sectionHTMLTimbres,
        this.basCarteEnchere
      );
    });
  }

  /**
   * Fonction pour créer le bas de la carte enchere
   * @param {Object} timbre
   * @param {HTMLElement} parent
   */
  basCarteEnchere(timbre, enchere, parent) {
    // Création conteneur footer de la carte
    const footer = document.createElement("footer");
    footer.classList.add("conteneur-timbres__timbre__bas-carte");
    parent.appendChild(footer);
    // Statut de l'enchere et temps restant:
    const dates = document.createElement("p");
    dates.textContent = `${enchere["dateDebut"]} - ${enchere["dateFin"]}`;
    const statutValeur = statutEnchere(
      enchere["dateDebut"],
      enchere["dateFin"]
    );
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
  }

  /**
   * Fonction qui supprime les timbres de la section timbres du catalogue.
   */
  SupprimerSectionTimbres() {
    const timbresHTML = document.querySelectorAll(".conteneur-timbres__timbre");
    timbresHTML.forEach((timbreHTML) => {
      timbreHTML.remove();
    });
  }

  /**
   * Fonction qui applique les filtres des encheres..
   */
  filtrerEncheres(evenement) {
    evenement.preventDefault();
    this.SupprimerSectionTimbres();
    const filtresIndex = this.recupererFiltresIndex();
    filtresIndex.forEach((filtre) => {
      const filtrerSur = document.querySelector(
        `form input[name="${filtre.nom}"]`
      ).dataset.filtreSur;
      console.log(filtrerSur);
      this.arrayEncheresFiltre = filtrerPar(
        this.arrayEncheresFiltre,
        filtre,
        filtrerSur
      );
    });
    console.log(this.arrayEncheresFiltre);
    const filtresDatePrix = this.recupererFiltresDatePrix();
    console.log(filtresDatePrix);
    this.arrayEncheresFiltre = trierMisesDatePrix(
      this.arrayEncheresFiltre,
      filtresDatePrix["date"],
      filtresDatePrix["prix"]
    );

    this.affichageSectionTimbres();
  }

  /**
   * Fonction qui recupere les choix de l'utilisateur pour les filtres date et prix.
   * @returns array valeurFiltres
   */
  recupererFiltresDatePrix() {
    const filtresSelectionnesDatePrix = document.querySelectorAll(
      ".filtre__option input[type='checkbox']:checked datePrix"
    );
    const filtresFinauxDatePrix = [];
    filtresSelectionnesDatePrix.forEach((filtreHTML) => {
      filtresFinauxDatePrix.push({
        indexAssociatif: filtreHTML.name,
        filtre: filtreHTML.value,
      });
    });
    return filtresFinauxDatePrix;
  }

  /**
   * Fonction qui recupere les choix de l'utilisateur pour les filtres par index
   * @returns array valeurFiltres
   */
  recupererFiltresIndex() {
    const filtresSelectionnesParIndex = document.querySelectorAll(
      ".filtre__option input.parIndex[type='checkbox']:checked "
    );
    const valeurFiltres = [];
    filtresSelectionnesParIndex.forEach((filtreHTML) => {
      valeurFiltres.push({
        indexAssociatif: filtreHTML.name,
        filtre: filtreHTML.value,
      });
    });
    console.log(valeurFiltres);
    return this.organiserLesChoixFiltres(valeurFiltres);
  }

  /**
   * Fonction qui organise les filtres pour pouvoir les appliquer.
   * @param {Array} valeurFiltres
   */
  organiserLesChoixFiltres(valeurFiltres) {
    const filtres = [];
    valeurFiltres.forEach((objetFiltre) => {
      // Cherche si l'objet existe déjà
      let filtreNom = filtres.find(
        (f) => f.nom === objetFiltre.indexAssociatif
      );
      // Si pas trouvé, on crée l'objet et on met à jour filtreNom
      if (!filtreNom) {
        filtreNom = { nom: objetFiltre.indexAssociatif, valeurs: [] };
        filtres.push(filtreNom);
      }
      // Ajouter la valeur
      filtreNom.valeurs.push(objetFiltre.filtre);
    });

    return filtres;
  }
}
