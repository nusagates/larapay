# The Payment Gateway Integration For Laravel 
[![Latest Stable Version](http://poser.pugx.org/nusagates/larapay)](https://packagist.org/packages/nusagates/larapay) [![Total Downloads](http://poser.pugx.org/nusagates/larapay/downloads?)](https://packagist.org/packages/nusagates/larapay) [![Latest Unstable Version](http://poser.pugx.org/nusagates/larapay/v/unstable)](https://packagist.org/packages/nusagates/larapay) [![License](http://poser.pugx.org/nusagates/larapay/license)](https://packagist.org/packages/nusagates/larapay) [![PHP Version Require](http://poser.pugx.org/nusagates/larapay/require/php)](https://packagist.org/packages/nusagates/larapay)

Laravel package for easy integration with payment gateways. Developed using the Laravel 11 environment.

> WARNING
> This package is still in development and may contain bugs. Please use it at your own risk.

# Api Payment Gateway Used
- [iPaymu](https://my.ipaymu.com/register/ref/budairicontact)

# Installation
The best way to use this package is using [composer](https://getcomposer.org/)

```
composer require nusagates/larapay=dev-master
```
Then copy config file from vendor to your project config with simple run command bellow:
```bash
php artisan vendor:publish --tag=larapay-config
```

### Requirement
Create an account on [iPaymu](https://my.ipaymu.com/register/ref/budairicontact) and then get va Number and API Key from dashboard.
### Config
From your project at `config/larapay.php`, set virtual account and api key corresponds to your iPaymu account at dashboard.
```php
return [
    'va'        => env('LARAPAY_VA', '000000XXXXXXXXXX'),
    'api_key'   => env('LARAPAY_API_KEY', 'SANDBOXXXX-XXXX-XXX'),
    'mode'      => env('LARAPAY_MODE', 'sandbox'), // sandbox | production
];
```

# Usage
With simple put class of iPaymu to your method of controller.
```php
use Nusagates\Larapay\Vendors\iPaymu\Ipaymu;

public function index(Ipaymu $iPaymu)
{
    return $iPaymu->getBalance();
}

```
or fluently
```php
use Nusagates\Larapay\Facades\Ipaymu;

Ipaymu::getBalance();
```
## Retrieve Balance Information
```php
$iPaymu->getBalance();
```
## Retrieve Transaction History
```php
$iPaymu->getHistory();
```

