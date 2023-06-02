<?php

declare(strict_types=1);

namespace Modules\Auth\Service;

use Webmozart\Assert\Assert;

class PasswordHasher
{
    public function __construct(private readonly int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
    }

    public function hash(string $password): string
    {
        Assert::notEmpty($password);

        /** @var string|false|null $hash */
        $hash = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => $this->memoryCost]);

        if (null === $hash) {
            throw new \RuntimeException('Invalid hash algorithm.');
        }
        if (false === $hash) {
            throw new \RuntimeException('Unable to generate hash.');
        }

        return $hash;
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
