<?
require_once "./src/App.php";

$emails = [
  "sumbit.ru",
  "ivanhome2@yandex.ru",
  "test@sadsa.com",
  "coco.mail.ru"
];

$checkAddress = new App($emails);
print_r($checkAddress->checkEmail());
