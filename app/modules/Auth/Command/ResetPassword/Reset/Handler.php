<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ResetPassword\Reset;

use Modules\Auth\Entity\User\UserRepository;
use Modules\Auth\Service\PasswordHasher;
use Modules\Flusher;

class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Flusher $flusher;

    public function __construct(UserRepository $users, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findByPasswordResetToken($command->token)) {
            throw new \DomainException('Token is not found.');
        }

        $user->resetPassword(
            $command->token,
            new \DateTimeImmutable(),
            $this->hasher->hash($command->password)
        );

        $this->flusher->flush();
    }
}
