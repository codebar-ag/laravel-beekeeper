<?php

namespace CodebarAg\LaravelBeekeeper\Responses;

use CodebarAg\LaravelBeekeeper\Data\File;
use Saloon\Http\Response;

final class UploadAFileResponse
{
    /**
     * @throws \JsonException
     */
    public static function fromResponse(Response $response): File
    {
        $data = $response->json();

        if (! $data) {
            throw new \Exception('No data found in response');
        }

        return File::make($data);
    }
}
