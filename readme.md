# XDBpostTrack
A simple PHP library for getting Bpost tracking information.

## Installation
Add to your ``composer.json`` file and run ``composer install``:

    "require": {
        "savjee/xd-bpost-track": "dev-master"
    },    


## How to use
Start by creating an instance with your tracking number:

    require 'vendor/autoload.php';
    use Savjee\BpostPackage;

    $myPackage = new BpostPackage('YOUR PACKAGE NUMBER HERE');


Now you can fetch the status updates of your package with the ``getStatusUpdates()`` method:

    $myPackage->getStatusUpdates();

   
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