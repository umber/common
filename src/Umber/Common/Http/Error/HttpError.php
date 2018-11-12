<?php

declare(strict_types=1);

namespace Umber\Common\Http\Error;

final class HttpError
{
    private $status;
    private $canonical;
    private $message;

    public function __construct(int $status, string $canonical, string $message)
    {
        $this->status = $status;
        $this->canonical = $canonical;
        $this->message = $message;
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function setStatusCode(int $status): void
    {
        $this->status = $status;
    }

    public function getCanonical(): string
    {
        return $this->canonical;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
