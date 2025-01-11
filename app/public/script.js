// Функция для отправки AJAX-запроса
function buttonClick() {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "index.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Обрабатываем ответ и обновляем страницу
  xhr.onload = function () {
    if (xhr.status == 200) {
      document.getElementById("response").innerHTML = xhr.responseText;
    }
  };

  // Отправляем данные
  xhr.send();
}

const check = () => {
  console.log("sdfhjkl");
};

window.onload = document.getElementById("check").addEventListener("click", buttonClick);
