<?php

declare(strict_types = 1);

namespace TreatEmail\ApiClient;

use TreatEmail\Exception\RequestFailedException;

final class ApiClientDecorator implements ApiClientInterface
{
    /**
     * @var ApiClientInterface
     */
    private $apiClientInner;

    /**
     * Constructor.
     *
     * @param ApiClientInterface $apiClientInner
     */
    public function __construct(ApiClientInterface $apiClientInner)
    {
        $this->apiClientInner = $apiClientInner;
    }

    /**
     * {@inheritDoc}
     *
     * @throws RequestFailedException
     */
    public function validate(string $email): ValidationResult
    {
        \set_error_handler(static function () {
            throw new RequestFailedException('Request failed.');
        }, E_WARNING);

        $result = $this->apiClientInner->validate($email);

        \restore_error_handler();

        return $result;
    }
}
