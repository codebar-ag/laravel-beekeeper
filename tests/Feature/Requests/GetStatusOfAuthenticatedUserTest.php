<?php

use Carbon\CarbonImmutable;
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;
use CodebarAg\LaravelBeekeeper\Data\AuthenticatedUserStatus;
use CodebarAg\LaravelBeekeeper\Data\General;
use CodebarAg\LaravelBeekeeper\Requests\GetStatusOfAuthenticatedUser;
use Illuminate\Support\Collection;

test('can get status of authenticated user', function () {
    $connector = new BeekeeperConnector;

    $response = $connector->send(new GetStatusOfAuthenticatedUser);

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
        ->and($userStatus->reactions)->toBeInstanceOf(Collection::class)
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
})->group('user')->only();
