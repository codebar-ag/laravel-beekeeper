<?php

use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;
use CodebarAg\LaravelBeekeeper\Enums\Files\UsageType;
use CodebarAg\LaravelBeekeeper\Requests\CreateAChildToAnArtifact;
use CodebarAg\LaravelBeekeeper\Requests\CreateAPostInAGivenStream;
use CodebarAg\LaravelBeekeeper\Requests\DeleteAnArtifact;
use CodebarAg\LaravelBeekeeper\Requests\UploadAFileRequest;

test('regular identifiers are kept as they are in endpoints', function () {
    $id = '12345678-abcd-efgh-9012-de00edbf7b0b';

    expect((new DeleteAnArtifact(artifactId: $id))->resolveEndpoint())->toBe('/artifacts/'.$id)
        ->and((new CreateAChildToAnArtifact(artifactId: $id, name: 'Folder', type: Type::FOLDER))->resolveEndpoint())->toBe('/artifacts/'.$id.'/children')
        ->and((new CreateAPostInAGivenStream(streamId: '6002'))->resolveEndpoint())->toBe('/streams/6002/posts')
        ->and((new UploadAFileRequest(fileContent: 'x', fileName: 'x.txt', usageType: UsageType::ATTACHMENT_FILE->value))->resolveEndpoint())->toBe('/files/attachment_file');
})->group('unit');

test('path segments are encoded so they cannot change the endpoint', function () {
    expect((new DeleteAnArtifact(artifactId: '../files?x=1'))->resolveEndpoint())->toBe('/artifacts/..%2Ffiles%3Fx%3D1')
        ->and((new CreateAChildToAnArtifact(artifactId: '../streams', name: 'Folder', type: Type::FOLDER))->resolveEndpoint())->toBe('/artifacts/..%2Fstreams/children')
        ->and((new CreateAPostInAGivenStream(streamId: '1/../../config#'))->resolveEndpoint())->toBe('/streams/1%2F..%2F..%2Fconfig%23/posts')
        ->and((new UploadAFileRequest(fileContent: 'x', fileName: 'x.txt', usageType: 'avatar/../x'))->resolveEndpoint())->toBe('/files/avatar%2F..%2Fx');
})->group('unit');
