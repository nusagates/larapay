<?php

namespace Nusagates\Laraipaymu\Models;
/**
 * @author Cak Bud <budairi@leap.id>
 */
class Payment
{
    public $paymentMethod, $paymentChannel, $isEscrow, $callbackUrl, $successUrl, $cancelUrl;

    public function __construct(string $paymentMethod, string $paymentChannel, string $callbackUrl, $successUrl = null, $cancelUrl = null, bool $isEscrow = false)
    {
        $this->paymentMethod = $paymentMethod;
        $this->paymentChannel = $paymentChannel;
        $this->isEscrow = $isEscrow;
        $this->callbackUrl = $callbackUrl;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
    }

    public function toArray(): array
    {
        return
            [
                'paymentMethod'  => $this->paymentMethod,
                'paymentChannel' => $this->paymentChannel,
                'isEscrow'       => $this->isEscrow,
                'notifyUrl'      => $this->callbackUrl,
                'returnUrl'      => $this->successUrl,
                'cancelUrl'      => $this->cancelUrl
            ];
    }
}