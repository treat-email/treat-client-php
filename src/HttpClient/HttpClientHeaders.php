<?php

declare(strict_types = 1);

namespace TreatEmail\HttpClient;

use TreatEmail\Exception\InvalidHeaderOptionsTypeException;

final class HttpClientHeaders
{
    const OPTIONS_KEY = 'headers';
    const REQUEST_HEADERS = [
        'Content-Type: application/json',
        'User-Agent: treat-client-php:v1.0.5',
    ];

    /**
     * @param array $options
     *
     * @return array
     *
     * @throws InvalidHeaderOptionsTypeException
     */
    public function buildFromOptions(array $options): array
    {
        if (empty($options[self::OPTIONS_KEY]) === true) {
            return self::REQUEST_HEADERS;
        }

        $optionalHeaders = $options[self::OPTIONS_KEY];

        if (\is_array($optionalHeaders) === false) {
            throw new InvalidHeaderOptionsTypeException('Optional headers must be array type.');
        }

        $headers = self::REQUEST_HEADERS;
        foreach ($optionalHeaders as $headerName => $headerValue) {
            $headers[] = \sprintf('%s:%s', $headerName, $headerValue);
        }

        return $headers;
    }

    /**
     * @param array $responseHeaders
     *
     * @return int
     */
    public static function parseResponseCode(array $responseHeaders): int
    {
        list(, $responseCode) = \explode(' ', $responseHeaders[0]);

        return (int) $responseCode;
    }
}
