<?php

namespace Nusagates\Larapay\Controllers;

use Inertia\Inertia;
use Nusagates\Larapay\iPaymu\Ipaymu;

/**
 * @author Cak Bud <budairi@leap.id>
 */
class IpaymuController
{
    public $ipaymu;

    public function __construct()
    {
        $this->ipaymu = new Ipaymu('1179002225005825', 'CA955CFE-0A8D-4A3E-A9CF-B1CE76AAAE7A');
    }

    public function index()
    {
        return Inertia::render('Larapay/Dashboard', ['balance' => $this->ipaymu->getBalance(), 'histories'=>$this->ipaymu->getHistory()]);
    }
}