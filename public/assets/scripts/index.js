// import { menuDeroulant } from "/stampee/public/assets/scripts/composant/menu-deroulant.js";
import { menuDeroulant } from "/public/assets/scripts/composant/menu-deroulant.js";

// Quelle page ?  ---- Recupere l'id de la page
const page = document.querySelector(".page")?.id;

// Quelle logique de code ?  ---- En fonction de l'id
if (page === "profil") {
  import("./page/profil.js");
} else if (page === "catalogue-encheres") {
  import("./page/catalogue-encheres.js");
} else if (page === "modifier-timbre") {
  import("./page/modifier-timbre.js");
} else if (page === "fiche-detail-enchere") {
  import("./page/fiche-detail-enchere.js");
}

/*----------------------------------------------------------------- */
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
