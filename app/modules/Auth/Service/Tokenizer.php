<?php

declare(strict_types=1);

namespace Modules\Auth\Service;

use Modules\Auth\Entity\User\Token;
use Ramsey\Uuid\Uuid;

class Tokenizer
{
    public function __construct(private readonly \DateInterval $interval)
    {
    }

    public function generate(\DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date->add($this->interval)
        );
    }
}
