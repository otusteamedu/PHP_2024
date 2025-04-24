export const formatDate = (isoDate: string): string => {
  if (isoDate !== null) {
    const [year, month, day] = isoDate.split("-");
    return `${day}.${month}.${year}`;
  } else {
    return "";
  }
};
