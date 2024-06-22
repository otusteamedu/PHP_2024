<?php
require '../vendor/autoload.php';

use Producer\Controller\FormController;

$controller = new FormController();
$controller->handleSubmit();
exit('Сообщение отправлено');
