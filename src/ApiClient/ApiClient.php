<?php

declare(strict_types = 1);

namespace TreatEmail\ApiClient;

use TreatEmail\HttpClient\HttpClientInterface;
use TreatEmail\Utils\HashGenerator;

final class ApiClient implements ApiClientInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $clientKey;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var int
     */
    private $timeout;

    /**
     * Constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param string              $clientKey
     * @param string              $clientSecret
     * @param int                 $timeout
     */
    public function __construct(HttpClientInterface $httpClient, string $clientKey, string $clientSecret, int $timeout = 4)
    {
        $this->httpClient = $httpClient;
        $this->clientKey = $clientKey;
        $this->clientSecret = $clientSecret;
        $this->timeout = $timeout;
    }

    /**
     * @param string $email
     *
     * @return ValidationResult
     */
    public function validate(string $email): ValidationResult
    {
        $response = $this->httpClient->get(__METHOD__, $email, [
            'clientKey' => $this->clientKey,
            'timeout'   => $this->timeout,
            'headers'   => [
                'sign' => HashGenerator::signature($email, $this->clientSecret),
            ]
        ]);

        return new ValidationResult($response->getContent());
    }
}
