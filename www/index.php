<?
require_once "./src/App.php";

$emails = [
  "sumbit.ru",
  "ivanhome2@yandex.ru",
  "test@sadsa.com",
  "coco.mail.ru"
];

foreach ($emails as $email) {
  $checkAddress =  new App($email);
  echo $checkAddress->checkEmail();
}
