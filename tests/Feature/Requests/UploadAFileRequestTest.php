<?php

use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\File;
use CodebarAg\LaravelBeekeeper\Requests\UploadAFileRequest;

test('can get status of authenticated user', function () {
    $connector = new BeekeeperConnector;

    $fileContent = file_get_contents(__DIR__.'/../../Fixtures/files/test-1.pdf');
    $fileName = 'test-1.pdf';

    $response = $connector->send(new UploadAFileRequest(
        fileContent: $fileContent,
        fileName: $fileName,
    ));

    $uploadAFile = $response->dto();

    ray($uploadAFile);

    expect($uploadAFile)->toBeInstanceOf(File::class);
})->group('user')->only();
