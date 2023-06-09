<?php

declare(strict_types=1);

namespace Modules\Auth\Command\AttachNetwork;

use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\Network;
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
        $identity = new Network($command->network, $command->identity);

        if ($this->users->hasByNetwork($identity)) {
            throw new \DomainException('User with this name already exists.');
        }

        $user = $this->users->get(new Id($command->id));

        $user->attachNetwork($identity);

        $this->flusher->flush();
    }
}
