<?php

namespace CodebarAg\LaravelBeekeeper\Data;

use Illuminate\Support\Arr;

final class FileVersion
{
    public static function make(array $data): self
    {
        return new self(
            name: Arr::get($data, 'name'),
            url: Arr::get($data, 'url'),
            height: Arr::get($data, 'height'),
            width: Arr::get($data, 'width'),
        );
    }

    public function __construct(
        public string $name,
        public string $url,
        public int $height,
        public int $width,
    ) {}
}
