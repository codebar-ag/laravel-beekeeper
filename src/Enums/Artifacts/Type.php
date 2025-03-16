<?php

namespace CodebarAg\LaravelBeekeeper\Enums\Artifacts;

enum Type: string
{
    case FILE = 'file';
    case FOLDER = 'folder';
    case INTEGRATION = 'integration';
}
