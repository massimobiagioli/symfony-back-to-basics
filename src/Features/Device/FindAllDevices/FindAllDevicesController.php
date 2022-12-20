<?php

declare(strict_types=1);

namespace App\Features\Device\FindAllDevices;

use Doctrine\DBAL\Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class FindAllDevicesController extends AbstractController
{
    #[Route('/api/device', name: 'device_find_all', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all devices',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: DeviceDto::class))
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Unauthorized',
    )]
    #[OA\Tag(name: 'Device')]
    public function __invoke(
        FindAllDevicesAction $findAllDevicesAction
    ): JsonResponse {
        try {
            return new JsonResponse($findAllDevicesAction());
        } catch (FindAllDevicesException|Exception $e) {
            return new JsonResponse(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
