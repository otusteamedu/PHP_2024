<!DOCTYPE html>
<html>
<head>
    <title>Список пользователей</title>
</head>
<body>
<h1>Список пользователей</h1>
<a href="/user/create">Добавить пользователя</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Дата создания</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user->getId()) ?></td>
            <td><?= htmlspecialchars($user->getName()) ?></td>
            <td><?= htmlspecialchars($user->getEmail()) ?></td>
            <td><?= htmlspecialchars($user->getCreatedAt()) ?></td>
            <td>
                <a href="/user/edit?id=<?= $user->getId() ?>">Редактировать</a>
                <a href="/user/delete?id=<?= $user->getId() ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>