<?php

declare(strict_types=1);

namespace App\Features\Device\UpdateDevice;

use App\Shared\Device\DeviceNotFoundException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

final class UpdateDeviceController extends AbstractController
{
    #[Route('/api/device/{id}', name: 'device_update', requirements: ['id' => '\d+'], methods: ['UPDATE'])]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateDeviceCommand::class),
        )
    )]
    #[OA\Response(
        response: 204,
        description: 'Device updated',
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
        Request $request,
        string $id,
        UpdateDeviceAction $updateDeviceAction
    ): JsonResponse {
        $body = json_decode($request->getContent(), true);
        Assert::isArray($body);

        try {
            $updateDeviceAction(
                $id,
                UpdateDeviceCommand::fromArray($body)
            );

            return new JsonResponse(status: Response::HTTP_NO_CONTENT);
        } catch (DeviceNotFoundException $e) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }
    }
}
