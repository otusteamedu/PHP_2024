<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw19\Controllers;

use Asyrovatkin\Hw19\Services\Bank\Bank;
use Exception;

class BankController
{
    /**
     * @throws Exception
     */
    public function requestBalance()
    {
        $requestData = $_POST['data'];

        $bank = new Bank();
        $bank->requestBalance($requestData);
        print 'Запрос отправлен<br><br>';
        print '<a href="http://mysite.local/"> Запросить еще </a> <br><br>';
    }

}