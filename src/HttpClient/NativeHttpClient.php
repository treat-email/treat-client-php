<?php

declare(strict_types = 1);

namespace TreatEmail\HttpClient;

use TreatEmail\Exception\InvalidHeaderOptionsTypeException;

final class NativeHttpClient implements HttpClientInterface
{
    const API_URL_TEMPLATE = 'http://10.211.55.4/validate/%s/%s';

    /**
     * @var HttpClientHeaders
     */
    private $httpClientHeaders;

    /**
     * Constructor.
     *
     * @param HttpClientHeaders $headers
     */
    public function __construct(HttpClientHeaders $headers)
    {
        $this->httpClientHeaders = $headers;
    }

    /**
     * @param string $action
     * @param string $email
     * @param array  $options
     *
     * @return HttpClientResponse
     *
     * @throws InvalidHeaderOptionsTypeException
     */
    public function get(string $action, string $email, array $options = []): HttpClientResponseInterface
    {
        $headers = $this->httpClientHeaders->buildFromOptions($options);
        $contextOptions = [
            'http' => [
                'method'  => 'GET',
                'timeout' => $options['timeout'],
                'header'  => \implode("\r\n", $headers),
            ]
        ];

        $context = \stream_context_create($contextOptions);

        $apiUrl = \sprintf(self::API_URL_TEMPLATE, $options['clientKey'], $email);
        $response = \file_get_contents($apiUrl, false, $context);

        return new HttpClientResponse($response, $http_response_header);
    }
}
