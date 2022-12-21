<?php

declare(strict_types=1);

namespace App\Features\Device\ActivateDevice;

use App\Shared\Device\DeviceNotFoundException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ActivateDeviceController extends AbstractController
{
    #[Route('/api/device/{id}/activate', name: 'device_activate', requirements: ['id' => '\d+'], methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Device activated',
    )]
    #[OA\Response(
        response: 401,
        description: 'Unauthorized',
    )]
    #[OA\Response(
        response: 404,
        description: 'Device not found',
    )]
    #[OA\Response(
        response: 500,
        description: 'Error creating the device',
    )]
    #[OA\Tag(name: 'Device')]
    public function __invoke(
        string $id,
        ActivateDeviceAction $activateDeviceAction
    ): JsonResponse {
        try {
            $activateDeviceAction($id);

            return new JsonResponse(status: Response::HTTP_OK);
        } catch (DeviceNotFoundException $e) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }
    }
}
