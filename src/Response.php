<?php declare(strict_types=1);

namespace TreatEmail;

final class Response
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string|null
     */
    private $message;
    /**
     * @var bool
     */
    private $isRegistrable;

    public function __construct(array $response)
    {
        $this->email = $response['email'];
        $this->message = $response['message'] ?? null;
        $this->isRegistrable = $response['is_registrable'];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function isRegistrable(): bool
    {
        return $this->isRegistrable;
    }
}
