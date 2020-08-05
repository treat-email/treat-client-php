<?php

declare(strict_types = 1);

namespace TreatEmail\Utils;

final class HashGenerator
{
    /**
     * @param string $data
     * @param string $secret
     *
     * @return string
     */
    public static function signature(string $data, string $secret): string
    {
        return \hash_hmac('sha256', $data, $secret);
    }
}
