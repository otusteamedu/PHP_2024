<?php

session_start();

//вмсето логина и пароля сессия будет сопоставляться по ip
function get_ip()
{
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

if(isset($_POST["string"])){
    $string = $_POST["string"];
    //провериьт непустоту
    if ((empty($string) && $string != '0')) {

        $logg = "<a style=\"color:red\">  Значение не корректно: </a>  пустая строка";
        $code = 400;
    }
    else{
        $char_arr = str_split($string);
        $slashs=0;
        $counter = 0;
        foreach($char_arr as $simbol){
            if ($simbol == '('){
                $counter ++;
                $slashs ++;
            };
            if ($simbol == ')'){
                $counter --;
                $slashs ++;
            };

            if ($counter < 0) {
                $logg = "<a style=\"color:red\">  Значение не корректно: </a> порядок скобок нарушен";
                $code = 400;
                break;
            }
            //если скобок нет
            elseif($slashs == 0){
                $logg = "<a style=\"color:red\">  Значение не корректно: </a> в строке нет скобок";
                $code = 400;
            }
            //проверить на корректность кол-ва открытых и закрытых скобок
            else{
                if($counter != 0){
                    $logg = "<a style=\"color:red\">  Значение не корректно: </a> количество скобок не совпадает";
                    $code = 400;
                }
                else{
                    $logg = "<a style=\"color:green\"> Строка \"$string\" валидна! </a>";
                    $code = 200;
                };
            };
        };
        
    };

    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . ' ' . $code . ' ' . $logg);
    //var_dump(http_response_code($code));

    echo "<h3 style=\"color:blue\"> Результат: </h3> Код ответа: $code </br> $logg  </br>";
};


echo "</br> <h3>Форма ввода данных</h3>";
echo "<form action=\"index.php\" method=\"POST\">
    <p>Строка: <input type=\"text\" name=\"string\" /></p>
    <input type=\"submit\" value=\"Отправить\">
</form>";



echo "</br><h3>Сиссия Redis</h3>";
$redis = new Redis();
$redis->connect('redis', '6379');
$redis->auth('qwerty');

$_SESSION["this_try"] = ["txt" => $string, "code" => "$code", "loggs" => $logg, "server" => $_SERVER['HOSTNAME']];
$user = get_ip();
$redis->set("$user", json_encode($_SESSION["this_try"]));


try {

    $response = $redis->get("$user");
    $_SESSION["previous_try"] = json_decode($response, true);

    echo "Текст Вашего предыдущего запроса: " . $_SESSION["previous_try"]["txt"] . "</br> Код запроса и логги: "  . $_SESSION["previous_try"]["code"] . $_SESSION["previous_try"]["loggs"] . "</br> Сервер, который его обработал: ". $_SESSION["previous_try"]["server"];
} catch (\Exception $e) {
    echo "Доброго времени суток Вам!";
};


echo "</br></br></br> Запрос обратотал контейнер: " . $_SESSION["this_try"]["server"] ;