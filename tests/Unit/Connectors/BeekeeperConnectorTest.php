<?php

use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;

test('builds the base url from the endpoint prefix', function (string $prefix, string $expected) {
    $connector = new BeekeeperConnector(apiToken: 'TOKEN', endpointPrefix: $prefix);

    expect($connector->resolveBaseUrl())->toBe($expected);
})->with([
    ['acme', 'https://acme.beekeeper.io/api/2'],
    [' acme. ', 'https://acme.beekeeper.io/api/2'],
    ['acme-test.eu', 'https://acme-test.eu.beekeeper.io/api/2'],
])->group('unit');

test('uses the configured endpoint prefix when none is passed', function () {
    config()->set('beekeeper.endpoint_prefix', 'configured');

    expect((new BeekeeperConnector(apiToken: 'TOKEN'))->resolveBaseUrl())->toBe('https://configured.beekeeper.io/api/2');
})->group('unit');

test('rejects an endpoint prefix that would change the host', function (string $prefix) {
    new BeekeeperConnector(apiToken: 'TOKEN', endpointPrefix: $prefix);
})->with([
    'evil.example/x?',
    'evil.example#',
    'user@evil.example',
    'evil.example:443/',
    'https://acme',
    'ac me',
])->throws(Exception::class, 'Beekeeper endpoint prefix is invalid')->group('unit');

test('rejects an invalid configured endpoint prefix', function () {
    config()->set('beekeeper.endpoint_prefix', 'evil.example/');

    new BeekeeperConnector(apiToken: 'TOKEN');
})->throws(Exception::class, 'Beekeeper endpoint prefix is invalid')->group('unit');
