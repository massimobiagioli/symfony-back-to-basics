<?php

declare(strict_types=1);

namespace App\Features\Device\DeleteDevice;

use App\Shared\Device\DeviceNotFoundException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteDeviceController extends AbstractController
{
    #[Route('/api/device/{id}', name: 'device_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(
        response: 204,
        description: 'Device deleted',
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
        description: 'Error deleting the device',
    )]
    #[OA\Tag(name: 'Device')]
    public function __invoke(
        string $id,
        DeleteDeviceAction $deleteDeviceAction
    ): JsonResponse {
        try {
            $deleteDeviceAction($id);

            return new JsonResponse(status: Response::HTTP_NO_CONTENT);
        } catch (DeviceNotFoundException $e) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }
    }
}
