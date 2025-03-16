<?php

declare(strict_types=1);

namespace CodebarAg\LaravelBeekeeper\Requests;

use CodebarAg\LaravelBeekeeper\Data\Configs\AuthenticatedUserStatus;
use CodebarAg\LaravelBeekeeper\Responses\GetStatusOfAuthenticatedUserResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;

class GetStatusOfAuthenticatedUserRequest extends Request
{
    use AcceptsJson;

    protected Method $method = Method::GET;

    public function __construct() {}

    /**
     * @throws \Exception
     */
    public function resolveEndpoint(): string
    {
        return 'config';
    }

    /**
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): AuthenticatedUserStatus
    {
        return GetStatusOfAuthenticatedUserResponse::fromResponse($response);
    }
}
