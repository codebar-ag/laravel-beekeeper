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
        protected readonly ?string $fileContent,
        protected readonly ?string $fileName,

    ) {}

    public function resolveEndpoint(): string
    {
        return '/files';
    }

    protected function defaultBody(): array
    {
        return [
            new MultipartValue(name: 'file', value: $this->fileContent, filename: $this->fileName),
        ];
    }

    public function createDtoFromResponse(Response $response): File
    {
        return UploadAFileResponse::fromResponse($response);
    }
}
