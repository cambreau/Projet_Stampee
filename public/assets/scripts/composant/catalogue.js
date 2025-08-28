import { affichageTimbre } from "./carte-timbre.js";
import { trierMisesDatePrix, filtrerPar } from "./filtres.js";
import { basCarteEnchere } from "./carte-timbre.js";

export class Catalogue {
  constructor(arrayEncheres, sectionHTMLTimbres) {
    this.arrayEncheres = arrayEncheres; // Jamais filtrer cet array => Array d'origine.
    this.arrayEncheresFiltre = [...arrayEncheres];
    this.sectionHTMLTimbres = sectionHTMLTimbres;
  }

  /**
   * Fonction qui affiche les timbres dans la section timbres du catalogue
   */
  affichageSectionTimbres() {
    if (this.arrayEncheresFiltre.length === 0) {
      this.messageAucuneEncheres();
    } else {
      this.arrayEncheresFiltre.forEach((enchere) => {
        affichageTimbre(
          enchere["timbre"],
          enchere,
          this.sectionHTMLTimbres,
          basCarteEnchere
        );
      });
    }
  }

  /**
   * Aucune encheres
   */
  messageAucuneEncheres() {
    const divMsg = document.createElement("div");
    const picture = document.createElement("picture");
    picture.classList.add("img");
    divMsg.appendChild(picture);

    const img = document.createElement("img");
    img.src = "/public/assets/images/aucun-resultat.png";
    img.alt = "Illustration pour aucun résultat trouvé";
    picture.appendChild(img);

    const message = document.createElement("p");
    message.textContent = "Aucune enchère ne correspond à votre recherche.";
    divMsg.appendChild(message);

    this.sectionHTMLTimbres.appendChild(divMsg);
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
      this.arrayEncheresFiltre = filtrerPar(
        this.arrayEncheresFiltre,
        filtre,
        filtrerSur
      );
    });

    this.affichageSectionTimbres();

    this.arrayEncheresFiltre = [...this.arrayEncheres];
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
    console.log("valeur filtres avant organisation:");
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
    console.log("voici filtres finaux");
    console.log(filtres);
    return filtres;
  }
}
