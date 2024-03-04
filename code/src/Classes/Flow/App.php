<?php

namespace src\Classes\Flow;

use src\Classes\Validate\Brackets;
use src\Classes\Validate\HTTP;

class App
{
    public function __construct(array $post)
    {
        try {
            $validatorHttp = new HTTP($post);
            $validatorHttp->validate();
            $validatorBrackets = new Brackets($post['string']);
            $validatorBrackets->validate();
            echo 'Всё хорошо.';
        } catch (\Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo 'Всё плохо<br>';
            echo $e->getMessage();
        }
    }
}
