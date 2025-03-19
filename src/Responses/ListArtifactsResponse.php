<?php

namespace CodebarAg\LaravelBeekeeper\Responses;

use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Saloon\Http\Response;

final class ListArtifactsResponse
{
    /**
     * @throws \JsonException
     */
    public static function fromResponse(Response $response): Collection|Enumerable
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

        return collect($data)->map(function ($artifact) {
            return Artifact::make($artifact);
        });
    }
}
