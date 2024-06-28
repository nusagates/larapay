<?php

namespace Nusagates\Larapay\iPaymu;
/**
 * @author Cak Bud <budairi@leap.id>
 */
class Service
{
    public $balance,
        $transaction,
        $history,
        $banklist,
        $paymentMethod,
        $redirectpayment,
        $directpayment,
        $codarea,
        $codrate,
        $codpickup,
        $codpayment,
        $codawb,
        $codtracking,
        $codhistory;

    public function __construct($production)
    {
        if ($production) {
            $base = 'https://my.ipaymu.com/api/v2';
        } else {
            $base = 'https://sandbox.ipaymu.com/api/v2';
        }
        /**
         * General API
         **/
        $this->balance = $base . '/balance';
        $this->transaction = $base . '/transaction';
        $this->history = $base . '/history';
        $this->banklist = $base . '/banklist';
        $this->paymentMethod = $base . '/payment-method-list';

        /**
         * Payment API
         **/
        $this->redirectpayment = $base . '/payment';
        $this->directpayment = $base . '/payment/direct';

        /**
         * COD Payment
         **/
        $this->codarea = $base . '/cod/getarea';
        $this->codrate = $base . '/cod/getrate';
        $this->codpickup = $base . '/cod/pickup';
        $this->codpayment = $base . '/payment/cod';

        /**
         * COD Tracking
         **/
        $this->codawb = $base . '/cod/getawb';
        $this->codtracking = $base . '/cod/tracking';
        $this->codhistory = $base . '/cod/history';

        return $this;
    }

}