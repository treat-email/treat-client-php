<?php

declare(strict_types=1);

namespace TreatEmail\Exception;

use Throwable;

final class Forbidden extends \Exception
{
    public function __construct()
    {
        parent::__construct('Reseived 403 response code. Please check Treat Client configuration');
    }
}
