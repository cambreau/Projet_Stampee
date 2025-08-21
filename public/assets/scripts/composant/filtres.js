export const filtreDate = (arrayDate, nomAssociatifIndex) => {
  const arrayFiltre = arrayDate.sort((a, b) => {
    const dateA = new Date(a[nomAssociatifIndex]);
    const dateB = new Date(b[nomAssociatifIndex]);
    return dateB - dateA;
  });
  return arrayFiltre;
};
