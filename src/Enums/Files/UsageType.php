<?php

namespace CodebarAg\LaravelBeekeeper\Enums\Files;

enum UsageType: string
{
    case ATTACHMENT_IMAGE = 'attachment_image';
    case COVER_IMAGE = 'cover_image';
    case AVATAR = 'avatar';
    case FAVICON = 'favicon';
    case APPICON = 'appicon';
    case LOGO = 'logo';
    case CHAT_GROUP_IMAGE = 'chat_group_image';
    case ATTACHMENT_FILE = 'attachment_file';
    case ATTACHMENT_VIDEO = 'attachment_video';
    case SCREENSHOT = 'screenshot';
    case NAVIGATION_EXTENSION_ICON = 'navigation_extension_icon';
    case NAVIGATION_EXTENSION_FILE = 'navigation_extension_file';
    case VOICE_RECORDING = 'voice_recording';
    case ARTIFACT = 'artifact';
    case SECURITY_CONTACT = 'security_contact';
}
