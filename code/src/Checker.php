<?php

namespace Balance\chacker;

session_start();

class Chacker
{
    public $string;
    public $code;
    public $logg;

    public function __construct($string)
    {
        $this -> string = $string;
    }

    public function calculate()
    {
        //проверить непустоту
        if ((empty($this->string) && $this->string != '0')) {
            $this->logg = "<a style=\"color:red\">  Значение не корректно: </a>  пустая строка";
            $this->code = 400;
        } else {
            $char_arr = str_split($this->string);
            $slashs = 0;
            $counter = 0;
            foreach ($char_arr as $simbol) {
                if ($simbol == '(') {
                    $counter++;
                    $slashs++;
                };
                if ($simbol == ')') {
                    $counter--;
                    $slashs++;
                };
    
                if ($counter < 0) {
                    $this->logg = "<a style=\"color:red\">  Значение не корректно: </a> порядок скобок нарушен";
                    $this->code = 400;
                    break;
                }
                //если скобок нет
                elseif ($slashs == 0) {
                    $this->logg = "<a style=\"color:red\">  Значение не корректно: </a> в строке нет скобок";
                    $this->code = 400;
                }
                //проверить на корректность кол-ва открытых и закрытых скобок
                else{
                    if ($counter != 0) {
                        $this->logg = "<a style=\"color:red\">  Значение не корректно: </a> количество скобок не совпадает";
                        $this->code = 400;
                    }
                    else {
                        $this->logg = "<a style=\"color:green\"> Строка \" ". $this->string ." \" валидна! </a>";
                        $this->code = 200;
                    };
                };
            };
            
        };

        return "<h3 style=\"color:blue\"> Результат: </h3> Код ответа: $this->code </br> $this->logg  </br>";
    }

    public function get_code(){
        return $this->code;
    }

    public function get_logg(){
        return $this->logg;
    }
};
