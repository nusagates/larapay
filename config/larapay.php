<?php

return [
    'vendor' => env('LARAPAY_VENDOR', 'ipaymu'),
    'va' => env('LARAPAY_VA', 'YOUR_VIRTUAL_ACCOUNT'), 
    'api_key' => env('LARAPAY_API_KEY', 'YOUR_API_KEY'),
    'mode' => env('LARAPAY_MODE', 'sandbox'), // sandbox | production  
];