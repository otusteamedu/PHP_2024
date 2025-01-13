// Функция для отправки AJAX-запроса
function buttonClick(type) {
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
  xhr.send("type=" + type);
}

window.onload = document.getElementById("add").addEventListener("click", () => buttonClick("add"));
window.onload = document.getElementById("get").addEventListener("click", () => buttonClick("get"));
window.onload = document.getElementById("del").addEventListener("click", () => buttonClick("del"));
