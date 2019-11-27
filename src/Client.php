<?php declare(strict_types=1);

namespace TreatEmail;

use Exception;
use RuntimeException;
use function in_array;

final class Client
{
    private const API_URL = 'https://api.treat.email/%s/%s/%s';
    private const CONTENT_TYPE = 'Content-Type: application/json';
    private $clientKey;
    private $clientSecret;
    private $responseHeaders = [];
    private $response = [];
    private $timeout = 3;

    public function __construct(string $clientKey, string $clientSecret)
    {
        $this->clientKey = $clientKey;
        $this->clientSecret = $clientSecret;
    }

    public function setTimeout(int $timeout): Client
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function validate(string $email): Client
    {
        $this->send($email, 'validate');

        return $this;
    }

    /**
     * @param string $email
     * @return Client
     * @throws NotImplemented
     */
    public function verify(string $email): Client
    {
        throw new NotImplemented('not implemented');
    }

    public function hasErrors(): bool
    {
        return isset($this->responseHeaders[0]) === false
            || in_array(
                self::CONTENT_TYPE,
                $this->responseHeaders,
                true
            ) === false
            || strpos($this->responseHeaders[0], '200 OK') === false;
    }

    public function isRegistrable(): bool
    {
        return isset($this->response['is_registrable'])
            && $this->response['is_registrable'] === true;
    }

    public function hasMessage(): bool
    {
        return isset($this->response['message']) === true;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        if ($this->hasMessage() === false) {
            throw new RuntimeException('No message to return');
        }

        return $this->response['message'];
    }

    private function resetState(): void
    {
        $this->response = [];
        $this->responseHeaders = [];
    }

    private function send(string $email, string $method): void
    {
        $this->resetState();
        $sign = hash_hmac('sha256', $email, $this->clientSecret);
        $options = [
            'http' => [
                'timeout' => $this->timeout,
                'method' => 'GET',
                'header' => sprintf("Sign: %s\r\n", $sign).
                    "User-Agent: Treat-Client\r\n",
            ],
        ];
        $context = stream_context_create($options);
        $url = sprintf(self::API_URL, $method, $this->clientKey, $email);
        try {
            $jsonResponse = file_get_contents($url, false, $context);
            $this->response = json_decode($jsonResponse, true);
            $this->responseHeaders = $http_response_header;
        } catch (Exception $exception) {
            $this->responseHeaders = $http_response_header;
        }
    }
}
