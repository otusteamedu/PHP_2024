<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Form</title>
</head>
<body>
<form action="/" method="POST">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>
    <br>
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <?php if (isset($data['error'])) : ?>
        <p style="color: red"><?= $data['error'] ?></p>
    <?php endif; ?>
    <?php if (isset($data['success'])) : ?>
        <p style="color: green"><?= $data['success'] ?></p>
    <?php endif; ?>
    <button type="submit">Submit</button>
</form>
</body>
</html>