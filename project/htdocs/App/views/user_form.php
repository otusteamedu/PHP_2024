<!DOCTYPE html>
<html>
<head>
    <title>Форма пользователя</title>
</head>
<body>
<h1><?= isset($user) ? 'Редактирование' : 'Создание' ?> пользователя</h1>
<form method="post" action="">
    <label for="name">Имя:</label>
    <input type="text" name="name" value="<?= isset($user) ? htmlspecialchars($user->getName()) : '' ?>"><br>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= isset($user) ? htmlspecialchars($user->getEmail()) : '' ?>"><br>

    <button type="submit">Сохранить</button>
</form>
</body>
</html>