<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include $class . '.php';
});

$emails = [
    'some@mail.ru',
    '@email.ru',
    'some@email',
    'som--asd---a_asde@mail.ru',
];
foreach ($emails as $email) {
    echo "<br>Validate result for email {$email} is: " . (int)src\Validator\Email::validate($email);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>

