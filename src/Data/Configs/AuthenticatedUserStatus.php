<?php

namespace CodebarAg\LaravelBeekeeper\Data\Configs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class AuthenticatedUserStatus
{
    public static function make(array $data): self
    {
        return new self(
            maxFileSize: Arr::get($data, 'max_file_size'),
            maxFilesOnPost: Arr::get($data, 'max_files_on_post'),
            maxPhotoSize: Arr::get($data, 'max_photo_size'),
            maxMediaOnPost: Arr::get($data, 'max_media_on_post'),
            maxVideoSize: Arr::get($data, 'max_video_size'),
            maxVideoSizeForAdmins: Arr::get($data, 'max_video_size_for_admins'),
            maxVoiceRecordingLength: Arr::get($data, 'max_voice_recording_length'),
            maxUsersInGroupChat: Arr::get($data, 'max_users_in_group_chat'),
            reactions: Arr::has($data, 'reactions') ? collect(Arr::get($data, 'reactions'))->map(fn (array $reaction) => Reaction::make($reaction)) : null,
            featureFlags: collect(Arr::get($data, 'feature_flags')),
            integrations: collect(Arr::get($data, 'integrations')),
            styling: collect(Arr::get($data, 'styling')),
            tracking: collect(Arr::get($data, 'tracking')),
            general: General::make(Arr::get($data, 'general')),
        );
    }

    public function __construct(
        public ?int $maxFileSize,
        public ?int $maxFilesOnPost,
        public ?int $maxPhotoSize,
        public ?int $maxMediaOnPost,
        public ?int $maxVideoSize,
        public ?int $maxVideoSizeForAdmins,
        public ?int $maxVoiceRecordingLength,
        public ?int $maxUsersInGroupChat,
        public ?Collection $reactions = null,
        public ?Collection $featureFlags = null,
        public ?Collection $integrations = null,
        public ?Collection $styling = null,
        public ?Collection $tracking = null,
        public ?General $general = null,
    ) {}
}
