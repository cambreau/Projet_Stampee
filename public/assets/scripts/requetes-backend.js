/**
 * Fonction qui appelle la fonction recupererSession pour recuperer toutes les informations
 * de la session.
 * @returns promesse
 */
export const recupererSession = async () => {
  return axios
    .get("/requete/recupererSession")
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

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
export const tousEncheres = async () => {
  return axios
    .get("/requete/tousEncheres")
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
export const ajoutTimbreFavoris = async (timbreId) => {
  return axios
    .get(`/requete/ajoutTimbreFavoris?=${timbreId}`)
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

/**
 * Fonction qui appelle la fonction backend supprimerImageBD pour supprimer une image grace a son ID.
 * @param {*} idImage
 * @param {*} imageHTML
 */
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

/**
 * Fonction qui appelle la fonction recupererMisesParId pour recuperer toutes les informations
 * des mises pour un ID d'enchere.
 * @returns promesse
 */
export const recupererMisesParId = async (idEnchere) => {
  return axios
    .get(`/requete/recupererMisesParId?id=${idEnchere}`)
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
export const ajouterMisesParId = async (idEnchere) => {
  return axios
    .get(`/requete/ajouterMisesParId?id=${idEnchere}`)
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};
