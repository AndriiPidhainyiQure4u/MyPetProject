<?php

declare(strict_types=1);

namespace Modules\Auth\Entity\User;

interface UserRepository
{
    public function hasByEmail(Email $email): bool;

    /**
     * find return user or null | get return 100 percent or throw exception.
     */
    public function findByJoinConfirmToken(string $token): ?User;

    public function hasByNetwork(NetworkIdentity $identity): bool;

    /**
     * @throws \DomainException
     */
    public function get(Id $id): User;

    /**
     * @throws \DomainException
     */
    public function getByEmail(Email $email): User;

    public function add(User $user): void;

    public function findByPasswordResetToken(string $token): ?User;

    public function findByNewEmailToken(string $token): ?User;
}
