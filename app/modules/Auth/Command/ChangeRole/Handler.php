<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ChangeRole;

use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\Role;
use Modules\Auth\Entity\User\UserRepository;
use Modules\Flusher;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $user->changeRole(
            new Role($command->role)
        );

        $this->flusher->flush();
    }
}
