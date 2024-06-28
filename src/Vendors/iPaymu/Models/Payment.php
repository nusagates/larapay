<?php

namespace Nusagates\Larapay\Vendors\iPaymu\Models;
/**
 * @author Cak Bud <budairi@leap.id>
 */
class Payment
{
    public $paymentMethod, $paymentChannel, $isEscrow, $callbackUrl, $successUrl, $referenceId, $feeDirection, $cancelUrl;

    public function __construct(string $paymentMethod, string $paymentChannel, string $callbackUrl, $successUrl = null, $cancelUrl = null, $referenceId = null, $feeDirection = 'BUYER', bool $isEscrow = false)
    {
        $this->paymentMethod = $paymentMethod;
        $this->paymentChannel = $paymentChannel;
        $this->isEscrow = $isEscrow;
        $this->callbackUrl = $callbackUrl;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
        $this->referenceId = $referenceId;
        $this->feeDirection = $feeDirection;
    }

    public function toArray(): array
    {
        return
            [
                'paymentMethod'  => $this->paymentMethod,
                'paymentChannel' => $this->paymentChannel,
                'escrow'       => $this->isEscrow,
                'notifyUrl'      => $this->callbackUrl,
                'returnUrl'      => $this->successUrl,
                'cancelUrl'      => $this->cancelUrl,
                'referenceId'    => $this->referenceId,
                'feeDirection'   => $this->feeDirection,
            ];
    }
}