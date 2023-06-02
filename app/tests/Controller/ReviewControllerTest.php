<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\Review;
use App\Tests\AbstractControllerTest;
use Doctrine\Common\Collections\ArrayCollection;

class ReviewControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function testReviews(): void
    {
        $book = $this->createBook();
        $this->createReview($book);

        $this->em->flush();

        $this->client->request('GET', '/api/v1/book/'.$book->getId().'/reviews');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items', 'rating', 'page', 'pages', 'perPage', 'total'],
            'properties' => [
                'rating' => ['type' => 'number'],
                'page' => ['type' => 'integer'],
                'pages' => ['type' => 'integer'],
                'perPage' => ['type' => 'integer'],
                'total' => ['type' => 'integer'],
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'content', 'author', 'rating', 'createdAt'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'rating' => ['type' => 'integer'],
                            'createdAt' => ['type' => 'integer'],
                            'content' => ['type' => 'string'],
                            'author' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    private function createBook(): Book
    {
        $book = (new Book())
            ->setTitle('Test book')
            ->setImage('http://localhost.png')
            ->setMeap(true)
            ->setIsbn('123321')
            ->setDescription('test')
            ->setPublicationDate(new \DateTimeImmutable())
            ->setAuthors(['Tester'])
            ->setCategories(new ArrayCollection([]))
            ->setSlug('test-book');

        $this->em->persist($book);

        return $book;
    }

    /**
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    private function createReview(Book $book): void
    {
        $this->em->persist((new Review())
            ->setAuthor('tester')
            ->setContent('test content')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setRating(5)
            ->setBook($book));
    }
}
