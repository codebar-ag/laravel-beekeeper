<?php

namespace CodebarAg\LaravelBeekeeper\Enums\Streams;

enum Type: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case ANNOUNCEMENT = 'announcement';
    case DISCUSSION = 'discussion';
    case PROJECT = 'project';
    case DEPARTMENT = 'department';
    case TEAM = 'team';
}
