<?php

namespace IgorKachko\OtusComposerApp\Infrastructure;

use IgorKachko\OtusComposerPackage\StringProcessor;


class StringController
{
    public function run(string $str) {
        $isSuccess = false;
        if(!empty($str)) {
            $stringProcessor = new StringProcessor();

            try {
                $str = $_POST["string"];
                $stringProcessor->checkParenthesis($str);
                $msg = "Всё хорошо \r\n";
                $isSuccess = true;
            } catch (\Exception $e) {
                $msg = $e->getMessage() . "\r\n";
            }
        } else {
            $msg = "Передана пустая строка! \r\n";
        }

        if(!$isSuccess) {
            http_response_code(400);
        }

        echo $msg;

    }
}