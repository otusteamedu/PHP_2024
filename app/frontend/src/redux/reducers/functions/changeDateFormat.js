//Изменение формата даты со строки на объект Date (необходимо для правильной фильтрации)
export const changeDateFormat = (data) => {
  data = data.map((v) => {
    Object.keys(v).forEach((element) => {
      if (element.includes("date")) {
        if (v[element] !== null) {
          v[element] = new Date(v[element]);
        }
      }
    });
    return v;
  });
  return data;
};
