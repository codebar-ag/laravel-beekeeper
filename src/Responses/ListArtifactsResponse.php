<?php

namespace CodebarAg\LaravelBeekeeper\Responses;

use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Saloon\Http\Response;

final class ListArtifactsResponse
{
    /**
     * @throws \JsonException
     */
    public static function fromResponse(Response $response, Type $type): Collection|Enumerable
    {
        $data = $response->json();

        if (! $data) {
            throw new \Exception('No data found in response');
        }

        return collect($data)->map(function ($artifact) {
            return Artifact::make($artifact);
        });
    }
}
