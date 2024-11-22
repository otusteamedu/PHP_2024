<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

if(!isset($_POST["code"])){
    http_response_code(400); 
    echo "Запрос пустой"; 
    exit;
}

$code = $_POST["code"];

$i = 0;
$open_bracket = 0;
do {
    $char = substr($code, $i, 1);
    if( $char == "(" ) $open_bracket++;        
    if( $char  == ")" ) $open_bracket--;
    if($open_bracket < 0 ){
        http_response_code(400); 
        echo "<br>Закрывающих скобока ) раньше открывающей (";    
        exit;
    }
    ++$i;
} while (isset($code{$i}));

if($open_bracket != 0 ){
    http_response_code(400); 
        echo "<br>Нет $open_bracket закрывающих скобочек )";     
        exit;    
}
echo "Все хорошо";     