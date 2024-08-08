<?php

namespace App\Infrastructure\PaymentManager\CryptoManager;

class CryptoManager
{

    private array $chains;
    private CryptoApi $cryptoApi;

    public function __construct(
        CryptoApi $cryptoApi
    )
    {
        $this->cryptoApi = $cryptoApi;
        $this->chains = [
            'trc20' => 'TRX',
            'erc20' => 'ETH',
            'bsc' => 'BNB',
            'doge' => 'DOGE',
            'bch' => 'BCH',
            'ada' => 'ADA',
        ];
    }

    public function getServerTime()
    {
        return $this->cryptoApi->GetServerTime();
    }

    public function getIncomingAsset(string $cur): string
    {

        $curArr = explode('_',$cur);
        $coin = strtoupper($curArr[0]);
        $chain = $curArr[1];

        if (!array_key_exists($chain, $this->chains)) {
            throw new \RuntimeException('Unsupported chain');
        }

        $res = $this->cryptoApi->getMasterDepositAddress($coin, $this->chains[$chain]);
        return $res['result']['chains'][0]['addressDeposit'];
    }
}
