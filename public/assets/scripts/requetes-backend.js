/* ------------------ Session ------------------ */
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

/* ------------------ Enchere ------------------ */
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
 * Fonction qui appelle la fonction recupererCoupCoeurLord pour recuperer toutes les informations
 * des encheres coup de coeur du lord.
 * @returns promesse
 */
export const recupererCoupCoeurLord = async () => {
  return axios
    .get("/requete/recupererCoupCoeurLord")
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

/* ------------------ Timbre ------------------ */
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

/* ------------------ Image ------------------ */
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

/* ------------------ Favoris ------------------ */
/**
 * Fonction qui appelle la fonction ajoutTimbreFavoris
 * @returns promesse
 */
export const ajoutTimbreFavoris = async (enchereId) => {
  return axios
    .get(`/requete/ajoutTimbreFavoris?id=${enchereId}`)
    .then((res) => {
      res.data;
      alert(`Enchère ajoutée aux favoris`);
    })
    .catch((err) => {
      console.error(err);
    });
};

/**
 * Fonction qui appelle la fonction ajoutTimbreFavoris
 * @returns promesse
 */
export const supprimerTimbreFavoris = async (enchereId) => {
  return axios
    .get(`/requete/supprimerTimbreFavoris?id=${enchereId}`)
    .then((res) => {
      res.data;
      alert(`Enchère supprimée des favoris !`);
    })
    .catch((err) => {
      console.error(err);
    });
};

/**
 * Fonction qui appelle la fonction ajoutTimbreFavoris pour recuperer toutes les informations
 * des encheres dans favoris.
 * @returns promesse
 */
export const recupererTableFavoris = async () => {
  return axios
    .get(`/requete/recupererTableFavoris`)
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

/**
 * Fonction qui appelle la fonction ajoutTimbreFavoris pour recuperer toutes les informations
 * des encheres dans favoris.
 * @returns promesse
 */
export const recupererEncheresFavorites = async () => {
  return axios
    .get(`/requete/recupererEncheresFavorites`)
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

/* ------------------ Mises ------------------ */
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
