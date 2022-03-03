<?php

use MyCLabs\Enum\Enum;

abstract class Publicity extends Enum
{
    private const PUBLIC = 'public';
    private const PRIVATE = 'private';
    private const FRIENDS_ONLY = 'friends_only';
}
