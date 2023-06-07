<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\RecommendedBookListResponse;
use App\Service\Recommendation\RecommendationApiService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecommendationController extends AbstractController
{
    public function __construct(private readonly RecommendationApiService $recommendationService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns recommendations for the book",
     *     @Model(type=RecommendedBookListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/book/{id}/recommendations', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns recommendations for the book', attachables: [new Model(type: RecommendedBookListResponse::class)])]
    public function recommendationsByBookId(int $id): Response
    {
        return $this->json($this->recommendationService->getRecommendationsByBookId($id));
    }
}
