<?php

declare(strict_types=1);


namespace Modules\Auth\ReadModel\User;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;


final class UserFetcher
{
    public function __construct(private readonly Connection $connection, private readonly EntityManagerInterface $em)
    {
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function existsByResetToken(string $token): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (*)')
                ->from('auth_users')
                ->where('reset_token_token = :token')
                ->setParameter(':token', $token)
                ->executeQuery()->fetchFirstColumn() > 0;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function findBySignUpConfirmToken(string $token): ?ShortView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'email',
                'role',
                'status'
            )
            ->from('auth_users')
            ->where('join_confirm_token_value = :token')
            ->setParameter('token', $token)
            ->executeQuery();

      //   $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, ShortView::class);

        $result = $stmt->fetchAllAssociative();

        return $result ?: null;
    }

}
