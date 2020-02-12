<?php

declare(strict_types=1);

namespace TreatEmail;

use Psr\Http\Message\ResponseInterface;
use TreatEmail\Exception\Forbidden;
use TreatEmail\Exception\HttpResponseNotOk;
use TreatEmail\Exception\Maintenance;

final class ValidationResult
{
    private const HTTP_OK = 200;
    private const HTTP_FORBIDDEN = 403;
    private const HTTP_SERVICE_UNAVAILABLE = 503;

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    public function isRegistrable(ResponseInterface $response): bool
    {
        $this->checkResponseCode($response);

        $response->getBody()->rewind();
        $json = $response->getBody()->getContents();
        $validationResult = \json_decode($json, true);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new \JsonException('Invalid format');
        }

        return $validationResult['is_registrable'];
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     *
     * @throws \JsonException
     */
    public function getMessage(ResponseInterface $response): string
    {
        $this->checkResponseCode($response);

        $response->getBody()->rewind();
        $json = $response->getBody()->getContents();
        $validationResult = \json_decode($json, true);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new \JsonException('Invalid format');
        }

        if (isset($validationResult['message']) === false) {
            return '';
        }

        return $validationResult['message'];
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws Forbidden
     */
    private function checkResponseCode(ResponseInterface $response): void
    {
        $responseStatusCode = $response->getStatusCode();

        switch (true) {
            case self::HTTP_FORBIDDEN === $responseStatusCode:
                throw new Forbidden();
            case self::HTTP_SERVICE_UNAVAILABLE === $responseStatusCode:
                throw new Maintenance();
            case self::HTTP_OK !== $responseStatusCode:
                throw new HttpResponseNotOk();
        }
    }
}
