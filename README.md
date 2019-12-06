# treat-client-php
## Versions
`treat-client-php` uses a modified version of [Semantic Versioning](https://semver.org) for all changes.
### Supported PHP Versions
* PHP 7.1
* PHP 7.2
* PHP 7.3
## Installation
You can install **treat-client-php** via composer or by downloading the source.

### Via Composer:

**treat-client-php** is available on Packagist as the
[`treat-email/treat-client-php`](https://packagist.org/packages/treat-email/treat-client-php) package:

```
composer require treat-email/treat-client-php
```
### Send API request
First of all [sign up](https://treat.email/en/register) and get credentials
```php
$clientKey = 'XXXXX';
$clientSecret = 'XXXXX';
$email = 'admin@treat.email';

$client = new \TreatEmail\Client($clientKey, $clientSecret);
try {
    $response = $client->validate($email);
    if ($response->isRegistrable() === true) {
        // email is registrable
    }
    if ($response->isRegistrable() === false) {
        // email is not registrable
        // and you can get violation message
        $violation = $response->getMessage();
    }
} catch (\TreatEmail\HttpResponseNotOk $exception) {
    // in this case use internal validation to check an email
}
```

#### List of violation messages:
* Invalid format
* Domain does not exists
* Disposable domain
* Invalid top level domain
