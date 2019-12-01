<?php declare(strict_types=1);

namespace TreatEmail;

use function in_array;

final class Client
{
    private const API_URL = 'https://testapi.treat.email/%s/%s/%s';
    private const CONTENT_TYPE = 'Content-Type: application/json';
    private $clientKey;
    private $clientSecret;
    private $responseHeaders = [];
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

    /**
     * @param string $email
     * @return Response
     * @throws HttpResponseNotOk
     */
    public function validate(string $email): Response
    {
        return $this->send($email, 'validate');
    }

    /**
     * @param string $email
     * @return Response
     * @throws NotImplementedMethod
     */
    public function verify(string $email): Response
    {
        throw new NotImplementedMethod();
    }

    private function hasErrors(): bool
    {
        return isset($this->responseHeaders[0]) === false
            || in_array(
                self::CONTENT_TYPE,
                $this->responseHeaders,
                true
            ) === false
            || strpos($this->responseHeaders[0], '200 OK') === false;
    }

    /**
     * @param string $email
     * @param string $method
     * @return Response
     * @throws HttpResponseNotOk
     */
    private function send(string $email, string $method): Response
    {
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
        $jsonResponse = file_get_contents($url, false, $context);
        $this->responseHeaders = $http_response_header;

        if ($this->hasErrors() === true) {
            throw new HttpResponseNotOk();
        }

        return new Response(json_decode($jsonResponse, true));
    }
}
