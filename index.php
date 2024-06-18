<?php

require __DIR__ . '/vendor/autoload.php';

$utils = new MyProject\TestUtil\UtilTranslit();

echo $utils->translit("Пример транслита текста без параметров");
echo PHP_EOL;
echo $utils->translit("Пример транслита текста с параметрами, верхний регистр, без замены пробелов, без замены спецсимволов", ['change_case' => "U", 'replace_space' => false, 'replace_other' => false]);
echo PHP_EOL;
echo $utils->translit("Удаление    лишних   пробелов    и транслит без изменения  регистра", ['change_case' => false]);
