<?php

declare(strict_types=1);

namespace TreatEmail\Exception;

use Throwable;

final class Maintenance extends \Exception
{
    public function __construct()
    {
        parent::__construct('Server on maintenance right now. Please, try again later');
    }
}
