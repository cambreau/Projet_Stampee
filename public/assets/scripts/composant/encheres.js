/**
 * Fonction qui determine le statut d'une enchere.
 * @param {Date} dateDebut
 * @param {Date} dateFin
 * @returns String
 */
export const statutEnchere = (dateDebut, dateFin) => {
  const maintenant = new Date();
  // Une date envoyée depuis le backend arrive généralement sous forme de chaîne de caractères.
  // Pour pouvoir comparer il faut transformer la chaîne en objet Date.
  const debut = new Date(dateDebut);
  const fin = new Date(dateFin);

  if (maintenant < debut) {
    return "À venir";
  } else if (maintenant >= debut && maintenant <= fin) {
    return "En cours";
  } else {
    return "Terminée - Non vendu";
  }
};

/**
 * Fonction qui calcule le temps restant entre aujourd'hui et la date de fin
 * @param {Date} dateFin
 * @returns string
 */
export const calculTempsRestant = (dateFin) => {
  const maintenant = new Date();
  const fin = new Date(dateFin);

  let diff = fin - maintenant; // différence en millisecondes

  // Conversion en jours, heures, minutes, secondes
  // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/floor
  const jours = Math.floor(diff / (1000 * 60 * 60 * 24));
  diff -= jours * (1000 * 60 * 60 * 24);
  const heures = Math.floor(diff / (1000 * 60 * 60));
  diff -= heures * (1000 * 60 * 60);
  const minutes = Math.floor(diff / (1000 * 60));
  diff -= minutes * (1000 * 60);
  const secondes = Math.floor(diff / 1000);
  return `${jours}j ${heures}h ${minutes}m ${secondes}s`;
};
