<?php

namespace CodebarAg\LaravelBeekeeper\Requests;

use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Sort;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use CodebarAg\LaravelBeekeeper\Responses\ListArtifactsResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListArtifacts extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly Type $type = Type::FILE,
        protected readonly Sort $sort = Sort::NAME_ASC,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/artifacts/list';
    }

    protected function defaultQuery(): array
    {
        return [
            'type' => $this->type->value,
            'sort' => $this->sort->value,
            'limit' => $this->limit,
        ];
    }

    public function createDtoFromResponse(Response $response): Collection|Enumerable
    {
        return ListArtifactsResponse::fromResponse($response);
    }
}
