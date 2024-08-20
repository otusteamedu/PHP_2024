<?php
declare(strict_types=1);

namespace App\Infrastructure\PaymentManager\FiatManager;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use JsonException;
use SoapClient;

class VoletApi implements FiatApiInterface
{
    private string $api_email;
    private string $api_key;
    private string $password;
    private string $base_endpoint;

    public function __construct()
    {
        $this->api_email = config('app.VOLET_ACCOUNT_EMAIL');
        $this->api_key = config('app.VOLET_API_NAME');
        $this->password = config('app.VOLET_API_PASSWORD');
        $this->base_endpoint = config('app.VOLET_API_BASE_ENDPOINT');
    }


    public function validateAccount($account)
    {
        // TODO: Implement validateAccount() method.
    }

    public function request(string $method, array $params = [])
    {

        try {
            $soap = new \SoapClient($this->base_endpoint);

        } catch (\SoapFault $e) {

            return array('message'=>$e->getMessage());
        }

        try {

            $ret=@$soap->{$method}(array(
                'arg0'=>array(
                    'apiName'=>$this->api_key,
                    'authenticationToken'=>$this->soapGetToken(),
                    'accountEmail'=>$this->api_email,
                ),
                'arg1'=> $params
            ));

            $ret= json_decode(json_encode($ret, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        }catch(\SoapFault $e) {

            return array('message'=>$e->getMessage());
        } catch (\JsonException $e) {
        }

        return $ret;
    }


//For example, API Password: “P@ssw0rd”, date UTC: “2007.02.25 14:55” (24h format)
//Text based on the parameters’ combination: “P@ssw0rd:20070225:14”
//Hash SHA256 for this text:
//CA5EE568D588145E5302B68DCF57B84E9E58D86EDCE287A2C5DC45435C364BAB
    private function soapGetToken(): string
    {

        $datePrepare = Carbon::parse(now());

        return strtoupper(hash('sha256',implode(':',array(
            $this->password,
            $datePrepare->format('Ymd'),
            $datePrepare->format('H')
        ))));
    }

    public function sendMoney(string $account, string $amount)
    {
        Log::debug("Попали в sendMoney");
        $params = [
            'amount' => $amount,
            'walletId' => $account,
            'currency' => 'USD',
        ];
        try {
            $res = $this->request('sendMoney', $params);
            Log::debug("Отправили деньги ... " . $res['return']);
            return $res['return'] ?: null;
        } catch (\InvalidArgumentException $e) {
            Log::error("Ошибка отправки денег", ['message' => $e->getMessage()]);
            throw new \RuntimeException("Ошибка отправки денег");
        }
    }
}
