import { tousEncheres, recupererTableFavoris } from "../requetes-backend.js";
import { Catalogue } from "../composant/catalogue.js";
import { toogleFiltre } from "../composant/filtres.js";

// ----------------------------------------------------------------------------------------
async function CatalogueInit() {
  const encheres = await tousEncheres();
  const favoris = await recupererTableFavoris();
  const encheresAvecFavoris = ajoutColonneFavoris(encheres, favoris);
  const conteneurTimbre = document.querySelector(".conteneur-timbres");

  const catalogueEncheres = new Catalogue(encheresAvecFavoris, conteneurTimbre);
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
