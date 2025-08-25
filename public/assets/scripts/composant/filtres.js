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
  prixDecroissant = true
) => {
  return [...arrayMises].sort((a, b) => {
    // Tri par date
    const dateA = new Date(a.date);
    const dateB = new Date(b.date);
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
 * Trie un tableau d'objets par prix
 * @param {Array} arrayPrix
 * @param {string} nomAssociatifIndex - clé contenant le prix
 * @param {boolean} croissant - true pour tri croissant, false pour décroissant
 * @returns {Array} tableau trié
 */
export const filtreParPrix = (
  arrayPrix,
  nomAssociatifIndex,
  croissant = true
) => {
  return [...arrayPrix].sort((a, b) => {
    const prixA = parseFloat(a[nomAssociatifIndex]);
    const prixB = parseFloat(b[nomAssociatifIndex]);
    return croissant ? prixA - prixB : prixB - prixA;
  });
};

/**
 * Filtre un tableau d'objets selon la valeur d'une clé spécifique.
 * @param {Array} arrayMises
 * @param {string} nomAssociatifIndex - clé contenant la colonne a filtrer.
 * @param {string} valeur
 * @returns
 */
export const filtrerPar = (arrayMises, nomAssociatifIndex, valeur) => {
  return arrayMises.filter((mise) => mise[nomAssociatifIndex] === valeur);
};

/**
 * Retire la classe CSS "filtre-actif" de tous les éléments qui la possèdent.
 */
export const retirerStyleFiltre = () => {
  const filtres = document.querySelectorAll(".filtre-actif");
  filtres.forEach((filtre) => {
    filtre.classList.remove("filtre-actif");
  });
};
