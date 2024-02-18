<?php

declare(strict_types=1);

namespace Lrazumov\Hw4;

class App
{

    private function badString(string $string): bool
    {
        $balance = 0;
        for ($i = 0; $i < strlen($string); $i++) { 
            if (empty($balance) && $string[$i] === ')') {
                return true;
            }
            elseif ($string[$i] === '(') {
                $balance++;
            }
            elseif ($string[$i] === ')') {
                $balance--;
            }
        }
        return !empty($balance);
    }

    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return '
                <h1>(()()()())<span style="color:red;">)</span>((((()()()))(()()()(((()))))))</h1>
                <form method="post">
                    <input type="text" name="string">
                    <input type="submit" value="Check">
                </form>
            ';
        }
        elseif (empty($_POST['string'])) {
            header("HTTP/1.1 400 BAD REQUEST", true, 400);
            return '400 Bad!';
        }
        elseif ($this->badString($_POST['string'])) {
            header("HTTP/1.1 400 BAD REQUEST", true, 400);
            return '400 Bad!';
        }
        else {
            header("HTTP/1.1 200 OK", true, 200);
            return '200 Ok!';
        }
    }

}
