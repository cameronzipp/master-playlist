<?php

use MyCLabs\Enum\Enum;

/**
 * Enums to use for specifying the visibility of a playlist.
 * @method static Visibility PUBLIC()
 * @method static Visibility PRIVATE()
 * @method static Visibility FRIENDS_ONLY()
 */
final class Visibility extends Enum
{
    private const PUBLIC = 'public';
    private const PRIVATE = 'private';
    private const FRIENDS_ONLY = 'friends_only';
}
