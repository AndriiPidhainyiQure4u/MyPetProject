<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ResetPassword\Request;

use Modules\Auth\Entity\User\Email;
use Modules\Auth\Entity\User\UserRepository;
use Modules\Auth\Service\PasswordResetTokenSender;
use Modules\Auth\Service\Tokenizer;
use Modules\Flusher;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private Flusher $flusher;
    private PasswordResetTokenSender $sender;

    public function __construct(
        UserRepository $users,
        Tokenizer $tokenizer,
        Flusher $flusher,
        PasswordResetTokenSender $sender
    ) {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        $user = $this->users->getByEmail($email);

        $date = new \DateTimeImmutable();

        $user->requestPasswordReset(
            $token = $this->tokenizer->generate($date),
            $date
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
