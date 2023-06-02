<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Entitiy\User\User\JoinByEmail;

use Modules\Auth\Entity\User\Email;
use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\NetworkIdentity;
use Modules\Auth\Entity\User\Role;
use Modules\Auth\Entity\User\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \User
 */
class JoinByNetworkTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::joinByNetwork(
            $id = Id::generate(),
            $date = new \DateTimeImmutable(),
            $email = new Email('email@app.test'),
            $network = new NetworkIdentity('vk', '0000001')
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($date, $user->getDate());
        self::assertEquals($email, $user->getEmail());

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());

        self::assertEquals(Role::USER, $user->getRole()->getName());

        self::assertCount(1, $networks = $user->getNetworks());
        self::assertEquals($network, $networks[0] ?? null);
    }
}
