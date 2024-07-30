<?php
namespace Nusagates\Larapay\Facades;

/**
 * @method static Ipaymu getTransactionById(int $trx_id) ID Transaksi iPaymu
 * @method static Ipaymu register(string $name, string $email, string $phone, string $password) Registrasi iPaymu
 * @method static Ipaymu directPayment(Buyer $buyer, int $amount, Payment $payment, ?Product $product, ?string $account): mixed
 */

class Ipaymu extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return \Nusagates\Larapay\Vendors\iPaymu\Ipaymu::class;
    }
}
