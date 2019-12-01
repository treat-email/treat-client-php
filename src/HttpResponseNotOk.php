<?php declare(strict_types=1);

namespace TreatEmail;

use Exception;

final class HttpResponseNotOk extends Exception
{
    public function __construct() {
        parent::__construct('Http response code is not 200 OK');
    }
}
