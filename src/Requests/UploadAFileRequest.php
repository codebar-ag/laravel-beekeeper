<?php

namespace CodebarAg\LaravelBeekeeper\Requests;

use CodebarAg\LaravelBeekeeper\Data\Files\File;
use CodebarAg\LaravelBeekeeper\Responses\UploadAFileResponse;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasMultipartBody;

class UploadAFileRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $fileContent,
        protected readonly string $fileName,
        protected readonly string $usageType,

    ) {}

    public function resolveEndpoint(): string
    {
        return '/files/'.$this->usageType;
    }

    protected function defaultBody(): array
    {
        $defaultBody = [
            new MultipartValue(name: 'file', value: $this->fileContent, filename: $this->fileName),
        ];

        return $defaultBody;
    }

    public function createDtoFromResponse(Response $response): File
    {
        return UploadAFileResponse::fromResponse($response);
    }
}
