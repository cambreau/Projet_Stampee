import { filtreDate } from "./filtres.js";
import { calculTempsRestant } from "../composant/encheres.js";
import { formatDateTime } from "../composant/date.js";

export class tableauMises {
  constructor(mises, parent, nbr, session) {
    this.mises = mises;
    this.parent = parent;
    this.nbr = nbr;
    this.session = session;
    this.table = null;
    this.tbody = null;
  }

  /**
   * Affichage des mises dans le tableau:
   * Etape 1: Trier les mises par date. Plus recent au moins recent.
   * Etape 2: Creer le tableau des mises : creationTableMises().
   * Etape 3: Creation des lignes mises dans le tableau : creationHTMLMises().
   */
  affichageMises() {
    const misesTrierDatePlusRecent = filtreDate(this.mises, "date");

    this.creationTableMises();

    for (let i = this.nbr - 1; i >= 0; i--) {
      if (!misesTrierDatePlusRecent[i]) continue;

      if (i === 0) {
        this.creationHTMLMise(misesTrierDatePlusRecent[i], true);
      } else {
        this.creationHTMLMise(misesTrierDatePlusRecent[i], false);
      }
    }
  }

  /**
   * Message si aucune mise
   */
  messageAucuneMise() {
    const message = document.createElement("p");
    message.textContent = "Aucune mise n’a été effectuée pour le moment.";
    this.parent.appendChild(message);
  }

  /**
   * Création du tableau et de son en-tête
   */
  creationTableMises() {
    this.table = document.createElement("table");
    this.table.classList.add("table-mises");
    this.parent.appendChild(this.table);

    // En-tête
    const thead = document.createElement("thead");
    const trHead = document.createElement("tr");

    const thNom = document.createElement("th");
    thNom.textContent = "Nom utilisateur";
    trHead.appendChild(thNom);

    const thMontant = document.createElement("th");
    thMontant.textContent = "Montant de la mise";
    trHead.appendChild(thMontant);

    thead.appendChild(trHead);
    this.table.appendChild(thead);

    // Corps
    this.tbody = document.createElement("tbody");
    this.table.appendChild(this.tbody);
  }

  /**
   * Création d’une ligne de mise
   */
  creationHTMLMises(mise, derniere) {
    const tr = document.createElement("tr");
    if (derniere) {
      tr.id = "derniere";
    }
    tr.dataset.id = mise["id"];

    const utilisateur = this.utilisateurDeLaMise(
      mise["membreId"],
      this.session
    );

    // Mise en forme selon statut
    if (utilisateur.statut === "utilisateur") {
      tr.style.background = "rgb(162, 210, 183)";
    } else {
      tr.style.background = "#e8c5c5";
    }

    // Nom utilisateur
    const tdNom = document.createElement("td");
    tdNom.textContent = utilisateur.nom;
    tdNom.dataset.idMembre = mise["membreId"];
    tr.appendChild(tdNom);

    // Montant
    const tdMontant = document.createElement("td");
    tdMontant.textContent = mise["prix"];
    tr.appendChild(tdMontant);

    this.tbody.appendChild(tr);
  }

  /**
   * Retourne les infos de l’utilisateur d’une mise
   */
  utilisateurDeLaMise(idMembre) {
    let utilisateur = { nom: undefined, statut: undefined };
    utilisateur.nom =
      idMembre == this.session["membre_id"]
        ? this.session["nomUtilisateur"]
        : "Autre utilisateur";
    utilisateur.statut =
      idMembre == this.session["membre_id"] ? "utilisateur" : "Autre";
    return utilisateur;
  }

  /**
   * Partie HTML statut + chrono
   */
  creationHTMLStatutTemps(parentStatutTemps, statut, dateFin, dateDebut) {
    if (statut === "En cours") {
      // Date de fin
      const dateFinHTML = document.createElement("p");
      dateFinHTML.classList.add("detail-timbre__temps__date");
      const labelDateFin = document.createElement("span");
      labelDateFin.textContent = "Date de fin : ";
      dateFinHTML.appendChild(labelDateFin);
      const valeurDateFin = document.createTextNode(formatDateTime(dateFin));
      dateFinHTML.appendChild(valeurDateFin);
      parentStatutTemps.appendChild(dateFinHTML);

      // Chrono
      const chronoHTML = document.createElement("p");
      chronoHTML.classList.add("detail-timbre__compteur");
      chronoHTML.textContent = `Temps restant: ${calculTempsRestant(dateFin)}`;
      setInterval(() => {
        chronoHTML.textContent = `Temps restant : ${calculTempsRestant(
          dateFin
        )}`;
      }, 1000);
      parentStatutTemps.appendChild(chronoHTML);
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
      parentStatutTemps.appendChild(dateHTML);
    }
  }
}
