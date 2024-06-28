<?php

namespace Nusagates\Larapay\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Nusagates\Larapay\Vendors\iPaymu\Ipaymu;

/**
 * @author Cak Bud <budairi@leap.id>
 */
class IpaymuController
{
    public $ipaymu, $vaNumber, $apiKey;

    public function __construct()
    {
        $this->vaNumber = env('IPAYMU_VA');
        $this->apiKey = env('IPAYMY_KEY');
        $this->ipaymu = new Ipaymu($this->vaNumber, $this->apiKey);
    }

    public function index(Request $request)
    {
        if ($request->filled('balance')) {
            return $this->ipaymu->getBalance();
        }
        if ($request->filled('history')) {
            return $this->ipaymu->getHistory();
        }
        return Inertia::render('Larapay/Dashboard');
    }
}