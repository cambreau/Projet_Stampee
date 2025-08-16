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
