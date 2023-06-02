<?php

declare(strict_types=1);

namespace Modules\Auth\Test\Unit\Builder;

use Modules\Auth\Entity\User\Email;
use Modules\Auth\Entity\User\Id;
use Modules\Auth\Entity\User\NetworkIdentity;
use Modules\Auth\Entity\User\Token;
use Modules\Auth\Entity\User\User;
use Ramsey\Uuid\Uuid;

class UserBuilder
{
    private Id $id;
    private Email $email;
    private string $hash;
    private \DateTimeImmutable $date;
    private Token $joinConfirmToken;
    private bool $active = false;

    private ?NetworkIdentity $networkIdentity = null;

    public function __construct()
    {
        $this->id = Id::generate();
        $this->email = new Email('mail@example.com');
        $this->hash = 'hash';
        $this->date = new \DateTimeImmutable();
        $this->joinConfirmToken = new Token(Uuid::uuid4()->toString(), $this->date->modify('+1 day'));
    }

    public function viaNetwork(NetworkIdentity $identity = null): self
    {
        $clone = clone $this;
        $clone->networkIdentity = $identity ?? new NetworkIdentity('vk', '0000001');

        return $clone;
    }

    public function withJoinConfirmToken(Token $token): self
    {
        $clone = clone $this;
        $clone->joinConfirmToken = $token;

        return $clone;
    }

    public function withEmail(Email $email): self
    {
        $clone = clone $this;
        $clone->email = $email;

        return $clone;
    }

    public function active(): self
    {
        $clone = clone $this;
        $clone->active = true;

        return $clone;
    }

    public function build(): User
    {
        if (null !== $this->networkIdentity) {
            return User::joinByNetwork(
                $this->id,
                $this->date,
                $this->email,
                $this->networkIdentity
            );
        }

        $user = User::requestJoinByEmail(
            $this->id,
            $this->date,
            $this->email,
            $this->hash,
            $this->joinConfirmToken
        );

        if ($this->active) {
            $user->confirmJoin(
                $this->joinConfirmToken->getValue(),
                $this->joinConfirmToken->getExpires()->modify('-1 day')
            );
        }

        return $user;
    }
}
