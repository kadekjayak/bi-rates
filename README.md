# Bank Indonesia Rates Scraper
Library sederhana untuk mengambil kurs mata uang (Currency Rate) dari website Bank Indonesia. 

## Install
``` bash
$ composer require kadekjayak/bi-rates
```

## Usage
```php
$BiRates = new \Kadekjayak\BiRates\BiRates();

// Get All Rates
$BiRates->getRates();

// Get Specific Rates
$BiRates->getRates('USD');

// Output All Rates
Array (
    ....
    [AUD] => Array
        (
            [sell] => 9884.58
            [buy] => 9784.23
        )
    ....
)

// Output Specific Rates
Array
(
    [sell] => 9884.58
    [buy] => 9784.23
)
```

## Testing
``` bash
$ phpunit
```

## License
The MIT License (MIT). Please see [License File](https://github.com/kadekjayak/bi-rates/blob/master/LICENSE) for more information.
