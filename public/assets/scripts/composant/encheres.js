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

// Fonction qui calcule le temps restant entre aujourd'hui et la date de fin
export const tempsRestant = (dateFin) => {
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

/**
 * Fonction pour créer le bas de la carte enchere
 * @param {Object} timbre
 * @param {HTMLElement} parent
 */
const basCarteEnchere = (timbre, parent) => {
  // Création conteneur footer de la carte
  const footer = document.createElement("footer");
  footer.classList.add("conteneur-timbres__timbre__bas-carte-enchere");
  parent.appendChild(footer);
  // Statut de l'enchere et temps restant:
  const statutValeur = statutEnchere(
    timbre["encheres"]["dateDebut"],
    timbre["encheres"]["dateFin"]
  );
  const tempsRestant =
    statutValeur == "En cours" ?? tempsRestant(timbre["encheres"]["dateFin"]);
  const statutEnchere = document.createElement("p");
  footer.appendChild(statutEnchere);
  const statutEnchereLabel = document.createElement("span");
  statutEnchere.appendChild(statutEnchereLabel);
  statutEnchereLabel.textContent =
    statutValeur == "En cours" ? "Temps restant :" : "Statut :";
  statutEnchere.textContent =
    statutValeur == "En cours" ? tempsRestant : statutValeur;

  const prixEnchere = document.createElement("p");
  footer.appendChild(prixEnchere);
  const prixEnchereLabel = document.createElement("span");
  prixEnchere.appendChild(prixEnchereLabel);
  prixEnchereLabel.textContent =
    statutValeur != "Terminée" ?? "Prix plancher :";
  prixEnchere.textContent = `${timbre["prix"]} CAD`;

  if (statutValeur == "En cours") {
    const btnEnchere = document.createElement("a");
    footer.appendChild(btnEnchere);
    btnEnchere.textContent = "Voir l’enchère";
    btnEnchere.add.classList = "bouton";
    btnEnchere.add.classList = "bouton-accent";
    btnEnchere.href = `{{base}}/timbre/fiche-detail-timbreid={{ timbre.id }}`;
  }
};
