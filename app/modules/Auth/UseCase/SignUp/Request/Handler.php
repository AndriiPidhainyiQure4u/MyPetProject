<?php

declare(strict_types=1);

namespace Modules\Auth\UseCase\SignUp\Request;

use Modules\Auth\Entity\User\Email;
use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\User;
use Modules\Auth\Entity\User\UserRepository;
use Modules\Auth\Service\ConfirmTokenSender;
use Modules\Auth\Service\PasswordHasher;
use Modules\Auth\Service\Tokenizer;
use Modules\Flusher;

class Handler
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordHasher $hasher,
        private readonly Tokenizer $tokenizer,
        private readonly ConfirmTokenSender $sender,
        private readonly Flusher $flusher
    ) {
    }

    public function handle(Command $command): User
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('User already exists.');
        }

        $user = User::requestJoinByEmail(
            Id::generate(),
            new \DateTimeImmutable(),
            $email,
            $this->hasher->hash($command->password),
            $token = $this->tokenizer->generate(new \DateTimeImmutable())
        );

        $this->users->add($user);

        $this->sender->send($email, $token->getValue());
        $this->flusher->flush();

        return $user;
    }
}
