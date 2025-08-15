/**
 * Fonction qui appelle la fonction recupererTimbresMembreID du Controller Timbre pour recuperer toutes les informations
 * des timbres d'un membre.
 * @returns promesse
 */
export const timbresParMembreId = async () => {
  return axios
    .get("/timbres/membre")
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};

/**
 * Fonction qui appelle la fonction recupererInfoSession du Controller Membre pour recuperer toutes les informations
 * de la session.
 * @returns promesse
 */
export const session = async () => {
  return axios
    .get("/app/controllers/TimbreController.php?action=recupererInfoSession")
    .then((res) => res.data)
    .catch((err) => {
      console.error(err);
    });
};
