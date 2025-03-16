<?php

namespace CodebarAg\LaravelBeekeeper\Enums\Files;

enum Status: string
{
    case READY = 'ready';
    case PENDING = 'pending';
    case ERROR = 'error';
    case MARKED_FOR_DELETION = 'marked_for_deletion';
}
