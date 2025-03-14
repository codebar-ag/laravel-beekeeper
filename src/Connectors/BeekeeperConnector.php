<?php

namespace CodebarAg\LaravelBeekeeper\Connectors;

use Exception;
use Illuminate\Support\Str;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

class BeekeeperConnector extends Connector
{
    private string $apiToken;

    private string $endpointPrefix;

    /**
     * @throws Exception
     */
    public function __construct(?string $apiToken = null, ?string $endpointPrefix = null)
    {
        $this->setToken($apiToken);
        $this->setEndpointPrefix($endpointPrefix);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://'.$this->endpointPrefix.'.beekeeper.io/api/2';
    }

    public function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator(token: $this->apiToken, prefix: 'Token');
    }

    /**
     * @throws Exception
     */
    private function setToken(?string $apiToken): void
    {
        if (empty($apiToken)) {
            if (empty(config('beekeeper.api_token'))) {
                throw new Exception('Beekeeper API Token is not set and no token was provided');
            }

            $apiToken = config('beekeeper.api_token');
        }

        $this->apiToken = $apiToken;
    }

    /**
     * @throws Exception
     */
    public function setEndpointPrefix(?string $endpointPrefix): void
    {
        if (empty($endpointPrefix)) {
            if (empty(config('beekeeper.endpoint_prefix'))) {
                throw new Exception('Beekeeper endpoint prefix is not set');
            }

            $endpointPrefix = config('beekeeper.endpoint_prefix');
        }

        $this->endpointPrefix = Str::of(string: $endpointPrefix)->trim()->rtrim(characters: '.')->toString();
    }
}
