<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\Configs\AuthenticatedUserStatus;
use CodebarAg\LaravelBeekeeper\Data\Configs\General;
use CodebarAg\LaravelBeekeeper\Requests\GetStatusOfAuthenticatedUserRequest;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

test('can get status of authenticated user', function () {
    Saloon::fake([
        GetStatusOfAuthenticatedUserRequest::class => MockResponse::make([
            'max_file_size' => 10485760,
            'max_files_on_post' => 10,
            'max_photo_size' => 5242880,
            'max_media_on_post' => 5,
            'max_video_size' => 104857600,
            'max_video_size_for_admins' => 209715200,
            'max_voice_recording_length' => 300,
            'max_users_in_group_chat' => 50,
            'reactions' => ['like', 'love', 'laugh', 'wow', 'sad', 'angry'],
            'feature_flags' => ['feature1', 'feature2'],
            'integrations' => ['integration1', 'integration2'],
            'styling' => ['theme1', 'theme2'],
            'tracking' => ['tracking1', 'tracking2'],
            'general' => [
                'id' => 1,
                'company_account' => 'test-company',
                'name' => 'Test Company',
                'language' => 'en',
                'created' => '2023-01-01T00:00:00Z',
                'url' => 'https://test.beekeeper.io',
                'tagline' => 'Test Tagline',
                'fqdn' => 'test.beekeeper.io',
                'support_email' => 'support@test.com',
                'is_data_security_contact_set' => true,
                'timezone' => 'UTC',
                'subdomain' => 'test',
            ],
        ], 200),
    ]);

    $connector = new BeekeeperConnector;
    $response = $connector->send(new GetStatusOfAuthenticatedUserRequest);
    $userStatus = $response->dto();

    expect($userStatus)->toBeInstanceOf(AuthenticatedUserStatus::class)
        ->and($userStatus->maxFileSize)->toBeInt()
        ->and($userStatus->maxFilesOnPost)->toBeInt()
        ->and($userStatus->maxPhotoSize)->toBeInt()
        ->and($userStatus->maxMediaOnPost)->toBeInt()
        ->and($userStatus->maxVideoSize)->toBeInt()
        ->and($userStatus->maxVideoSizeForAdmins)->toBeInt()
        ->and($userStatus->maxVoiceRecordingLength)->toBeInt()
        ->and($userStatus->maxUsersInGroupChat)->toBeInt()
        ->and($userStatus->featureFlags)->toBeInstanceOf(Collection::class)
        ->and($userStatus->integrations)->toBeInstanceOf(Collection::class)
        ->and($userStatus->styling)->toBeInstanceOf(Collection::class)
        ->and($userStatus->tracking)->toBeInstanceOf(Collection::class)
        ->and($userStatus->general)->toBeInstanceOf(General::class)
        ->and($userStatus->general->id)->toBeInt()
        ->and($userStatus->general->companyAccount)->toBeString()
        ->and($userStatus->general->name)->toBeString()
        ->and($userStatus->general->language)->toBeString()
        ->and($userStatus->general->created)->toBeInstanceOf(CarbonImmutable::class)
        ->and($userStatus->general->url)->toBeString()
        ->and($userStatus->general->tagline)->toBeString()
        ->and($userStatus->general->fqdn)->toBeString()
        ->and($userStatus->general->supportEmail)->toBeString()
        ->and($userStatus->general->isDataSecurityContactSet)->toBeBool()
        ->and($userStatus->general->timezone)->toBeString()
        ->and($userStatus->general->subdomain)->toBeString();
})->group('user');
