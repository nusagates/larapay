<?php

namespace Nusagates\Laraipaymu;
/**
 * @author Cak Bud <budairi@leap.id>
 */

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Nusagates\Laraipaymu\Models\Buyer;
use Nusagates\Laraipaymu\Models\Payment;
use Nusagates\Laraipaymu\Models\Product;

class Ipaymu
{
    protected $vaNumber;
    protected $apiKey;
    protected $service;

    public function __construct(string $vaNumber, string $apiKey, bool $isProduction = false)
    {
        $this->service = new Service($isProduction);
        $this->vaNumber = $vaNumber;
        $this->apiKey = $apiKey;
    }

    /**
     * Retrieves balance information from specific account
     * @return array|RedirectResponse|mixed|string
     */
    public function getBalance(): mixed
    {
        return $this->request($this->service->balance, ['account' => $this->vaNumber]);
    }

    /**
     * Retrieves transaction history sorted by descending creation date with a limit of 10 records per request
     * @return array|mixed|string
     */
    public function getHistory()
    {
        return $this->request($this->service->history, ['orderBy' => 'created_at', 'order' => 'DESC', 'limit' => 10]);
    }

    /**
     * Retrieves transaction detail by `TransactionId`
     * @param int $id TransactionId
     * @return mixed
     */
    public function getTransactionById(int $id): mixed
    {
        return $this->request($this->service->transaction, ['transactionId' => $id, 'account' => $this->vaNumber]);
    }

    /**
     * Retrieves all available payment methods
     * @return array|mixed|string
     */
    public function getPaymentMethod(): mixed
    {
        return $this->request($this->service->paymentMethod, ['account' => $this->vaNumber]);
    }

    public function directPayment(Buyer $buyer, int $amount, Payment $payment, Product $product=null): mixed
    {
        $paymentData = $buyer->toArray();
        $paymentData = array_merge($paymentData, $payment->toArray());
        if($product!=null){
            $paymentData = array_merge($paymentData, $product->getItems());
        }
        $paymentData['amount'] = $amount;

        return $this->request($this->service->directpayment, $paymentData);
    }
    public function redirectPayment(Buyer $buyer, int $amount, Payment $payment, Product $product=null): mixed
    {
        $paymentData = $buyer->toArray();
        $paymentData = array_merge($paymentData, $payment->toArray());
        if($product!=null){
            $paymentData = array_merge($paymentData, $product->getItems());
        }
        $paymentData['amount'] = $amount;
        //return $paymentData;
        return $this->request($this->service->redirectpayment, $paymentData);
    }

    private function genSignature($data, $credentials): string
    {
        $body = json_encode($data, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $body));
        $secret = $credentials['apikey'];
        $va = $credentials['va'];
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $secret;
        return hash_hmac('sha256', $stringToSign, $secret);
    }

    public function request($config, $params)
    {
        $credentials = ['va' => $this->vaNumber, 'apikey' => $this->apiKey];
        $signature = $this->genSignature($params, $credentials);
        $timestamp = Date('YmdHis');
        $headers = array(
            'Content-Type' => 'application/json',
            'va'           => $this->vaNumber,
            'signature'    => $signature,
            'timestamp'    => $timestamp
        );
        try {
            $response = Http::withHeaders($headers)
                ->post($config, $params);
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }

        if ($response->successful()) {
            return $response->json();
        }
        return $response->json("Message");
    }
}