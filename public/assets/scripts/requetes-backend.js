/**
 * Fonction qui appelle la fonction recupererTimbresMembreID pour recuperer toutes les informations
 * des timbres d'un membre.
 * @returns promesse
 */
export const timbresParMembreId = async () => {
  return axios
    .get("/requete/timbreMembreID")
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

/**
 * Fonction qui appelle la fonction recupererToutesEncheres pour recuperer toutes les informations
 * des encheres.
 * @returns promesse
 */
export const tousTimbres = async () => {
  return axios
    .get("/requete/tousTimbres")
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

export const supprimerImageBD = async (idImage, imageHTML) => {
  axios
    .delete(`/requete/supprimerImageBD?id=${idImage}`)
    .then((reponse) => {
      alert(`L'image a été  supprimée !`);
      imageHTML.remove();
    })
    .catch((error) => {
      console.error("Erreur suppression :", error);
    });
};
