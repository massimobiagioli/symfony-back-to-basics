<?php

declare(strict_types=1);

namespace App\Features\Device\GetDevice;

use Doctrine\DBAL\Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetDeviceController extends AbstractController
{
    #[Route('/api/device/{id}', name: 'device_get', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all devices',
        content: new OA\JsonContent(
            ref: new Model(type: DeviceDto::class)
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Unauthorized',
    )]
    #[OA\Tag(name: 'Device')]
    public function __invoke(
        string $id,
        GetDeviceAction $getDeviceAction,
    ): JsonResponse {
        try {
            return new JsonResponse($getDeviceAction($id));
        } catch (DeviceNotFoundException $e) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        } catch (GetDeviceException|Exception $e) {
            return new JsonResponse(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
