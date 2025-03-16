<?php

namespace CodebarAg\LaravelBeekeeper\Data\Configs;

use Illuminate\Support\Arr;

final class Reaction
{
    public static function make(array $data): self
    {
        return new self(
            cldrShortName: Arr::get($data, 'cldr_short_name'),
            name: Arr::get($data, 'name'),
            emoji: Arr::get($data, 'emoji'),
        );
    }

    public function __construct(
        public string $cldrShortName,
        public string $name,
        public string $emoji,
    ) {}
}
