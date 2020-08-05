<?php

declare(strict_types = 1);

namespace TreatEmail\ApiClient;

final class ValidationResult
{
    /**
     * @var string
     */
    private $response;

    /**
     * Constructor.
     *
     * @param string $jsonResponse
     */
    public function __construct(string $jsonResponse)
    {
        $this->response = \json_decode($jsonResponse, false);
    }

    /**
     * @return bool
     */
    public function isRegistrable(): bool
    {
        return $this->response->is_registrable;
    }

    public function getMessage(): string
    {
        return $this->response->message;
    }
}
