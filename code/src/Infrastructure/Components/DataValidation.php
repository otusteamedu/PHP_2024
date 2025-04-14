<?php

declare(strict_types=1);

namespace App\Infrastructure\Components;

use Exception;

class DataValidation{

    private string $name, $tel, $email, $date1, $date2;

    public function __construct()
    {
        $this->name = $_POST['firstname'];
        $this->tel = $_POST['phone'];
        $this->email = $_POST['email'];
        $this->date1 = $_POST['date1'];
        $this->date2 = $_POST['date2'];

    }

    protected function logFile($textLog) : bool
    {
        $log = date('Y-m-d H:i:s');
        $log .=$textLog;
        file_put_contents(ROOT. '/assets/log/log.txt', $log . PHP_EOL, FILE_APPEND);

        return true;
    }

    protected function testInput(string $data) : string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    //имя должно содержать только буквы кириллицы, любых других символов и цифр быть не должно
    protected function valideName(string $name) : bool
    {
        $val = $this->testInput($name);
        if(empty($val)){
            throw new Exception('Поле ИМЯ пустое;');
        }

        $pattern = '/^[а-яё]+$/iu';
        if (!preg_match($pattern, $val)) {
            $textLog = " Имя '$val' указано не верно!";
            $this->logFile($textLog);
            throw new Exception($textLog);
        }
        return true;
    }

    //телефон должен соответствовать шаблону 7ХХХХХХХХХХ, иначе возвращать ошибку
    protected function valideTel(string $tel) : bool
    {
        $val = $this->testInput($tel);
        if(empty($val)) {
            throw new Exception('Поле ТЕЛЕФОН пустое;');
        }

        $val = preg_replace('/[^0-9]/', '', $val);
        $pattern = '/^7[0-9]{10}$/';
        if (!preg_match($pattern, $val)){
            $textLog = " Телефон '$tel' указан не верно!";
            $this->logFile($textLog);

            throw new Exception($textLog);
        }

        return true;
    }

    //email должен соответствовать шаблону name@subdomain.domain, иначе возвращать ошибку
    protected function valideEmail(string $email): bool
    {//тип проверить
        $val = $this->testInput($email);
        if(empty($val)){
            throw new Exception('Поле EMAIL пустое;');
        }

        if (!filter_var($val, FILTER_VALIDATE_EMAIL)){
            $textLog = " E-mail адрес '$val' указан неверно;\n";
            $this->logFile($textLog);
            throw new Exception($textLog);
        }
        return true;
    }

    protected function valideDate(string $date): bool
    {
        $s = preg_match('/^\d{2}[\.]\d{2}[\.]\d{4}$/',trim($date));
        $result = false;

        if($s) {
            $testData = explode('.',$date);
            $checkDate = (checkdate((int)$testData[1],(int)$testData[0],(int)$testData[2]));

            $result = ($checkDate === true);

        }

        if(!$result) throw new \Exception('Введите корректные даты в формате dd.mm.yyyy;');

        return true;
    }


    public function Index(): bool
    {

        if(!$this->valideEmail($this->email) ||
            !$this->valideTel($this->tel) ||
            !$this->valideName($this->name) ||
            !$this->valideDate($this->date1) ||
            !$this->valideDate($this->date2) ||
            (strtotime($this->date1) > strtotime($this->date1))
        ){
            throw new Exception('Данные формы введены некорректно');
        }

        return true;

    }
}