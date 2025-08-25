/**
 * Fonction qui transforme une date format SQL BD en string pour affichage.
 * @param {string} dateString
 * @returns string
 */
export const formatDateTime = (dateString) => {
  const [date, time] = dateString.split(" ");
  const [hours, minutes] = time.split(":");
  return `${date} ${hours}h${minutes}`;
};

/**
 * Fonction qui transforme une date en format pour import dans la base de donnees.
 * Ref: https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/String/padStart
 * Ref: https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/Date
 * @param {Date} date
 * @returns string
 */
export const formatDateSQL = (date) => {
  const annee = date.getFullYear();
  const mois = String(date.getMonth() + 1).padStart(2, "0");
  const jour = String(date.getDate()).padStart(2, "0");
  const heures = String(date.getHours()).padStart(2, "0");
  const minutes = String(date.getMinutes()).padStart(2, "0");
  const secondes = String(date.getSeconds()).padStart(2, "0");

  return `${annee}-${mois}-${jour} ${heures}:${minutes}:${secondes}`;
};
