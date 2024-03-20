<?php
declare(strict_types=1);

//$run = false;
//
//if (array_key_exists(1,$argv)) {
//    if ($argv[1] === 'start') $run = true;
//} else exit;
while (1) {
    $line = readline("Введите сообщение:\n\n");
    echo 'Вы ввели: ' . $line . "\n";

    if ($line === 'exit') {
        echo 'Выходим из приложения... ' . "\n";
        $run = false;
        exit;
    }
}


//while ($conteinerUp) {
//    sleep(1);
//}
