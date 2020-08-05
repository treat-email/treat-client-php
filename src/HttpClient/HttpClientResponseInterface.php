<?php

declare(strict_types = 1);

namespace TreatEmail\HttpClient;

interface HttpClientResponseInterface
{
    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return int
     */
    public function getResponseCode(): int;
}
