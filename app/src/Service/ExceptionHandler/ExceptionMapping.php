<?php

declare(strict_types=1);

namespace App\Service\ExceptionHandler;

final class ExceptionMapping
{
    public function __construct(private int $code, private bool $hidden, private bool $loggable)
    {
    }

    public static function fromCode(int $code): self
    {
        return new self($code, true, false);
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
