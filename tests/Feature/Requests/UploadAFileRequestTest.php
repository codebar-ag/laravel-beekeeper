<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\Files\File;
use CodebarAg\LaravelBeekeeper\Enums\Files\Status;
use CodebarAg\LaravelBeekeeper\Enums\Files\UsageType;
use CodebarAg\LaravelBeekeeper\Requests\UploadAFileRequest;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

test('can upload a file', function () {
    $fileContent = file_get_contents(__DIR__.'/../../Fixtures/files/test-1.pdf');
    $fileName = 'test-1.pdf';

    Saloon::fake([
        UploadAFileRequest::class => MockResponse::make([
            'name' => $fileName,
            'status' => 'ready',
            'created' => '2023-01-01T00:00:00Z',
            'updated' => '2023-01-01T00:00:00Z',
            'url' => 'https://example.com/file.pdf',
            'userid' => 'user-123',
            'width' => null,
            'height' => null,
            'key' => 'file-key-123',
            'duration' => null,
            'media_type' => 'application/pdf',
            'usage_type' => 'attachment_file',
            'id' => 12345,
            'size' => strlen($fileContent),
            'versions' => [],
        ], 200),
    ]);

    $connector = new BeekeeperConnector;
    $response = $connector->send(new UploadAFileRequest(
        fileContent: $fileContent,
        fileName: $fileName,
    ));

    $uploadAFile = $response->dto();

    expect($uploadAFile)->toBeInstanceOf(File::class)
        ->and($uploadAFile->name)->toBe($fileName)
        ->and($uploadAFile->status)->toBe(Status::READY)
        ->and($uploadAFile->created)->toBeInstanceOf(CarbonImmutable::class)
        ->and($uploadAFile->updated)->toBeInstanceOf(CarbonImmutable::class)
        ->and($uploadAFile->url)->toBeString()
        ->and($uploadAFile->userId)->toBeString()
        ->and($uploadAFile->width)->toBeNull()
        ->and($uploadAFile->height)->toBeNull()
        ->and($uploadAFile->key)->toBeString()
        ->and($uploadAFile->duration)->toBeNull()
        ->and($uploadAFile->mediaType)->toBe('application/pdf')
        ->and($uploadAFile->usageType)->toBe(UsageType::ATTACHMENT_FILE)
        ->and($uploadAFile->id)->toBeInt()
        ->and($uploadAFile->size)->toBe(strlen($fileContent))
        ->and($uploadAFile->versions)->toBeInstanceOf(Collection::class);
})->group('upload');
