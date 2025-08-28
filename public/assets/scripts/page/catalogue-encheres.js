import { tousEncheres, recupererTableFavoris } from "../requetes-backend.js";
import { Catalogue } from "../composant/catalogue.js";
import { toogleFiltre, trierEncheresParStatut } from "../composant/filtres.js";
import {
  ajoutColonneFavoris,
  ajoutColonneStatut,
} from "../composant/encheres.js";

// ----------------------------------------------------------------------------------------
async function CatalogueInit() {
  const encheres = await tousEncheres();
  const favoris = await recupererTableFavoris();
  /* Transformation d'encheres pour pouvoir l'utiliser pour les filtres */
  let encheresModifie =
    favoris.length > 0 ? ajoutColonneFavoris(encheres, favoris) : encheres;
  encheresModifie = ajoutColonneStatut(encheresModifie);
  console.log(encheresModifie);
  const conteneurTimbre = document.querySelector(".conteneur-timbres");
  const catalogueEncheres = new Catalogue(
    trierEncheresParStatut(encheresModifie),
    conteneurTimbre
  );
  catalogueEncheres.affichageSectionTimbres();

  const titreListeFiltre = document.querySelectorAll("legend");
  titreListeFiltre.forEach((titre) => {
    titre.addEventListener("click", toogleFiltre);
  });

  const btnFiltre = document.querySelector(".filtres button");
  btnFiltre.addEventListener(
    "click",
    catalogueEncheres.filtrerEncheres.bind(catalogueEncheres)
  );
}

// **** Execution **** //
CatalogueInit();
