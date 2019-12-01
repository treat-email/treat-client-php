<?php declare(strict_types=1);

namespace TreatEmail;

use Exception;

final class NotImplementedMethod extends Exception
{
    public function __construct() {
        parent::__construct('Called method does not implemented yet');
    }
}
