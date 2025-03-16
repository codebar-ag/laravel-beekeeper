<?php

namespace CodebarAg\LaravelBeekeeper\Enums\Artifacts;

enum Sort: string
{
    case NAME_ASC = '+name';
    case NAME_DESC = '-name';
    case UPDATED_ASC = '+updated';
    case UPDATED_DESC = '-updated';
    case CREATED_ASC = '+created';
    case CREATED_DESC = '-created';
}
