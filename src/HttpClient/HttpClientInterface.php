<?php

declare(strict_types = 1);

namespace TreatEmail\HttpClient;

interface HttpClientInterface
{
    /**
     * @param string $action
     * @param string $email
     * @param array  $options
     *
     * @return HttpClientResponseInterface
     */
    public function get(string $action, string $email, array $options = []): HttpClientResponseInterface;
}
