<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ChangePassword;

use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\UserRepository;
use Modules\Auth\Service\PasswordHasher;
use Modules\Flusher;

class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $user->changePassword(
            $command->current,
            $command->new,
            $this->hasher
        );

        $this->flusher->flush();
    }
}
