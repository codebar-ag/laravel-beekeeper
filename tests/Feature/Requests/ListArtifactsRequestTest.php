<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Sort;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use CodebarAg\LaravelBeekeeper\Requests\ListArtifacts;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

test('can list artifacts', function () {
    Saloon::fake([
        ListArtifacts::class => MockResponse::make([
            [
                'id' => 'artifact-123',
                'tenantId' => 'tenant-123',
                'name' => 'Test Folder',
                'type' => 'folder',
                'parentId' => null,
                'metadata' => [],
                'createdAt' => '2023-01-01T00:00:00Z',
                'updatedAt' => '2023-01-01T00:00:00Z',
                'breadcrumbs' => [],
                'children' => [],
                'acl' => [],
                'filterData' => [],
            ],
        ], 200),
    ]);

    $connector = new BeekeeperConnector;
    $response = $connector->send(new ListArtifacts(
        type: Type::FOLDER,
        sort: Sort::NAME_ASC,
        limit: 20,
    ));

    $listArtifacts = $response->dto();

    expect($listArtifacts)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first())->toBeInstanceOf(Artifact::class)
        ->and($listArtifacts->first()->id)->toBeString()
        ->and($listArtifacts->first()->tenantId)->toBeString()
        ->and($listArtifacts->first()->name)->toBeString()
        ->and($listArtifacts->first()->type)->toBeInstanceOf(Type::class)
        ->and($listArtifacts->first()->parentId)->toBeNull()
        ->and($listArtifacts->first()->metadata)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->createdAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($listArtifacts->first()->updatedAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($listArtifacts->first()->breadcrumbs)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->children)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->acl)->toBeInstanceOf(Collection::class)
        ->and($listArtifacts->first()->filterData)->toBeInstanceOf(Collection::class);
})->group('artifacts');
