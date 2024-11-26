<?php
include 'validate_post.php';

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

$validator = new ValidatePost();
$state = $validator->validate($_POST);
switch($state){
    case ErrorCodeValPost::EmptyPost: {
        http_response_code(400); 
        echo "Запрос пустой"; 
        exit;
    }
    case ErrorCodeValPost::CloseBracketBeforeOpen: {
        http_response_code(400); 
        echo "<br>Закрывающих скобока ) раньше открывающей (";
        exit;
    }
    case ErrorCodeValPost::CloseBracketАbsent: {
        http_response_code(400); 
        echo "<br>Нет закрывающих скобочек )"; 
        exit;
    }
    case ErrorCodeValPost::Ok: {
        http_response_code(200); 
        echo "Хороший запрос"; 
        exit;
    } 
    default:{
        http_response_code(400); 
        echo "Неизвестная ошибка ValidatePost"; 
        exit;    
    }
}
   