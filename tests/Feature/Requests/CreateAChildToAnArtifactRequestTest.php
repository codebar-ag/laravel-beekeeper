<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use CodebarAg\LaravelBeekeeper\Requests\CreateAChildToAnArtifact;
use Illuminate\Support\Collection;

test('can create a child to an artifact', closure: function () {
    $connector = new BeekeeperConnector;

    $response = $connector->send(new CreateAChildToAnArtifact(
        artifactId: '1b574087-e428-4640-a6c1-37a62fbf357f',
        name: Str::random(23).'.png',
        type: Type::FILE,
        parentId: '9a6d0642-fb9d-4f0f-9720-de00edbf7b0b',
        metadata: [
            'mimeType' => 'image/png',
            'url' => 'https://codebar.us.beekeeper.io/api/2/files/key/dc8da887-fec5-4022-914e-fa34091f3485',
            'userId' => 'd84bed15-2a56-41b4-8e6a-7ee731e2ce34',
            'key' => 'dc8da887-fec5-4022-914e-fa34091f3485',
            'id' => 22189080,
            'size' => 235978,
        ],
        adjustArtifactName: false,
        expand: []
    ));

    $child = $response->dto();

    expect($child)->toBeInstanceOf(Artifact::class)
        ->and($child->id)->toBeString()
        ->and($child->tenantId)->toBeString()
        ->and($child->name)->toBeString()
        ->and($child->type)->toBeInstanceOf(Type::class)
        ->and($child->parentId)->toBeString()
        ->and($child->metadata)->toBeInstanceOf(Collection::class)
        ->and($child->createdAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($child->updatedAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($child->breadcrumbs)->toBeInstanceOf(Collection::class)
        ->and($child->children)->toBeInstanceOf(Collection::class)
        ->and($child->acl)->toBeInstanceOf(Collection::class)
        ->and($child->filterData)->toBeInstanceOf(Collection::class);
})->group('upload')->only();
