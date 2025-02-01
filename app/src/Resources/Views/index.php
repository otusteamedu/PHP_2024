<?php

declare(strict_types=1);

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

echo '<br><br><div>Отправить запрос:</div>
<form action="/string-validate" method="post" class="form-example">
  <div class="form-example">
    <label for="str">Введите строку: </label>
    <input type="text" name="str" id="str" required />
  </div>
  <div class="form-example">
    <input type="submit" value="Отправть" />
  </div>
</form>';
