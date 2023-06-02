<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Service;

use Modules\Auth\Service\Tokenizer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tokenizer
 */
class TokenizerTest extends TestCase
{
    public function testSuccess(): void
    {
        $interval = new \DateInterval('PT1H');
        $date = new \DateTimeImmutable('+1 day');

        $tokenizer = new Tokenizer($interval);

        $token = $tokenizer->generate($date);

        self::assertEquals($date->add($interval), $token->getExpires());
    }
}
