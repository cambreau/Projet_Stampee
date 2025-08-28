/**
 * Trie un tableau de mises par date et ensuite par prix
 * @param {Array} arrayMises
 * @param {boolean} datePlusRecent - true = plus récente → plus ancienne, false = plus ancienne → plus récente
 * @param {boolean} prixDecroissant - true = prix décroissant, false = prix croissant
 * @returns {Array} tableau trié
 */
export const trierMisesDatePrix = (
  arrayMises,
  datePlusRecent = true,
  prixDecroissant = true,
  indexDate = "date"
) => {
  return [...arrayMises].sort((a, b) => {
    // Tri par date
    const dateA = new Date(a[indexDate]);
    const dateB = new Date(b[indexDate]);
    if (dateA.getTime() !== dateB.getTime()) {
      return datePlusRecent ? dateB - dateA : dateA - dateB;
    }

    // Tri par prix si dates identiques
    const prixA = parseFloat(a.prix);
    const prixB = parseFloat(b.prix);
    return prixDecroissant ? prixB - prixA : prixA - prixB;
  });
};

/**
 * Filtre un tableau d'objets selon la valeur d'une clé spécifique.
 * @param {Array} arrayEncheres
 * @param {Objet} filtre - clé contenant la colonne a filtrer.
 * @param {string} valeur
 * @returns
 */
export const filtrerPar = (arrayEncheres, filtre, filtreSur) => {
  if (filtreSur === "timbre") {
    return arrayEncheres.filter((enchere) => {
      return filtre.valeurs.includes(String(enchere["timbre"][filtre.nom]));
    });
  } else {
    return arrayEncheres.filter((enchere) => {
      return filtre.valeurs.includes(String(enchere[filtre.nom]));
    });
  }
};

/**
 * Fonction qui trie les enchères par statut
 * @param {Array} arrayEncheres - Liste des enchères à trier
 * @returns {Array} - Nouvelle liste triée
 */
export const trierEncheresParStatut = (arrayEncheres) => {
  const ordre = { "En cours": 1, "À venir": 2, Terminée: 3 };
  return [...arrayEncheres].sort((a, b) => ordre[a.statut] - ordre[b.statut]);
};

/**
 * Fonction qui gere l'affichage (toogle) des filtres.
 * @param {Event} evenement
 */
export const toogleFiltre = (evenement) => {
  const fieldset = evenement.currentTarget.parentElement;
  const listeFiltres = fieldset.querySelector(".filtre__toogle-liste");
  const estOuvert = listeFiltres.dataset.ouvert;

  if (estOuvert !== "true") {
    listeFiltres.classList.remove("cache");
    listeFiltres.dataset.ouvert = true;
  } else {
    listeFiltres.classList.add("cache");
    listeFiltres.dataset.ouvert = false;
  }
};
