<?php

declare(strict_types = 1);

namespace TreatEmail\HttpClient;

final class HttpClientResponse implements HttpClientResponseInterface
{
    /**
     * @var string
     */
    private $response;

    /**
     * @var int
     */
    private $responseCode;

    /**
     * Constructor.
     *
     * @param string $response
     * @param array  $responseHeaders
     */
    public function __construct(string $response, array $responseHeaders)
    {
        $this->response = $response;
        $this->responseCode = HttpClientHeaders::parseResponseCode($responseHeaders);
    }

    /**
     * {@inheritDoc}
     */
    public function getContent(): string
    {
        return $this->response;
    }

    /**
     * {@inheritDoc}
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}
