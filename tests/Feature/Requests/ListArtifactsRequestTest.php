<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Sort;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use CodebarAg\LaravelBeekeeper\Requests\ListArtifacts;
use Illuminate\Support\Collection;

test('can get status of authenticated user', function () {
    $connector = new BeekeeperConnector;

    $response = $connector->send(new ListArtifacts(
        type: Type::FOLDER,
        sort: Sort::NAME_ASC,
        limit: 20,
    ));

    $listArtifacts = $response->dto();

    ray($listArtifacts);

    expect($listArtifacts)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first())->toBeInstanceOf(Artifact::class)
        ->and($listArtifacts->first()->id)->toBeString()
        ->and($listArtifacts->first()->tenantId)->toBeString()
        ->and($listArtifacts->first()->name)->toBeString()
        ->and($listArtifacts->first()->type)->toBeInstanceOf(Type::class)
        ->and($listArtifacts->first()->parentId)->toBeString()
        ->and($listArtifacts->first()->metadata)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->createdAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($listArtifacts->first()->updatedAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($listArtifacts->first()->breadcrumbs)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->children)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->acl)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->filterData)->toBeInstanceOf(Collection::class);
})->group('artifacts');
