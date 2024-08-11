<?php

namespace App\Infrastructure\PaymentManager;

use App\Application\Interface\Repository;
use App\Infrastructure\PaymentManager\CryptoManager\CryptoApi;
use App\Infrastructure\PaymentManager\CryptoManager\CryptoManager;

class PaymentManager
{
    public CryptoManager $cryptoManager;

    public function __construct(
        public Repository $repository
    )
    {
        $this->cryptoManager = new CryptoManager(new CryptoApi());
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
        // Implementation to check crypto deposit
        // ...
//        return $this->cryptoManager->getServerTime();
//        $serverTime = $this->cryptoManager->getServerTime();
//        if ($timestamp > $serverTime) {
//            // Deposit is too late
//            // ...
//        } else {
//            // Deposit is valid
//            // ...
//            $this->repository->updateOrderStatus($orderId, OrderManager::STATUS_WAITING);
//        }
    }


}
