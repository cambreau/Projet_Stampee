import { formatDateSQL } from "../composant/date.js";

export class btnEncherir {
  constructor(parent, session, idTimbre, idEnchere) {
    this.enchereId = idEnchere;
    this.parent = parent;
    this.session = session;
    this.timbreId = idTimbre;
  }

  /**
   * Création du bouton HTML pour placer une mise
   */
  creationHTMLBoutonMise() {
    const form = document.createElement("form");
    form.classList.add("form-offre");

    // Ajout de l'action
    form.action = "/enchere/placer-une-mise";
    form.method = "POST";

    // Label
    const label = document.createElement("label");
    label.setAttribute("for", "prix");
    label.classList.add("cache");
    label.textContent = "Offre";
    form.appendChild(label);

    // Input principal
    const input = document.createElement("input");
    input.classList.add("bouton-grand");
    input.type = "number";
    input.id = "prix";
    input.name = "prix";
    input.placeholder = "Votre offre en CAD";
    input.min = "1";
    input.step = "0.01";
    input.required = true;
    form.appendChild(input);

    // Hidden enchereId
    const enchereInput = document.createElement("input");
    enchereInput.type = "hidden";
    enchereInput.name = "enchereId";
    enchereInput.value = this.enchereId;
    form.appendChild(enchereInput);

    // Hidden membreId
    const membreInput = document.createElement("input");
    membreInput.type = "hidden";
    membreInput.name = "membreId";
    membreInput.value = this.session["membre_id"];
    form.appendChild(membreInput);

    // Hidden timbreId
    const timbreInput = document.createElement("input");
    timbreInput.type = "hidden";
    timbreInput.name = "timbreId";
    timbreInput.value = this.timbreId;
    form.appendChild(timbreInput);

    // Hidden Date
    const dateInput = document.createElement("input");
    dateInput.type = "hidden";
    dateInput.name = "date";
    dateInput.value = formatDateSQL(new Date(Date.now()));
    form.appendChild(dateInput);

    // Bouton
    const bouton = document.createElement("button");
    bouton.type = "button";
    bouton.classList.add("bouton", "bouton-accent", "bouton-grand", "btn-mise");
    bouton.textContent = "Placer une mise";
    form.appendChild(bouton);
    bouton.addEventListener("click", this.ajouterMise.bind(this));

    this.parent.appendChild(form);
  }

  /**
   * Ajouter une mise
   * Etape 1 : On stoppe le formulaire.
   * Etape 2 : Supprimer msg erreurs.
   * Etape 3 : Recuperation des variable.
   * Ref: https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/parseFloat
   * Etape 4 : Validation de l'input prix.
   * Etape 5 : Soumission formulaire ou renvoie msg erreur.
   */
  ajouterMise(evenement) {
    evenement.preventDefault();

    this.supprimerMsgErreur();

    const prixPlancher = document.querySelector(".detail-timbre__prix").dataset
      .prixPlancher;
    const derniereMise = document.getElementById("derniere")
      ? document.getElementById("derniere").dataset.prixMise
      : undefined;
    const prixDerniereMise =
      derniereMise !== undefined ? parseFloat(derniereMise) : undefined;
    const form = evenement.currentTarget.closest("form");
    const offreCourante = form.querySelector("input[name='prix']").value;
    const prixOffreCourante = parseFloat(offreCourante);

    if (
      this.validationForm(prixOffreCourante, prixDerniereMise, prixPlancher)
    ) {
      form.submit();
    }
  }

  /**
   * Fonction qui valide le formulaire
   */
  validationForm(prixOffreCourante, prixDerniereMise, prixPlancher) {
    if (this.session.length === 0) {
      const msgErreur = document.createElement("p");
      msgErreur.textContent = "Vous devez vous connecter pour enchérir.";
      msgErreur.classList.add("message", "message__erreur-accent");
      const prixHTML = document.querySelector(".detail-timbre__mises");
      prixHTML.appendChild(msgErreur);
    } else {
      const prixValide = prixDerniereMise
        ? this.validationPrix(prixOffreCourante, prixDerniereMise)
        : this.validationPrix(prixOffreCourante, prixPlancher);

      if (prixValide) {
        return true;
      } else {
        const msgErreur = document.createElement("p");
        msgErreur.textContent = prixDerniereMise
          ? "Votre offre doit être obligatoirement supérieure au montant de la dernière mise."
          : "Votre offre doit être obligatoirement supérieure au montant du prix plancher.";
        msgErreur.classList.add("message", "message__erreur-accent");
        const prixHTML = document.querySelector(".detail-timbre__mises");
        prixHTML.appendChild(msgErreur);
      }
    }
  }

  /**
   * Fonction qui valide le prix de l'offre d'enchere.
   * @param {Float} prixPropose
   * @param {Float} prixPrecedent
   * @returns booleen
   */
  validationPrix(prixPropose, prixPrecedent) {
    return prixPropose > prixPrecedent;
  }

  /**
   * Fonction qui supprime les msg erreurs.
   */
  supprimerMsgErreur() {
    const msgErreur = document.querySelector(".message__erreur-accent");
    if (msgErreur) {
      msgErreur.remove();
    }
  }
}
