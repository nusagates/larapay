<?php

namespace Nusagates\Larapay\Vendors\iPaymu;
/**
 * @author Cak Bud <budairi@leap.id>
 */

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Nusagates\Larapay\Vendors\iPaymu\Models\Buyer;
use Nusagates\Larapay\Vendors\iPaymu\Models\Payment;
use Nusagates\Larapay\Vendors\iPaymu\Models\Product;

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
     * @param string $vaNumber
     * @return array|RedirectResponse|mixed|string
     * @return mixed
     */
    public function getBalance(string $vaNumber = null): mixed
    {
        $vaNumber = $vaNumber ?? $this->vaNumber;
        return $this->request($this->service->balance, ['account' => $vaNumber]);
    }

    /**
     *  Retrieves transaction history sorted by descending creation date with a limit of 10 records per request
     * @param string $vaNumber
     * @return array|mixed|string
     * @return mixed
     */
    public function getHistory(string $vaNumber = null): mixed
    {
        $vaNumber = $vaNumber ?? $this->vaNumber;
        return $this->request($this->service->history, ['account' => $vaNumber, 'orderBy' => 'created_at', 'order' => 'DESC', 'limit' => 10]);
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

    /**
     * Process payments directly to get a response in the form of a Virtual Account (VA), QRIS, or others in json format
     * @param Buyer $buyer
     * @param int $amount
     * @param Payment $payment
     * @param Product|null $product
     * @param string|null $account
     * @return mixed
     */
    public function directPayment(Buyer $buyer, int $amount, Payment $payment, ?Product $product, ?string $account): mixed
    {
        $paymentData = $buyer->toArray();
        $paymentData = array_merge($paymentData, $payment->toArray());
        if ($product != null) {
            $paymentData = array_merge($paymentData, $product->getItems());
        }
        $paymentData['amount'] = $amount;
        if($account != null) {
            $paymentData['account'] = $account;
        }

        return $this->request($this->service->directpayment, $paymentData);
    }

    /**
     * Process payments via redirect url. The response is in the form of json containing the URL for making payment. Use this URL to get VA, Qris, or others.
     * @param Buyer $buyer
     * @param int $amount
     * @param Payment $payment
     * @param Product|null $product
     * @return mixed
     */
    public function redirectPayment(Buyer $buyer, int $amount, Payment $payment, Product $product = null, $account=null): mixed
    {
        $paymentData = $buyer->toArray();
        $paymentData = array_merge($paymentData, $payment->toArray());
        if ($product != null) {
            $paymentData = array_merge($paymentData, $product->getItems());
        }
        $paymentData['amount'] = $amount;
        if($account != null) {
            $paymentData['account'] = $account;
        }
        //return $paymentData;
        return $this->request($this->service->redirectpayment, $paymentData);
    }

    /**
     * Register new user
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $password
     * @return mixed
     */
    public function register(string $name, string $email, string $phone, string $password): mixed
    {
        return $this->request($this->service->register, [
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => $password
        ]);
    }

    /**
     * Transfer funds between accounts
     * @param string $senderVa VA iPaymu pengirim
     * @param int $receiverVa VA iPaymu penerima
     * @param float $amount Jumlah dana yang akan di transfer
     * @param null $transactionId Referensi ID transaksi iPaymu yang akan di split
     * @param null $merchantId Referensi ID merchant
     * @param null $notes Keterangan/catatan (opsional)
     * @return mixed
     */

    public function transfer(string $senderVa, int $receiverVa, float $amount, $transactionId=null, $merchantId=null, $notes=null): mixed
    {
        return $this->request($this->service->transfer, [
            'sender' => $senderVa,
            'receiver' => $receiverVa,
            'amount' => $amount,
            'relatedId' => $transactionId,
            'referenceId' => $merchantId,
            'notes' => $notes
        ]);
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

        return $response->json();
    }
}