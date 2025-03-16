<?php

namespace CodebarAg\LaravelBeekeeper\Data\Artifacts;

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class Artifact
{
    public static function make(array $data): self
    {
        ray($data);

        return new self(
            id: Arr::get($data, 'id'),
            tenantId: Arr::get($data, 'tenantId'),
            name: Arr::get($data, 'name'),
            type: Type::tryFrom(Arr::get($data, 'type')),
            parentId: Arr::get($data, 'parentId'),
            metadata: collect(Arr::get($data, 'metadata', [])),
            createdAt: CarbonImmutable::createFromTimestampMs(Arr::get($data, 'created_at')),
            updatedAt: CarbonImmutable::createFromTimestampMs(Arr::get($data, 'updated_at')),
            breadcrumbs: collect(Arr::get($data, 'breadcrumbs', [])),
            children: collect(Arr::get($data, 'children', []))->map(fn (array $child) => Artifact::make($child)),
            acl: collect(Arr::get($data, 'acl', [])),
            filterData: collect(Arr::get($data, 'filter_data', [])),
        );
    }

    public function __construct(
        public string $id,
        public string $tenantId,
        public string $name,
        public Type $type,
        public ?string $parentId,
        public Collection $metadata,
        public CarbonImmutable $createdAt,
        public CarbonImmutable $updatedAt,
        public Collection $breadcrumbs,
        public Collection $children,
        public Collection $acl,
        public Collection $filterData,
    ) {}
}
