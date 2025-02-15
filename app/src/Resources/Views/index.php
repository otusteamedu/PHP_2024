<?php

declare(strict_types=1);

echo '<br><br><div>Отправить запрос:</div>
<form method="POST" action="">
        Начало: <input type="date" name="start_date" required><br>
        Конец: <input type="date" name="end_date" required><br>
        Email: <input name="email" required><br>
        <input type="submit" value="Сгенерировать">
    </form>';
