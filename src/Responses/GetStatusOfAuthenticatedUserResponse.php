<?php

namespace CodebarAg\LaravelBeekeeper\Responses;

use CodebarAg\LaravelBeekeeper\Data\Configs\AuthenticatedUserStatus;
use Saloon\Http\Response;

final class GetStatusOfAuthenticatedUserResponse
{
    /**
     * @throws \JsonException
     */
    public static function fromResponse(Response $response): AuthenticatedUserStatus
    {
        $data = $response->json();

        if (! $data) {
            throw new \Exception('No data found in response');
        }

        return AuthenticatedUserStatus::make($data);
    }
}
