<?php
declare(strict_types=1);

namespace Skudashkin\Hw5;

class App{

    public function runApp(): string{
        if(!isset($_POST["email"])){
            return "Пустой post параметр email";
        }  
        $email = $_POST["email"];
        $validator = new CheckEmails();
        if($validator->check($email)) return "Email передан хороший";
        else return "Ошибка в Email";
    }
}

