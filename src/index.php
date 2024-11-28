<?php

include 'CheckEmails.php';

echo "Проверка e-mail по post запросу!<br>".date("Y-m-d H:i:s") ."<br><br>";

if(!isset($_POST["email"])){
    echo "Пустой post параметр email";
    exit;
}  
$email = $_POST["email"];
$validator = new CheckEmails();
if($validator->check($email)) echo "Email передан хороший";
else echo "Ошибка в Email";