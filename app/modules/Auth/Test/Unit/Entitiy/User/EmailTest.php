<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Entitiy\User;

use Modules\Auth\Entity\User\Email;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Email
 */
class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'email@app.test');

        self::assertEquals($value, $email->getValue());
    }

    public function testCase(): void
    {
        $email = new Email('EmAil@app.test');

        self::assertEquals('email@app.test', $email->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('not-email');
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('');
    }
}
