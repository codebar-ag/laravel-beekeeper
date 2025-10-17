<?php

namespace CodebarAg\LaravelBeekeeper\Data\Streams;

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Enums\Streams\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class Stream
{
    public static function make(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            tenantId: Arr::get($data, 'tenantId'),
            name: Arr::get($data, 'name'),
            description: Arr::get($data, 'description'),
            type: Type::tryFrom(Arr::get($data, 'type')),
            isPublic: Arr::get($data, 'isPublic', false),
            isArchived: Arr::get($data, 'isArchived', false),
            createdAt: Arr::has($data, 'createdAt') ? CarbonImmutable::createFromTimestampMs(Arr::get($data, 'createdAt')) : null,
            updatedAt: Arr::has($data, 'updatedAt') ? CarbonImmutable::createFromTimestampMs(Arr::get($data, 'updatedAt')) : null,
            createdBy: Arr::get($data, 'createdBy'),
            updatedBy: Arr::get($data, 'updatedBy'),
            posts: collect(Arr::get($data, 'posts', []))->map(fn (array $post) => Post::make($post)),
            subscribers: collect(Arr::get($data, 'subscribers', [])),
            permissions: collect(Arr::get($data, 'permissions', [])),
            metadata: collect(Arr::get($data, 'metadata', [])),
        );
    }

    public function __construct(
        public string $id,
        public string $tenantId,
        public string $name,
        public ?string $description,
        public ?Type $type,
        public bool $isPublic,
        public bool $isArchived,
        public ?CarbonImmutable $createdAt,
        public ?CarbonImmutable $updatedAt,
        public ?string $createdBy,
        public ?string $updatedBy,
        public Collection $posts,
        public Collection $subscribers,
        public Collection $permissions,
        public Collection $metadata,
    ) {}
}
