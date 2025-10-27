<?php

namespace CodebarAg\LaravelBeekeeper\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteAnArtifact extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $artifactId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/artifacts/'.$this->artifactId;
    }
}
