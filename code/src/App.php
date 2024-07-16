<?php
namespace Balance\app;

include_once __DIR__ . "/Checker.php";
include_once __DIR__ . "/Session.php";

use Balance\chacker\Chacker as Chacker;
use Balance\session\Session as Session;
use Exception;



class App{
    public $app_string, $app_code, $app_logg, $checker, $session;

    
    function createApp(){
        if(isset($_POST["string"])){
            $this->app_string = $_POST["string"];
        }
        else{
            $this->app_string = "";
        };

        //Результат вычислений (код и логги)
        $this->checker = new Chacker($this->app_string);
        $this->checker->calculate();

        $this->app_code = $this->checker->get_code();
        $this->app_logg = $this->checker->get_logg();

        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $this->app_code . ' ' . $this->app_logg);
    }

    function run(){
        $this->createApp();

        echo "</br> <h3>Форма ввода данных</h3>";
        echo "<form action=\"index.php\" method=\"POST\">
            <p>Строка: <input type=\"text\" name=\"string\" /></p>
            <input type=\"submit\" value=\"Отправить\">
            </form>";
        
            echo "<h3 style=\"color:blue\"> Результат: </h3> Код ответа: $this->app_code </br> $this->app_logg  </br> </br>";

        //Работа сесси (код, логги, текст и имя сервера)
        echo "</br><h3>Сиссия Redis</h3>";
        $this->session = new Session($this->app_string, $this->app_code, $this->app_logg);

        try{
            echo $this->session->get_last_session();
        } catch (Exception $e){
            echo "Рад знакомству!";
        }

        $this->session->set_current_session();
        echo "</br></br></br> Запрос обратотал контейнер: " . $_SESSION["this_try"]["server"];
        
    }
}