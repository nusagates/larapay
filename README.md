# The Payment Gateway Integration For Laravel
[![Latest Stable Version](http://poser.pugx.org/nusagates/larapay/v)](https://packagist.org/packages/nusagates/larapay) [![Total Downloads](http://poser.pugx.org/nusagates/larapay/downloads)](https://packagist.org/packages/nusagates/larapay) [![Latest Unstable Version](http://poser.pugx.org/nusagates/larapay/v/unstable)](https://packagist.org/packages/nusagates/larapay) [![License](http://poser.pugx.org/nusagates/larapay/license)](https://packagist.org/packages/nusagates/larapay) [![PHP Version Require](http://poser.pugx.org/nusagates/larapay/require/php)](https://packagist.org/packages/nusagates/larapay)

Laravel package for easy integration with payment gateways. Developed using the Laravel 11 environment.

# Api Payment Gateway Used
- [iPaymu](https://my.ipaymu.com/register/ref/budairicontact)

# Installation
The best way to use this package is using [composer](https://getcomposer.org/)

```
composer require nusagates/larapay
```
# Usage
## Requirement
Create an account on [iPaymu](https://my.ipaymu.com/register/ref/budairicontact) and then get va Number and API Key from dashboard.

## Initialization
```php
<?php
use Nusagates\Larapay\Vendors\iPaymu\Ipaymu;

$vaNumber = 'your-va-number';
$apiKey = 'your-apikey';
$isProduction = false;
$iPaymu = new Ipaymu($vaNumber, $apiKey, $isProduction);
```
## Retrieve Balance Information
```php
$iPaymu->getBalance();
```
## Retrieve Transaction History
```php
$iPaymu->getHistory();
```

