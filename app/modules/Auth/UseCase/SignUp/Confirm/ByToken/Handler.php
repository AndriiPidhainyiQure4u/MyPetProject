<?php

declare(strict_types=1);


namespace Modules\Auth\UseCase\SignUp\Confirm\ByToken;

use Modules\Auth\Entity\User\UserRepository;
use Modules\Flusher;

class Handler
{
    public function __construct(private readonly UserRepository $users, private readonly Flusher $flusher)
    {
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findByConfirmToken($command->token)) {
            throw new \DomainException('Incorrect or confirmed token.');
        }

        $user->confirmSignUp();

        $this->flusher->flush();
    }
}
