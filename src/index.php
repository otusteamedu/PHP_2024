<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';


echo '
<p>Введите данные</p>
<form action="action_rabbitmq.php" method="POST">

<label for="date_from">From:</label>
<input type="date" id="date_from" name="dateFrom"><br><br>
<label for="date_to">From:</label>
<input type="date" id="date_to" name="dateTo"><br><br>

<label for="email">E-mail:</label>
<input type="email" id="email" name="email"><br><br>

<label for="comment">Comment:</label>
<input type="text" name="comment"><br><br>

<input type="submit">
</form>';

