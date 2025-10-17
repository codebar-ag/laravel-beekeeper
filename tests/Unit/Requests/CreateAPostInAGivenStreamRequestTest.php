<?php

use CodebarAg\LaravelBeekeeper\Data\Files\File;
use CodebarAg\LaravelBeekeeper\Data\Streams\Post;
use CodebarAg\LaravelBeekeeper\Requests\CreateAPostInAGivenStream;
use CodebarAg\LaravelBeekeeper\Responses\CreateAPostInAGivenStreamResponse;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

test('can create request with minimal parameters', function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post content'
    );

    expect($request->resolveEndpoint())->toBe('/streams/6002/posts');
})->group('unit');

test('can create request with all parameters', function () {
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

    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post content',
        title: 'Test Title',
        labels: ['test', 'labels'],
        sticky: true,
        locked: true,
        reactionsDisabled: true,
        scheduledAt: '2019-08-24T14:15:22',
        files: [$fileData],
        photos: [$fileData],
        videos: [$fileData],
        media: [$fileData],
        options: [
            ['text' => 'Option 1'],
            ['text' => 'Option 2'],
        ],
        expand: ['user', 'stream']
    );

    expect($request->resolveEndpoint())->toBe('/streams/6002/posts');
})->group('unit');

test('request body contains correct data', function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post content',
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
        ->and($body['text'])->toBe('Test post content')
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
})->group('unit');

test('request body handles collections correctly', function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post content',
        labels: collect(['test', 'collection']),
        files: collect([['test' => 'file']]),
        options: collect([
            ['text' => 'Option 1'],
            ['text' => 'Option 2'],
        ])
    );

    // Use reflection to access the protected method for testing
    $reflection = new ReflectionClass($request);
    $method = $reflection->getMethod('defaultBody');
    $method->setAccessible(true);
    $body = $method->invoke($request);

    expect($body)->toBeArray()
        ->and($body['labels'])->toBe(['test', 'collection'])
        ->and($body['files'])->toBe([['test' => 'file']])
        ->and($body['options'])->toBe([
            ['text' => 'Option 1'],
            ['text' => 'Option 2'],
        ]);
})->group('unit');

test('request query parameters are correct', function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post content',
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
})->group('unit');

test('request query parameters handle collections', function () {
    $request = new CreateAPostInAGivenStream(
        streamId: '6002',
        text: 'Test post content',
        expand: collect(['user', 'stream', 'files'])
    );

    // Use reflection to access the protected method for testing
    $reflection = new ReflectionClass($request);
    $method = $reflection->getMethod('defaultQuery');
    $method->setAccessible(true);
    $query = $method->invoke($request);

    expect($query)->toBeArray()
        ->and($query)->toHaveKey('expand')
        ->and($query['expand'])->toBe('user,stream,files');
})->group('unit');

test('post data mapping works correctly', function () {
    $postData = [
        'id' => 2234,
        'text' => 'Please indicate your preferred dates for next team event in the poll below. Thanks!',
        'labels' => ['food', 'poll', 'events'],
        'sticky' => true,
        'like_count' => 42,
        'streamid' => 6002,
        'digest' => 1,
        'user_id' => '5cb9v45d-8i78-4v65-b5fd-81cgfac3ef17',
        'uuid' => '731b28bc-7f10-4b68-a089-fc672abc9955',
        'title' => 'Hello guys!',
        'comment_count' => 2,
        'report_count' => 0,
        'source' => 'beekeeper',
        'vote_count' => 12,
        'moderated' => true,
        'photo' => 'https://d6698txzbomp3.cloudfront.net/72e3b7d4-c6a4-47e9-8f81-7b7d10bdd84a',
        'language_confidence' => 0.86,
        'type' => 'post',
        'metadata' => 'string',
        'profile' => 'peter_smith',
        'edited' => true,
        'display_name_extension' => 'General Manager',
        'subscribed_by_user' => true,
        'reportable' => true,
        'anonymous' => true,
        'display_name' => 'John Smith',
        'unread' => true,
        'locked' => true,
        'reactions_disabled' => true,
        'name' => 'Peter Smith',
        'language' => 'en',
        'language_information' => [
            'language' => 'en',
            'confidence' => 0.99628,
            'reliable' => true,
        ],
        'created' => '2016-10-07T12:48:27',
        'posted_by_user' => true,
        'avatar' => 'https://dz343oy86h947.cloudfront.net/business/neutral/normal/05.png',
        'reported_by_user' => true,
        'liked_by_user' => true,
        'mentions' => ['john_smith'],
        'mentions_details' => [
            'smith_john' => 'Smith John',
        ],
        'scheduled_at' => '2019-08-24T14:15:22',
        'status' => 'published',
        'files' => [
            [
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
            ],
        ],
        'photos' => [],
        'videos' => [],
        'media' => [],
        'options' => [
            [
                'text' => 'This Friday',
                'vote_count' => 12,
                'id' => 983,
            ],
            [
                'text' => 'Monday next week',
                'vote_count' => 3,
                'id' => 984,
            ],
        ],
        'state_id' => '2017-06-19T08:49:53',
    ];

    $post = Post::make($postData);

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->id)->toBe(2234)
        ->and($post->text)->toBe('Please indicate your preferred dates for next team event in the poll below. Thanks!')
        ->and($post->title)->toBe('Hello guys!')
        ->and($post->labels)->toBeInstanceOf(Collection::class)
        ->and($post->labels->toArray())->toBe(['food', 'poll', 'events'])
        ->and($post->sticky)->toBeTrue()
        ->and($post->likeCount)->toBe(42)
        ->and($post->streamId)->toBe(6002)
        ->and($post->userId)->toBe('5cb9v45d-8i78-4v65-b5fd-81cgfac3ef17')
        ->and($post->uuid)->toBe('731b28bc-7f10-4b68-a089-fc672abc9955')
        ->and($post->commentCount)->toBe(2)
        ->and($post->reportCount)->toBe(0)
        ->and($post->source)->toBe('beekeeper')
        ->and($post->voteCount)->toBe(12)
        ->and($post->moderated)->toBeTrue()
        ->and($post->photo)->toBe('https://d6698txzbomp3.cloudfront.net/72e3b7d4-c6a4-47e9-8f81-7b7d10bdd84a')
        ->and($post->languageConfidence)->toBe(0.86)
        ->and($post->type)->toBe('post')
        ->and($post->metadata)->toBe('string')
        ->and($post->profile)->toBe('peter_smith')
        ->and($post->edited)->toBeTrue()
        ->and($post->displayNameExtension)->toBe('General Manager')
        ->and($post->subscribedByUser)->toBeTrue()
        ->and($post->reportable)->toBeTrue()
        ->and($post->anonymous)->toBeTrue()
        ->and($post->displayName)->toBe('John Smith')
        ->and($post->unread)->toBeTrue()
        ->and($post->locked)->toBeTrue()
        ->and($post->reactionsDisabled)->toBeTrue()
        ->and($post->name)->toBe('Peter Smith')
        ->and($post->language)->toBe('en')
        ->and($post->languageInformation)->toBeArray()
        ->and($post->created)->toBeInstanceOf(\Carbon\CarbonImmutable::class)
        ->and($post->postedByUser)->toBeTrue()
        ->and($post->avatar)->toBe('https://dz343oy86h947.cloudfront.net/business/neutral/normal/05.png')
        ->and($post->reportedByUser)->toBeTrue()
        ->and($post->likedByUser)->toBeTrue()
        ->and($post->mentions)->toBeInstanceOf(Collection::class)
        ->and($post->mentions->toArray())->toBe(['john_smith'])
        ->and($post->mentionsDetails)->toBeArray()
        ->and($post->scheduledAt)->toBeInstanceOf(\Carbon\CarbonImmutable::class)
        ->and($post->status)->toBe('published')
        ->and($post->files)->toBeInstanceOf(Collection::class)
        ->and($post->files)->toHaveCount(1)
        ->and($post->files->first())->toBeInstanceOf(File::class)
        ->and($post->photos)->toBeInstanceOf(Collection::class)
        ->and($post->videos)->toBeInstanceOf(Collection::class)
        ->and($post->media)->toBeInstanceOf(Collection::class)
        ->and($post->options)->toBeInstanceOf(Collection::class)
        ->and($post->options)->toHaveCount(2)
        ->and($post->stateId)->toBe('2017-06-19T08:49:53');
})->group('unit');

test('response class handles successful response', function () {
    $postData = [
        'id' => 2234,
        'text' => 'Test post content',
        'title' => 'Test Title',
        'labels' => ['test'],
        'sticky' => false,
        'like_count' => 0,
        'streamid' => 6002,
        'digest' => 1,
        'user_id' => 'test-user-id',
        'uuid' => 'test-uuid',
        'comment_count' => 0,
        'report_count' => 0,
        'source' => 'beekeeper',
        'vote_count' => 0,
        'moderated' => false,
        'photo' => null,
        'language_confidence' => null,
        'type' => 'post',
        'metadata' => null,
        'profile' => null,
        'edited' => false,
        'display_name_extension' => null,
        'subscribed_by_user' => false,
        'reportable' => false,
        'anonymous' => false,
        'display_name' => null,
        'unread' => false,
        'locked' => false,
        'reactions_disabled' => false,
        'name' => null,
        'language' => null,
        'language_information' => null,
        'created' => '2016-10-07T12:48:27',
        'posted_by_user' => false,
        'avatar' => null,
        'reported_by_user' => false,
        'liked_by_user' => false,
        'mentions' => [],
        'mentions_details' => null,
        'scheduled_at' => null,
        'status' => null,
        'files' => [],
        'photos' => [],
        'videos' => [],
        'media' => [],
        'options' => [],
        'state_id' => null,
    ];

    // Mock a successful response
    $mockResponse = Mockery::mock(Response::class);
    $mockResponse->shouldReceive('json')->andReturn($postData);
    $mockResponse->shouldReceive('successful')->andReturn(true);

    $post = CreateAPostInAGivenStreamResponse::fromResponse($mockResponse);

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->id)->toBe(2234)
        ->and($post->text)->toBe('Test post content')
        ->and($post->title)->toBe('Test Title');
})->group('unit');

test('response class handles error response', function () {
    $errorData = [
        'error' => [
            'code' => 'VALIDATION_ERROR',
            'message' => 'Invalid request data',
        ],
    ];

    // Mock an error response
    $mockResponse = Mockery::mock(Response::class);
    $mockResponse->shouldReceive('json')->andReturn($errorData);
    $mockResponse->shouldReceive('successful')->andReturn(false);

    expect(fn () => CreateAPostInAGivenStreamResponse::fromResponse($mockResponse))
        ->toThrow(Exception::class, 'Request was not successful: : VALIDATION_ERROR - Invalid request data');
})->group('unit');

test('response class handles empty response', function () {
    // Mock an empty response
    $mockResponse = Mockery::mock(Response::class);
    $mockResponse->shouldReceive('json')->andReturn(null);

    expect(fn () => CreateAPostInAGivenStreamResponse::fromResponse($mockResponse))
        ->toThrow(Exception::class, 'No data found in response');
})->group('unit');
