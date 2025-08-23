import { filtreDate } from "./filtres.js";
import { recupererSession } from "../requetes-backend.js";
import { calculTempsRestant } from "../composant/encheres.js";
import { formatDateTime } from "../composant/date.js";

export const affichageMises = (mises, parent, nbr) => {
  const misesTrierDatePlusRecent = filtreDate(mises, "date");
  creationTableMises(parent);
  for (let i = nbr - 1; i < 0; i--) {
    if (i === 0) {
      creationHTMLMises(misesTrierDatePlusRecent[i], true);
    } else {
      creationHTMLMises(misesTrierDatePlusRecent[i], false);
    }
  }
};

/**
 * Fonction qui genere le tableau et son entete.
 * @param {HTMLElement} parent
 */
const creationTableMises = (parent) => {
  const tableMises = document.createElement("table");
  tableMises.classList.add("table-mises");
  parent.appendChild(tableMises);

  // Création de l'en-tête
  const thead = document.createElement("thead");
  const trHead = document.createElement("tr");

  const thNom = document.createElement("th");
  thNom.textContent = "Nom utilisateur";
  trHead.appendChild(thNom);

  const thMontant = document.createElement("th");
  thMontant.textContent = "Montant de la mise";
  trHead.appendChild(thMontant);

  thead.appendChild(trHead);
  tableMises.appendChild(thead);

  // Création du corps de la table
  const tbody = document.createElement("tbody");
  tableMises.appendChild(tbody);
};

/**
 * Fonction qui genere la ligne de mise.
 * @param {array} mise
 */
const creationHTMLMises = (mise, derniere) => {
  const tr = document.createElement("tr");
  if (derniere) {
    tr.id = "derniere";
  }
  tr.dataset.id = mise["id"];
  const utilisateur = utilisateurDeLaMise(mise["membreId"]);
  // Mise en forme selon le statut
  if (utilisateur.statut === "utilisateur") {
    tr.style.background = "rgb(162, 210, 183)"; // vert clair
  } else {
    tr.style.background = "#e8c5c5"; // rouge clair
  }
  // Nom de l'utilisateur
  const tdNom = document.createElement("td");
  tdNom.textContent = utilisateur.nom;
  tdNom.dataset.idMembre = mise["membreId"];
  tr.appendChild(tdNom);

  // Montant de la mise
  const tdMontant = document.createElement("td");
  tdMontant.textContent = mise["montant"];
  tr.appendChild(tdMontant);

  tbody.appendChild(tr);
};

/**
 * Fonction qui retourne un objet avec les informations de l'utilisateur a l'origine de la mise.
 * @param {int} idMembre
 * @returns {Objet} Information utilisateur
 */
const utilisateurDeLaMise = async (idMembre) => {
  const session = await recupererSession();
  let utilisateur = {
    nom: undefined,
    statut: undefined,
  };
  utilisateur.nom =
    idMembre == session["membre_id"]
      ? session["nomUtilisateur"]
      : "Autre utilisateur";
  utilisateur.statut =
    idMembre == session["membre_id"] ? "utilisateur" : "Autre";
  return utilisateur;
};

/**
 * Fonction message pas encore de mises.
 * @param {HTMLElement} parent
 */
export const messageAucuneMise = (parent) => {
  const message = document.createElement("p");
  message.textContent = "Aucune mise n’a été effectuée pour le moment.";
  parent.appendChild(message);
};

/**
 * Fonction qui creer le bouton html pour placer une mise.
 * @param {HTMLElement} parent
 */
export const creationHTMLBoutonMise = (parent) => {
  // Création du formulaire
  const form = document.createElement("form");
  form.classList.add("form-offre");
  // Label
  const label = document.createElement("label");
  label.setAttribute("for", "offre");
  label.classList.add("cache");
  label.textContent = "Offre";
  form.appendChild(label);
  // Input
  const input = document.createElement("input");
  input.classList.add("bouton-grand");
  input.type = "number";
  input.id = "offre";
  input.name = "offre";
  input.placeholder = "Votre offre en CAD";
  input.min = "1";
  input.step = "0.01";
  input.required = true;
  form.appendChild(input);
  // Bouton
  const button = document.createElement("button");
  button.type = "button";
  button.classList.add("bouton", "bouton-accent", "bouton-grand", "btn-mise");
  button.textContent = "Placer une mise";
  form.appendChild(button);

  parent.appendChild(form);
};

/**
 * Fonction qui creer la partie HTML relative au statut et aux date et chrono de l'enchere.
 * @param {HTMLElement} parent
 * @param {string} statut
 * @param {Date} dateFin
 * @param {Date} dateDebut
 */
export const creationHTMLStatutTemps = (parent, statut, dateFin, dateDebut) => {
  if (statut === "En cours") {
    // 1. Date de fin:
    const dateFinHTML = document.createElement("p");
    dateFinHTML.classList.add("detail-timbre__temps__date");
    const labelDateFin = document.createElement("span");
    labelDateFin.textContent = "Date de fin : ";
    dateFinHTML.appendChild(labelDateFin);
    const valeurDateFin = document.createTextNode(formatDateTime(dateFin));
    dateFinHTML.appendChild(valeurDateFin);
    parent.appendChild(dateFinHTML);
    // 2.  Chrono:
    const chronoHTML = document.createElement("p");
    chronoHTML.classList.add("detail-timbre__compteur");
    // affichage immédiat
    chronoHTML.textContent = `Temps restant: ${calculTempsRestant(dateFin)}`;
    // Mise à jour toutes les secondes
    const chrono = setInterval(() => {
      chronoHTML.textContent = `Temps restant : ${calculTempsRestant(dateFin)}`;
    }, 1000);
    parent.appendChild(chronoHTML);
  } else {
    const dateHTML = document.createElement("p");
    dateHTML.classList.add("detail-timbre__temps__date");
    const labelDate = document.createElement("span");
    labelDate.textContent = statut;
    dateHTML.appendChild(labelDate);
    const valeurDate =
      statut === "À venir"
        ? document.createTextNode(formatDateTime(dateDebut))
        : document.createTextNode(formatDateTime(dateFin));
    dateHTML.appendChild(valeurDate);
    parent.appendChild(dateHTML);
  }
};

export const ajouterMise = (evenement) => {};
