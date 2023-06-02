<?php

namespace App\Repository;

use App\Entity\BookCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

class BookCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookCategory::class);
    }

    /**
     * @return BookCategory[]
     */
    public function findAllSortedByTitle(): array
    {
        return $this->findBy([], ['title' => Criteria::ASC]);
    }

    public function existsById(int $id): bool
    {
        return null !== $this->find($id);
    }
}
