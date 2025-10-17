<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\Files\File;
use CodebarAg\LaravelBeekeeper\Data\Streams\Post;
use CodebarAg\LaravelBeekeeper\Requests\CreateAPostInAGivenStream;
use Illuminate\Support\Collection;

test('can create a post in a given stream with minimal data', closure: function () {
    $connector = new BeekeeperConnector;

    $response = $connector->send(new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Please indicate your preferred dates for next team event in the poll below. Thanks!'
    ));

    $post = $response->dto();

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->id)->toBeInt()
        ->and($post->text)->toBeString()
        ->and($post->streamId)->toBeInt()
        ->and($post->userId)->toBeString()
        ->and($post->uuid)->toBeString()
        ->and($post->labels)->toBeInstanceOf(Collection::class)
        ->and($post->files)->toBeInstanceOf(Collection::class)
        ->and($post->photos)->toBeInstanceOf(Collection::class)
        ->and($post->videos)->toBeInstanceOf(Collection::class)
        ->and($post->media)->toBeInstanceOf(Collection::class)
        ->and($post->options)->toBeInstanceOf(Collection::class)
        ->and($post->mentions)->toBeInstanceOf(Collection::class);
})->group('streams');

test('can create a post in a given stream with all optional parameters', closure: function () {
    $connector = new BeekeeperConnector;

    $fileData = [
        'updated' => '2016-10-07T12:49:21',
        'name' => 'fair_play_rules.pdf',
        'created' => '2016-10-07T12:49:21',
        'url' => 'https://mytenant.beekeeper.io/file/665987/original/fair_play_rules.pdf',
        'userid' => '5cb9v45d-8i78-4v65-b5fd-81cgfac3ef17',
        'height' => 619,
        'width' => 700,
        'duration' => 315,
        'key' => 'f4fdaab0-d198-49b4-b1cc-dd85572d72f1',
        'media_type' => 'image/png',
        'usage_type' => 'attachment_image',
        'id' => 66598,
        'size' => 85,
    ];

    $response = $connector->send(new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Please indicate your preferred dates for next team event in the poll below. Thanks!',
        title: 'Hello guys!',
        labels: ['food', 'poll', 'events'],
        sticky: true,
        locked: true,
        reactionsDisabled: true,
        scheduledAt: '2019-08-24T14:15:22',
        files: [$fileData],
        photos: [$fileData],
        videos: [$fileData],
        media: [$fileData],
        options: [
            ['text' => 'This Friday'],
            ['text' => 'Monday next week'],
        ]
    ));

    $post = $response->dto();

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->id)->toBeInt()
        ->and($post->text)->toBe('Please indicate your preferred dates for next team event in the poll below. Thanks!')
        ->and($post->title)->toBe('Hello guys!')
        ->and($post->streamId)->toBe(6002)
        ->and($post->labels)->toHaveCount(3)
        ->and($post->labels->toArray())->toBe(['food', 'poll', 'events'])
        ->and($post->sticky)->toBeTrue()
        ->and($post->locked)->toBeTrue()
        ->and($post->reactionsDisabled)->toBeTrue()
        ->and($post->scheduledAt)->toBeInstanceOf(CarbonImmutable::class)
        ->and($post->files)->toHaveCount(1)
        ->and($post->files->first())->toBeInstanceOf(File::class)
        ->and($post->photos)->toHaveCount(1)
        ->and($post->photos->first())->toBeInstanceOf(File::class)
        ->and($post->videos)->toHaveCount(1)
        ->and($post->videos->first())->toBeInstanceOf(File::class)
        ->and($post->media)->toHaveCount(1)
        ->and($post->media->first())->toBeInstanceOf(File::class)
        ->and($post->options)->toHaveCount(2)
        ->and($post->options->first())->toBe(['text' => 'This Friday'])
        ->and($post->options->last())->toBe(['text' => 'Monday next week']);
})->group('streams');

test('can create a post with collection parameters', closure: function () {
    $connector = new BeekeeperConnector;

    $fileData = [
        'updated' => '2016-10-07T12:49:21',
        'name' => 'test_file.pdf',
        'created' => '2016-10-07T12:49:21',
        'url' => 'https://mytenant.beekeeper.io/file/123456/original/test_file.pdf',
        'userid' => '5cb9v45d-8i78-4v65-b5fd-81cgfac3ef17',
        'height' => 100,
        'width' => 200,
        'duration' => 0,
        'key' => 'test-key-123',
        'media_type' => 'application/pdf',
        'usage_type' => 'attachment_file',
        'id' => 123456,
        'size' => 1024,
    ];

    $response = $connector->send(new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post with collections',
        labels: collect(['test', 'collection']),
        files: collect([$fileData]),
        options: collect([
            ['text' => 'Option 1'],
            ['text' => 'Option 2'],
        ])
    ));

    $post = $response->dto();

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->text)->toBe('Test post with collections')
        ->and($post->labels)->toHaveCount(2)
        ->and($post->labels->toArray())->toBe(['test', 'collection'])
        ->and($post->files)->toHaveCount(1)
        ->and($post->files->first())->toBeInstanceOf(File::class)
        ->and($post->options)->toHaveCount(2);
})->group('streams');

test('post response contains all expected fields', closure: function () {
    $connector = new BeekeeperConnector;

    $response = $connector->send(new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post for field validation',
        title: 'Test Title'
    ));

    $post = $response->dto();

    // Test core fields
    expect($post->id)->toBeInt()
        ->and($post->text)->toBeString()
        ->and($post->title)->toBeString()
        ->and($post->streamId)->toBeInt()
        ->and($post->userId)->toBeString()
        ->and($post->uuid)->toBeString()
        ->and($post->type)->toBeString()
        ->and($post->source)->toBeString();

    // Test boolean fields
    expect($post->sticky)->toBeBool()
        ->and($post->locked)->toBeBool()
        ->and($post->reactionsDisabled)->toBeBool()
        ->and($post->moderated)->toBeBool()
        ->and($post->edited)->toBeBool()
        ->and($post->subscribedByUser)->toBeBool()
        ->and($post->reportable)->toBeBool()
        ->and($post->anonymous)->toBeBool()
        ->and($post->unread)->toBeBool()
        ->and($post->postedByUser)->toBeBool()
        ->and($post->reportedByUser)->toBeBool()
        ->and($post->likedByUser)->toBeBool();

    // Test count fields
    expect($post->likeCount)->toBeInt()
        ->and($post->commentCount)->toBeInt()
        ->and($post->reportCount)->toBeInt()
        ->and($post->voteCount)->toBeInt()
        ->and($post->digest)->toBeInt();

    // Test collections
    expect($post->labels)->toBeInstanceOf(Collection::class)
        ->and($post->files)->toBeInstanceOf(Collection::class)
        ->and($post->photos)->toBeInstanceOf(Collection::class)
        ->and($post->videos)->toBeInstanceOf(Collection::class)
        ->and($post->media)->toBeInstanceOf(Collection::class)
        ->and($post->options)->toBeInstanceOf(Collection::class)
        ->and($post->mentions)->toBeInstanceOf(Collection::class);

    // Test optional fields
    expect($post->photo)->toBeStringOrNull()
        ->and($post->languageConfidence)->toBeFloatOrNull()
        ->and($post->metadata)->toBeStringOrNull()
        ->and($post->profile)->toBeStringOrNull()
        ->and($post->displayNameExtension)->toBeStringOrNull()
        ->and($post->displayName)->toBeStringOrNull()
        ->and($post->name)->toBeStringOrNull()
        ->and($post->language)->toBeStringOrNull()
        ->and($post->avatar)->toBeStringOrNull()
        ->and($post->status)->toBeStringOrNull()
        ->and($post->stateId)->toBeStringOrNull();

    // Test timestamps
    if ($post->created) {
        expect($post->created)->toBeInstanceOf(CarbonImmutable::class);
    }
    if ($post->scheduledAt) {
        expect($post->scheduledAt)->toBeInstanceOf(CarbonImmutable::class);
    }
})->group('streams');

test('request body structure is correct', closure: function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post',
        title: 'Test Title',
        labels: ['test', 'labels'],
        sticky: true,
        locked: false,
        reactionsDisabled: true,
        scheduledAt: '2019-08-24T14:15:22',
        files: [['test' => 'file']],
        options: [['text' => 'Option 1']]
    );

    // Use reflection to access the protected method for testing
    $reflection = new ReflectionClass($request);
    $method = $reflection->getMethod('defaultBody');
    $method->setAccessible(true);
    $body = $method->invoke($request);

    expect($body)->toBeArray()
        ->and($body)->toHaveKey('text')
        ->and($body['text'])->toBe('Test post')
        ->and($body)->toHaveKey('title')
        ->and($body['title'])->toBe('Test Title')
        ->and($body)->toHaveKey('labels')
        ->and($body['labels'])->toBe(['test', 'labels'])
        ->and($body)->toHaveKey('sticky')
        ->and($body['sticky'])->toBeTrue()
        ->and($body)->toHaveKey('reactions_disabled')
        ->and($body['reactions_disabled'])->toBeTrue()
        ->and($body)->toHaveKey('scheduled_at')
        ->and($body['scheduled_at'])->toBe('2019-08-24T14:15:22')
        ->and($body)->toHaveKey('files')
        ->and($body['files'])->toBe([['test' => 'file']])
        ->and($body)->toHaveKey('options')
        ->and($body['options'])->toBe([['text' => 'Option 1']])
        ->and($body)->not->toHaveKey('locked'); // Should not be included when false
})->group('streams');

test('request endpoint is correct', closure: function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post'
    );

    expect($request->resolveEndpoint())->toBe('/streams/6002/posts');
})->group('streams');

test('request query parameters are correct', closure: function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post',
        expand: ['user', 'stream']
    );

    // Use reflection to access the protected method for testing
    $reflection = new ReflectionClass($request);
    $method = $reflection->getMethod('defaultQuery');
    $method->setAccessible(true);
    $query = $method->invoke($request);

    expect($query)->toBeArray()
        ->and($query)->toHaveKey('expand')
        ->and($query['expand'])->toBe('user,stream');
})->group('streams');
