<?php

declare(strict_types=1);

namespace App\Features\User\GetUserInfo;

use App\Features\User\Shared\UserNotFoundException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class GetUserInfoController extends AbstractController
{
    #[Route('/api/user/me', name: 'user_info', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the current user',
        content: new OA\JsonContent(
            ref: new Model(type: GetUserInfoDto::class),
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Unauthorized',
    )]
    #[OA\Response(
        response: 500,
        description: 'Error retrieving current user',
    )]
    #[OA\Tag(name: 'User')]
    public function __invoke(
        GetUserInfoAction $getUserInfoAction,
        UserInterface $user,
    ): JsonResponse {
        try {
            return new JsonResponse($getUserInfoAction($user));
        } catch (UserNotFoundException $e) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }
    }
}
