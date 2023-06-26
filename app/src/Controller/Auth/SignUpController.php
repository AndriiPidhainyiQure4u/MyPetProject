<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\SignUpRequest;
use App\Service\SignUpService;
use Modules\Auth\ReadModel\User\UserFetcher;
use Modules\Auth\UseCase\SignUp;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\ErrorResponse;
use App\Attribute\RequestBody;

class SignUpController extends AbstractController
{
    public function __construct
    (
        private readonly LoggerInterface $logger,
        private readonly UserFetcher $users,
        private readonly SignUpService $signUpService
    ) {
    }

    /**
     * @Route("/signup", name="auth.signup")
     *
     * @param Request $request
     * @param SignUp\Request\Handler $handler
     *
     * @return Response
     */
    public function request(Request $request, SignUp\Request\Handler $handler): Response
    {
        $command = new SignUp\Request\Command();

        $form = $this->createForm(SignUp\Request\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Check your email.');
                return $this->redirectToRoute('home');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/auth/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Signs up a user",
     *     @OA\JsonContent(
     *         @OA\Property(property="token", type="string"),
     *         @OA\Property(property="refresh_token", type="string")
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="User already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SignUpRequest::class))
     */
    #[Route(path: '/api/v1/auth/signUp', methods: ['POST'])]
    public function signUp(#[RequestBody] SignUpRequest $signUpRequest): Response
    {
        return $this->signUpService->signUp($signUpRequest);
    }

    /**
     * @Route("/signup/{token}", name="auth.signup.confirm")
     *
     * @param string $token
     * @param SignUp\Confirm\ByToken\Handler $handler
     *
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function confirm(string $token, SignUp\Confirm\ByToken\Handler $handler): Response
    {
        if (!$this->users->findBySignUpConfirmToken($token)) {
            $this->addFlash('error', 'Incorrect or already confirmed token.');
            return $this->redirectToRoute('auth.signup');
        }

        $command = new SignUp\Confirm\ByToken\Command($token);

        try {
            $handler->handle($command);

        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('auth.signup');
        }

        return new Response();
    }
}
