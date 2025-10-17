<?php

namespace CodebarAg\LaravelBeekeeper\Data\Configs;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;

final class General
{
    public static function make(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            companyAccount: Arr::get($data, 'company_account'),
            name: Arr::get($data, 'name'),
            language: Arr::get($data, 'language'),
            created: CarbonImmutable::parse(Arr::get($data, 'created')),
            url: Arr::get($data, 'url'),
            tagline: Arr::get($data, 'tagline'),
            fqdn: Arr::get($data, 'fqdn'),
            supportEmail: Arr::get($data, 'support_email'),
            isDataSecurityContactSet: Arr::get($data, 'is_data_security_contact_set'),
            timezone: Arr::get($data, 'timezone'),
            subdomain: Arr::get($data, 'subdomain'),
        );
    }

    public function __construct(
        public int $id,
        public ?string $companyAccount,
        public string $name,
        public string $language,
        public CarbonImmutable $created,
        public string $url,
        public string $tagline,
        public string $fqdn,
        public string $supportEmail,
        public bool $isDataSecurityContactSet,
        public string $timezone,
        public string $subdomain,
    ) {}
}
