<?php

declare(strict_types=1);

namespace App\Features\Device\CreateDevice;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

final class CreateDeviceController extends AbstractController
{
    #[Route('/api/device', name: 'device_create', methods: ['POST'])]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateDeviceCommand::class),
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Device created',
    )]
    #[OA\Response(
        response: 500,
        description: 'Error creating the device',
    )]
    #[OA\Tag(name: 'Auth')]
    public function __invoke(
        Request $request,
        CreateDeviceAction $createDeviceAction
    ): JsonResponse {
        $body = json_decode($request->getContent(), true);
        Assert::isArray($body);

        $createDeviceAction(
            CreateDeviceCommand::fromArray($body)
        );

        return new JsonResponse(status: Response::HTTP_CREATED);
    }
}
