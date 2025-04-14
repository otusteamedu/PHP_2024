<?php
declare(strict_types=1);

namespace App\Infrastructure\Controllers;

use App\Infrastructure\Components\DataValidation;
use App\Infrastructure\Services\SendRabbitMQ;


use Twig\Loader\ArrayLoader;
use Twig\Environment;


class HomeController
{

    public function actionIndex():bool
    {
        $firstname = $_POST['firstname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];


        if($_POST['form-id']=='form-contact') {
            try {
                $dataValidation = new DataValidation();
                $res = $dataValidation->Index();

                if (!empty($firstname) &&
                    !empty($phone) &&
                    !empty($email) &&
                    !empty($date1) &&
                    !empty($date2)
                ) {
                    $messageBody = json_encode($_POST);
                    (new SendRabbitMQ())->execute($messageBody);
                    header("Location:/result");
                }

            } catch (\Exception $e) {
                $resError = $e->getMessage();
                //header("Location:/");
            }
        }

        require_once(ROOT . '/src/Infrastructure/Views/index.php');



        /*
                $loader = new ArrayLoader([
                    'index' => 'Hello {{ name }}!',
                ]);

                $twig = new Environment($loader);

                echo $twig->render('/src/Infrastructure/Views/index.php', [
                    'firstname' => $_POST['firstname'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'date1' => $_POST['date1'],
                    'date2' => $_POST['date2']
                ]);
        */


        return true;
    }


}