/* Ref: https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/Array/some */
export const estFavoris = (enchere, arrayFavoris) => {
  return arrayFavoris.some((fav) => fav.Enchere_id === enchere.id);
};
