<?php

declare(strict_types=1);

namespace App\Features\Device\DeactivateDevice;

use App\Shared\Device\DeviceNotFoundException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeactivateDeviceController extends AbstractController
{
    #[Route('/api/device/{id}/deactivate', name: 'device_deactivate', requirements: ['id' => '\d+'], methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Device deactivated',
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
        DeactivateDeviceAction $deactivateDeviceAction
    ): JsonResponse {
        try {
            $deactivateDeviceAction($id);

            return new JsonResponse(status: Response::HTTP_OK);
        } catch (DeviceNotFoundException $e) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }
    }
}
