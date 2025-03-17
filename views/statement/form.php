<!DOCTYPE html>
<html>
<head>
    <title>Генерация банковской выписки</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p style="color: red"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Дата начала:</label>
        <input type="date" name="start_date" required><br>
        
        <label>Дата окончания:</label>
        <input type="date" name="end_date" required><br>
        
        <label>Email для результата:</label>
        <input type="email" name="email" required><br>
        
        <button type="submit">Сгенерировать выписку</button>
    </form>
</body>
</html>