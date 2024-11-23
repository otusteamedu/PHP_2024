<?php

namespace SergeyShirykalov\OtusBracketsChecker;

class App
{
    public static function run(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            session_start();
            $count = $_SESSION['count'] ?? 1;
            $info = '
               <b>Для проверки правильности расстановки скобок используйте метод POST!</b><br>
               <h3>Информация по балансировщику и кластеру Redis</h3>
               <b>Nginx IP-addr:</b> ' . $_SERVER['SERVER_ADDR'] . '<br>
               <b>PHP:</b> ' . $_SERVER['HOSTNAME'] . '<br>
               <b>Session counter:</b> ' . $count . '<br>
            ';
            $_SESSION['count'] = ++$count;
            return $info;
        } else {
            $str = Normalizer::normalize($_POST['string'] ?? ''); // удаляем все символы, кроме скобок
            if (empty($str)) {
                return Response::response('Параметр string пустой или не содержит скобок!', 400);
            } elseif (!BracketsChecker::isValid($str)) {
                return Response::response('Скобки расставлены неверно!', 400);
            } else {
                return Response::response('Скобки расставлены верно!');
            }
        }
    }
}
