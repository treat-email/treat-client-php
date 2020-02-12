<?php declare(strict_types=1);

namespace TreatEmail;

use App\Service\TostHttpClient;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class Client
{
    private const API_URL_TEMPLATE = 'https://testapi.treat.email/validate/%s/%s';

    /**
     * @var ClientInterface
     */
    private $client;

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
     * @param ClientInterface $client
     * @param string $clientKey
     * @param string $clientSecret
     */
    public function __construct(ClientInterface $client, string $clientKey, string $clientSecret)
    {
        $this->client = $client;
        $this->clientKey = $clientKey;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param int $timeout
     *
     * @return TostHttpClient
     */
    public function setTimeout(int $timeout): TostHttpClient
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return ResponseInterface
     *
     * @throws ClientExceptionInterface
     */
    public function validate(string $email): ResponseInterface
    {
        $headers = [
            'User-Agent' => 'Treat-Client',
            'Content-Type' => 'application/json',
            'Sign' => $this->generateSign($email),
        ];

        $url = \sprintf(self::API_URL_TEMPLATE, $this->clientKey, $email);
        $request = new Request('GET', $url, $headers);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $email
     *
     * @return string
     */
    private function generateSign(string $email): string
    {
        return \hash_hmac('sha256', $email, $this->clientSecret);
    }
}
