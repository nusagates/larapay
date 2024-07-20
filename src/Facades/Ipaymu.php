<?php
namespace Nusagates\Larapay\Facades;

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
