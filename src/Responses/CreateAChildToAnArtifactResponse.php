<?php

namespace CodebarAg\LaravelBeekeeper\Responses;

use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use Exception;
use Illuminate\Support\Arr;
use Saloon\Http\Response;

final class CreateAChildToAnArtifactResponse
{
    /**
     * @throws \JsonException
     * @throws Exception
     */
    public static function fromResponse(Response $response): Artifact
    {
        $data = $response->json();

        if (! $data) {
            throw new Exception('No data found in response');
        }

        if (! $response->successful()) {
            throw new Exception(
                sprintf(
                    '%s: %s - %s',
                    'Request was not successful: ',
                    Arr::get($data, 'error.code', 'Unknown Error Code'),
                    Arr::get($data, 'error.message', 'Unknown Error Message'),
                )
            );
        }

        return Artifact::make($data);
    }
}
