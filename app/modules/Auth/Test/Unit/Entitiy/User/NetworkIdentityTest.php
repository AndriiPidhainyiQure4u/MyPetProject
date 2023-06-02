<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Entitiy\User;

use Modules\Auth\Entity\User\NetworkIdentity;
use PHPUnit\Framework\TestCase;

/**
 * @covers \NetworkIdentity
 */
class NetworkIdentityTest extends TestCase
{
    public function testSuccess(): void
    {
        $network = new NetworkIdentity($name = 'google', $identity = 'google-1');

        self::assertEquals($name, $network->getNetwork());
        self::assertEquals($identity, $network->getIdentity());
    }

    public function testEmptyName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new NetworkIdentity($name = '', $identity = 'google-1');
    }

    public function testEmptyIdentity(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new NetworkIdentity($name = 'google', $identity = '');
    }

    public function testEqual(): void
    {
        $network = new NetworkIdentity($name = 'google', $identity = 'google-1');

        self::assertTrue($network->isEqualTo(new NetworkIdentity($name, 'google-1')));
        self::assertFalse($network->isEqualTo(new NetworkIdentity($name, 'google-2')));
        self::assertFalse($network->isEqualTo(new NetworkIdentity('vk', 'vk-1')));
    }
}
