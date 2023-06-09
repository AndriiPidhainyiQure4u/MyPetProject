<?php

declare(strict_types=1);

namespace Modules\Auth\Command\JoinByEmail\Confirm;

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
        if (!$user = $this->users->findByJoinConfirmToken($command->token)) {
            throw new \DomainException('Incorrect token.');
        }

        $user->confirmJoin($command->token, new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
