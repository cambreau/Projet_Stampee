import { menuDeroulant } from "/public/assets/scripts/composant/menu-deroulant.js";

/**
 * Menu deroulant pour la naviguation principal du header.
 */
const menuPrincipalHamburger = new menuDeroulant(
  "menu-hamburger",
  "navigation-principale"
);

menuPrincipalHamburger.ajoutEventListenerToggle();
menuPrincipalHamburger.ajoutEventListenerMenuVisibilite();
/*----------------------------------------------------------------- */
