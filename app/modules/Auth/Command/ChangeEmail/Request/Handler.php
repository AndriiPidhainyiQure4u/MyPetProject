<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ChangeEmail\Request;

use Modules\Auth\Entity\User\Email;
use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\UserRepository;
use Modules\Auth\Service\NewEmailConfirmTokenSender;
use Modules\Auth\Service\Tokenizer;
use Modules\Flusher;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private NewEmailConfirmTokenSender $sender;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        Tokenizer $tokenizer,
        NewEmailConfirmTokenSender $sender,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('Email is already in use.');
        }

        $date = new \DateTimeImmutable();

        $user->requestEmailChanging(
            $token = $this->tokenizer->generate($date),
            $date,
            $email,
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
