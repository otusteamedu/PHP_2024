<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
<h1>Email Verification</h1>
<form method="POST" action="">
    <label for="emails">Введите Emails через запятую:</label><br>
    <textarea name="emails" id="emails" rows="5" cols="40"></textarea><br><br>
    <button type="submit">Verify Emails</button>
</form>

<?php if (isset($result)): ?>
    <h2>Results:</h2>
    <h3>Valid Emails:</h3>
    <ul>
        <?php foreach ($result['valid'] as $email): ?>
            <li><?php echo htmlspecialchars($email); ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Invalid Emails:</h3>
    <ul>
        <?php foreach ($result['invalid'] as $email): ?>
            <li><?php echo htmlspecialchars($email); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>