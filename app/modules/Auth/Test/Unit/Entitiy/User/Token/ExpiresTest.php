<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Entitiy\User\Token;

use Modules\Auth\Entity\User\Token;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers \Token::isExpiredTo
 */
class ExpiresTest extends TestCase
{
    public function testNot(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            $expires = new \DateTimeImmutable()
        );

        self::assertFalse($token->isExpiredTo($expires->modify('-1 secs')));
        self::assertTrue($token->isExpiredTo($expires));
        self::assertTrue($token->isExpiredTo($expires->modify('+1 secs')));
    }
}
