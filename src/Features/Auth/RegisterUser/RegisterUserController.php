<?php

declare(strict_types=1);

namespace App\Features\Auth\RegisterUser;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

final class RegisterUserController extends AbstractController
{
    #[Route('/api/auth/register', name: 'auth_register', methods: ['POST'])]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: RegisterUserCommand::class),
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the registered user',
    )]
    #[OA\Response(
        response: 500,
        description: 'Error registering the user',
    )]
    #[OA\Tag(name: 'Auth')]
    public function __invoke(
        Request $request,
        RegisterUserAction $registerUserAction
    ): JsonResponse {
        $body = json_decode($request->getContent(), true);
        Assert::isArray($body);

        $registerUserAction(
            RegisterUserCommand::fromArray($body)
        );

        return new JsonResponse();
    }
}
