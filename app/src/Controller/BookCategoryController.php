<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\BookCategoryListResponse;
use App\Service\BookCategoryService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BookCategoryController extends AbstractController
{
    public function __construct(private BookCategoryService $bookCategoryService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns book categories",
     *
     *     @Model(type=BookCategoryListResponse::class)
     * )
     */
    #[Route('/api/v1/book/categories', name: 'get_categories', methods: ['GET'])]
    public function categories(): Response
    {
        return $this->json($this->bookCategoryService->getCategories(), Response::HTTP_OK);
    }
}
