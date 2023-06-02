<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Repository\BookRepository;
use App\Tests\AbstractRepositoryTest;
use Doctrine\Common\Collections\ArrayCollection;

class BookRepositoryTest extends AbstractRepositoryTest
{
    private BookRepository $bookRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    public function testFindBooksCategoryId(): void
    {
        $devicesCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');
        $this->em->persist($devicesCategory);

        for ($i = 0; $i < 5; ++$i) {
            $book = $this->createBook('device-'.$i, $devicesCategory);
            $this->em->persist($book);
        }

        $this->em->flush();

        $this->assertCount(5, $this->bookRepository->findBooksCategoryId($devicesCategory->getId()));
    }

    private function createBook(string $title, BookCategory $category): Book
    {
        return (new Book())
            ->setPublicationDate(new \DateTimeImmutable())
            ->setAuthors(['author'])
            ->setMeap(false)
            ->setSlug($title)
            ->setDescription('test Description')
            ->setIsbn('12321')
            ->setCategories(new ArrayCollection([$category]))
            ->setTitle($title)
            ->setImage('http://localhost/'.$title.'.png');
    }
}
