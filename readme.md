# BpostTrack
[![Packagist](https://img.shields.io/packagist/dt/savjee/bpost-track.svg?maxAge=2592000?style=flat-square)](https://packagist.org/packages/savjee/bpost-track)
[![GitHub issues](https://img.shields.io/github/issues/savjee/bpost-track.svg?maxAge=2592000?style=flat-square)](https://github.com/Savjee/bpost-track/issues)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Savjee/bpost-track/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Savjee/bpost-track/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Savjee/bpost-track/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Savjee/bpost-track/build-status/master)
[![License](https://img.shields.io/packagist/l/savjee/bpost-track.svg?maxAge=2592000?style=flat-square)](https://github.com/Savjee/bpost-track/blob/master/LICENSE.txt)

A simple PHP library for getting Bpost tracking information.

## Installation
Add to your ``composer.json`` file and run ``composer install``:

```json
"require": {
    "savjee/bpost-track": "dev-master"
},    
```

## How to use
Start by creating an instance with your tracking number:

```php
require 'vendor/autoload.php';
use Savjee\BpostTrack\BpostPackage;

$myPackage = new BpostPackage('YOUR PACKAGE NUMBER HERE');
```

## Fetching status updates
Now you can fetch the status updates of your package with the ``getStatusUpdates()`` method:

```php
$myPackage->getStatusUpdates();
```
   
This will return an array with ``StatusUpdate`` objects. The array is sorted, newest entries come first.

    Array
    (
        [0] => Savjee\StatusUpdate Object
            (
                [date:Savjee\StatusUpdate:private] => 25/08/2015
                [time:Savjee\StatusUpdate:private] => 10:47
                [status:Savjee\StatusUpdate:private] => De zending werd gesorteerd
                [location:Savjee\StatusUpdate:private] => NEW ANTWERPEN  X
            )
    
        [1] => Savjee\StatusUpdate Object
            (
                [date:Savjee\StatusUpdate:private] => 24/08/2015
                [time:Savjee\StatusUpdate:private] => 16:32
                [status:Savjee\StatusUpdate:private] => Zending aangenomen in het netwerk
                [location:Savjee\StatusUpdate:private] => DEINZE
            )
    
        [2] => Savjee\StatusUpdate Object
            (
                [date:Savjee\StatusUpdate:private] => 14/08/2015
                [time:Savjee\StatusUpdate:private] => 16:44
                [status:Savjee\StatusUpdate:private] => Aankondiging van een zending
                [location:Savjee\StatusUpdate:private] => LCI
            )
    
    )
    
## Getting sender or receiver of your package

Use either ``getReceiver()`` or ``getSender()``:

```php
$myPackage->getReceiver();
$myPackage->getSender();
```
     
And this will return a ``SenderReceiver`` object:

    Savjee\BpostTrack\SenderReceiver Object
    (
        [countryCode:Savjee\BpostTrack\SenderReceiver:private] => BE
        [municipality:Savjee\BpostTrack\SenderReceiver:private] => GENT
        [name:Savjee\BpostTrack\SenderReceiver:private] => XAVIER DECUYPER
        [zipcode:Savjee\BpostTrack\SenderReceiver:private] => 9000
    )
    
## Getting other information

  * ``getWeight()`` returns the weight of your package in grams
  * ``getCustomerReference()``
  * ``getRequestedDeliveryMethod()``
  
