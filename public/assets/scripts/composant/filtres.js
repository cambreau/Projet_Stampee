/**
 * Trie un tableau de mises par date et ensuite par prix
 * @param {Array} arrayMises - tableau d'objets avec au moins les clés "date" et "prix"
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
