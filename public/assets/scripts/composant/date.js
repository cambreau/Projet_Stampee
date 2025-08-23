export const formatDateTime = (dateString) => {
  const [date, time] = dateString.split(" ");
  const [hours, minutes] = time.split(":");
  return `${date} ${hours}h${minutes}`;
};
