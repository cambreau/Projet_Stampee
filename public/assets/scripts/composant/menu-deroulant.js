/** Classe qui gere le fonctionnement des menus deroulant.
 * @param {string} iconMenu correspond au nom de l'image avant le '.'
 * @param {string} elementHTML correspond au nom de la classe du menu.
 */
export class menuDeroulant {
  constructor(iconMenu, elementHTML) {
    this.srcIconMenu = iconMenu;
    this.elementHTML = elementHTML;
    this.menuButton = document.querySelector(
      `.${this.elementHTML}__bouton-declencheur img`
    );
  }

  /**
   * Fonction qui gere l'affichage au click du menu deroulant.
   * @param {Event} evenement
   */
  toggleMenu(evenement) {
    const menu = document.querySelector(`.${this.elementHTML}__menu`);

    if (menu.classList.contains("cache")) {
      this.menuButton.src = `/public/assets/images/icon/menu-ferme.webp`;
      menu.classList.remove("cache");
    } else {
      menu.classList.add("cache");
      this.menuButton.src = `/public/assets/images/icon/${this.srcIconMenu}.webp`;
    }
  }

  /**
   * Fonction qui ajoute un Event Listener sur le bouton du menu deroulant.
   */
  ajoutEventListenerToggle() {
    this.menuButton.addEventListener("click", this.toggleMenu.bind(this));
  }

  /**
   * Fonction qui gere l'affichage du menu deroulant en fonction de la taille de l'ecran.
   */
  menuVisibilite() {
    const nav = document.querySelector(`.${this.elementHTML}__menu`);
    if (window.innerWidth < 1150) {
      nav.classList.add("cache");
      this.menuButton.src = `/public/assets/images/icon/${this.srcIconMenu}.webp`;
    } else {
      nav.classList.remove("cache");
    }
  }

  /**
   * Fonction qui ajoute un Event Listener sur l'element window..
   */
  ajoutEventListenerMenuVisibilite() {
    window.addEventListener("resize", this.menuVisibilite.bind(this));
  }
}
