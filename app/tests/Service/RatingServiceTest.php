<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Repository\ReviewRepository;
use App\Service\RatingService;
use App\Tests\AbstractTestCase;

class RatingServiceTest extends AbstractTestCase
{
    private ReviewRepository $reviewRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reviewRepository = $this->createMock(ReviewRepository::class);
    }

    public function dataProvider(): array
    {
        return [
            [25, 20, 1.25],
            [0, 5, 0],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCalcReviewRatingForBook(int $repositoryRatingSum, int $total, float $expectedRating): void
    {
        $this->reviewRepository->expects($this->once())
            ->method('getBookTotalRatingSum')
            ->with(1)
            ->willReturn($repositoryRatingSum);

        $actual = (new RatingService($this->reviewRepository))->calcReviewRatingForBook(1, $total);

        $this->assertEquals($expectedRating, $actual);
    }

    public function testCalcReviewRatingForBookZeroTotal(): void
    {
        $this->reviewRepository->expects($this->never())->method('getBookTotalRatingSum');

        $this->assertEquals(
            0,
            (new RatingService($this->reviewRepository))->calcReviewRatingForBook(1, 0)
        );
    }
}
