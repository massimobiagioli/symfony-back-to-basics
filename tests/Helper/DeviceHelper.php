<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

class DeviceHelper
{
    public static function createDevice(
        KernelBrowser $client,
        array $deviceData,
    ) {
        $client->request(
            'POST',
            '/api/device',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($deviceData)
        );
    }

    public static function gelAllDevices(KernelBrowser $client): array
    {
        $client->request(
            'GET',
            '/api/device'
        );

        $content = $client->getResponse()->getContent();
        Assert::string($content);

        $content = json_decode($content, true);
        Assert::isArray($content);

        return $content;
    }

    public static function getDeviceById(
        KernelBrowser $client,
        string $deviceId,
    ): array {
        $content = $client->request(
            'GET',
            "/api/device/$deviceId"
        );

        $content = $client->getResponse()->getContent();
        Assert::string($content);

        $content = json_decode($content, true);
        Assert::isArray($content);

        return $content;
    }
}