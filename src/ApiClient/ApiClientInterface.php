<?php

declare(strict_types = 1);

namespace TreatEmail\ApiClient;

interface ApiClientInterface
{
    /**
     * @param string $email
     *
     * @return ValidationResult
     */
    public function validate(string $email): ValidationResult;
}
