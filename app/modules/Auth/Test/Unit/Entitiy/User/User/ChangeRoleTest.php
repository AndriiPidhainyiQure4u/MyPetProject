<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Entitiy\User\User;

use Modules\Auth\Entity\User\Role;
use Modules\Auth\Test\Unit\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class ChangeRoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->build();

        $user->changeRole($role = new Role(Role::ADMIN));

        self::assertEquals($role, $user->getRole());
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->build();
        $this->expectExceptionMessage('Role is already same.');

        $user->changeRole(Role::user());

    }
}
