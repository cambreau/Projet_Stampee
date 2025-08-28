import { Catalogue } from "../composant/catalogue.js";
import { recupererCoupCoeurLord } from "../requetes-backend.js";
import { trierEncheresParStatut } from "../composant/filtres.js";

const affichageCoupCoeurLord = async () => {
  const enchereCoupCoeurLord = await recupererCoupCoeurLord();
  const page = document.querySelector(".page");
  // Section Coup de coeur du lord et son titre
  const section = document.createElement("section");
  section.className = "article-image-gauche";
  page.appendChild(section);

  const titre = document.createElement("h2");
  titre.textContent = "Les coups de coeur du Lord";
  section.appendChild(titre);

  // Conteneneur images Lord et timbres
  const contenu = document.createElement("div");
  contenu.className = "article-image-gauche__contenu";
  section.appendChild(contenu);

  // Image lord
  const picture = document.createElement("picture");
  picture.className = "article-image-gauche__image";
  const img = document.createElement("img");
  img.src = "/public/assets/images/coups-coeur-lord.png";
  img.alt = "Illustration représentant le Lord aperçu à travers une loupe";
  picture.appendChild(img);
  contenu.appendChild(picture);

  // Timbres
  const galerie = document.createElement("div");
  galerie.className = "conteneur-timbres";
  contenu.appendChild(galerie);

  const encheres = trierEncheresParStatut(enchereCoupCoeurLord).slice(0, 3);
  const catalogueCoupCoeur = new Catalogue(encheres, galerie);
  catalogueCoupCoeur.affichageSectionTimbres();
};

affichageCoupCoeurLord();
