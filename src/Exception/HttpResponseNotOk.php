<?php

declare(strict_types=1);

namespace TreatEmail\Exception;

use Throwable;

final class HttpResponseNotOk extends \Exception
{
    public function __construct()
    {
        parent::__construct('Request returns not successful response code. It could be server error or network problems');
    }
}
