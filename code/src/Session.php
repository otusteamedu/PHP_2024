<?php
namespace Balance\session;

use Exception;

//session_start();

class Session
{
    public $string, $code, $logg;
    private $server_hostname, $redis;
    function __construct($string, $code, $logg){
        $this -> string = $string;
        $this -> code = $code;
        $this -> logg = $logg;

        $this -> server_hostname = $_SERVER['HOSTNAME'];

        $this -> redis = new \Redis();
        $this -> redis->connect('redis', '6379');
        $this -> redis->auth('qwerty');
    }

    private function get_ip(){
        $value = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $value = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $value = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $value = $_SERVER['REMOTE_ADDR'];
        }
    
        return $value;
    }

    public function set_current_session(){
        $_SESSION["this_try"] = ["txt" => $this->string, "code" => "$this->code", "loggs" => $this->logg, "server" => $this->server_hostname];
        $user = $this->get_ip();
        $this->redis->set("$user", json_encode($_SESSION["this_try"]));

        return true;
    }

    public function get_last_session(){
        try{
            $user = $this->get_ip();
            $response = $this->redis->get("$user");
            $_SESSION["previous_try"] = json_decode($response, true);

            return "Текст Вашего предыдущего запроса: " . $_SESSION["previous_try"]["txt"] . "</br> Код запроса и логги: "  . $_SESSION["previous_try"]["code"] . $_SESSION["previous_try"]["loggs"] . "</br> Сервер, который его обработал: ". $_SESSION["previous_try"]["server"];
        } catch (Exception $e) {
            return "Рад познакомиться!";
        }
    }
};