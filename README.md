# treat-client-php
## Versions
`treat-client-php` uses a modified version of [Semantic Versioning](https://semver.org) for all changes.
### Supported PHP Versions
* PHP >= 7.1
## Installation
You can install **treat-client-php** via composer or by downloading the source.

### Via Composer:

**treat-client-php** is available on Packagist as the
[`treat-email/treat-client-php`](https://packagist.org/packages/treat-email/treat-client-php) package:

```
composer require treat-email/treat-client-php
```
### Send API request
[Sign up](https://treat.email/en/register) to get credentials

Send request with HTTPlug or any other PSR-18 (HTTP client) you may send requests like:
```php
$clientKey = 'XXXXX';
$clientSecret = 'XXXXX';
$email = 'admin@treat.email';
$psr18Client = new Psr18Client();

$client = new \TreatEmail\Client($psr18Client, $clientKey, $clientSecret);
$validationResult = new \TreatEmail\ValidationResult();
try {
    $response = $client->validate($email);
    if ($validationResult->isRegistrable($response) === true) {
        // email is registrable
    }
    if ($validationResult->isRegistrable($response) === false) {
        // email is not registrable
        // and you can get violation message
        $violation = $validationResult->getMessage($response);
    }
} catch (\TreatEmail\Exception\Maintenance $exception) {
    // handle exception if server on maintenance
} catch (\TreatEmail\HttpResponseNotOk $exception) {
    // faced issue with internet connection or server error
    // in this case use fallback internal validation to check an email
}
```

#### List of violation messages:
* Invalid format
* Domain does not exists
* Disposable domain
* Invalid top level domain
