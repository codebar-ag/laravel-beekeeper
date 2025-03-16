<?php

namespace CodebarAg\LaravelBeekeeper\Data;

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Enums\Files\Status;
use CodebarAg\LaravelBeekeeper\Enums\Files\UsageType;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class File
{
    public static function make(array $data): self
    {
        return new self(
            name: Arr::get($data, 'name'),
            status: Status::tryFrom(Arr::get($data, 'status')),
            created: CarbonImmutable::parse(Arr::get($data, 'created')),
            updated: CarbonImmutable::parse(Arr::get($data, 'updated')),
            url: Arr::get($data, 'url'),
            userId: Arr::get($data, 'userid'),
            height: Arr::get($data, 'height'),
            width: Arr::get($data, 'width'),
            key: Arr::get($data, 'key'),
            duration: Arr::get($data, 'duration'),
            mediaType: Arr::get($data, 'media_type'),
            usageType: UsageType::tryFrom(Arr::get($data, 'usage_type')),
            id: Arr::get($data, 'id'),
            size: Arr::get($data, 'size'),
            versions: collect(Arr::get($data, 'versions', []))->map(fn (array $version) => FileVersion::make($version)),
        );
    }

    public function __construct(
        public string $name,
        public ?Status $status,
        public CarbonImmutable $created,
        public CarbonImmutable $updated,
        public string $url,
        public string $userId,
        public ?int $height,
        public ?int $width,
        public string $key,
        public ?int $duration,
        public string $mediaType,
        public ?UsageType $usageType,
        public int $id,
        public int $size,
        public Collection $versions,
    ) {}
}
