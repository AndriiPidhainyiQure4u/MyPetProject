<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Entitiy\User;

use InvalidArgumentException;
use Modules\Auth\Entity\User\Status;
use PHPUnit\Framework\TestCase;

/**
 * @covers Status
 */
class StatusTest extends TestCase
{
    public function testWait(): void
    {
        $status = Status::wait();

        self::assertTrue($status->isWait());
        self::assertFalse($status->isActive());
    }

    public function testActive(): void
    {
        $status = Status::active();

        self::assertFalse($status->isWait());
        self::assertTrue($status->isActive());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Status('none');
    }
}
