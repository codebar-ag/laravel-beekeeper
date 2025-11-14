<?php

namespace CodebarAg\LaravelBeekeeper\Requests;

use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use CodebarAg\LaravelBeekeeper\Responses\CreateAChildToAnArtifactResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateAChildToAnArtifact extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $artifactId,
        protected readonly string $name,
        protected readonly Type $type,
        protected readonly ?string $parentId = null,
        protected null|array|Collection $metadata = null,
        protected readonly bool $adjustArtifactName = false,
        protected readonly array|Collection $expand = [],

    ) {}

    public function resolveEndpoint(): string
    {
        return '/artifacts/'.$this->artifactId.'/children';
    }

    protected function defaultQuery(): array
    {
        $expand = $this->expand;

        if ($expand instanceof Collection) {
            $expand = $expand->toArray();
        }

        return [
            'adjust_artifact_name' => $this->adjustArtifactName,
            'expand' => implode(',', $expand),
        ];
    }

    public function defaultBody(): array
    {

        $body = [
            'name' => $this->name,
            'type' => $this->type,
        ];

        if (! empty($this->parentId)) {
            $body = Arr::add(array: $body, key: 'parentId', value: $this->parentId);
        }

        $metadata = $this->metadata;

        if ($metadata instanceof Collection) {
            $metadata = $metadata->toArray();
        }

        if ($this->type == Type::FILE && ! empty($metadata)) {
            $body = Arr::add(array: $body, key: 'metadata', value: $metadata);
        }

        return $body;
    }

    public function createDtoFromResponse(Response $response): Artifact
    {
        return CreateAChildToAnArtifactResponse::fromResponse($response);
    }
}
