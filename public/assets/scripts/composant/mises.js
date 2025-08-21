import { filtreDate } from "./filtres.js";
import { recupererSession } from "../requetes-backend.js";

export const affichageMises = (mises, parent, nbr) => {
  console.log(mises);
  const misesTrierDatePlusRecent = filtreDate(mises, "date");
  creationTableMises(parent);
  for (let i = 0; i < nbr; i++) {
    creationHTMLMises(misesTrierDatePlusRecent[i]);
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
const creationHTMLMises = (mise) => {
  const tr = document.createElement("tr");
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
  tr.appendChild(tdNom);

  // Montant de la mise
  const tdMontant = document.createElement("td");
  tdMontant.textContent = mise["montant"];
  tr.appendChild(tdMontant);

  tbody.appendChild(tr);
};

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
  // Data set
  button.dataset.enchereId = enchere.id;
  button.dataset.membreId = session.membre_id;
  button.textContent = "Placer une mise";
  form.appendChild(button);

  parent.appendChild(form);
};
