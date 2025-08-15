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
