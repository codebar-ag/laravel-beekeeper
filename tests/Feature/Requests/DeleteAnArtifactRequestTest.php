<?php

use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Requests\DeleteAnArtifact;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

test('can delete an artifact', function () {
    Saloon::fake([
        DeleteAnArtifact::class => MockResponse::make([], 204),
    ]);

    $connector = new BeekeeperConnector;
    $response = $connector->send(new DeleteAnArtifact(
        artifactId: '12345678-abcd-efgh-9012-de00edbf7b0b'
    ));

    expect($response->status())->toBe(204);
})->group('artifacts');
