<?php

namespace App\Infrastructure\PaymentManager;

use App\Application\Interface\Repository;
use App\Infrastructure\PaymentManager\CryptoManager\CryptoApi;
use App\Infrastructure\PaymentManager\CryptoManager\CryptoManager;
use App\Infrastructure\PaymentManager\FiatManager\FiatManager;
use App\Infrastructure\PaymentManager\FiatManager\VoletApi;
use GuzzleHttp\Promise\PromiseInterface;
use http\Client\Response;

class PaymentManager
{
    public CryptoManager $cryptoManager;
    public FiatManager $fiatManager;

    public function __construct(
        public Repository $repository
    )
    {
        $this->cryptoManager = new CryptoManager(new CryptoApi());
        $this->fiatManager = new FiatManager(new VoletApi());
    }

    public function getIncomingAsset(string $cur): string
    {
        $curType = $this->repository->getCurType($cur);
        $incomingAsset = 'null';
        if ($curType === 'crypto') {
            $incomingAsset = $this->cryptoManager->getIncomingAsset($cur);
        }
        return $incomingAsset;
    }

    public function checkCryptoDeposit(string $coin, int $startTime, int $endTime)
    {
        return $this->cryptoManager->getDepositHistory($coin, $startTime, $endTime);
    }


}
