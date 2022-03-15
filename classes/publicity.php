<?php

use MyCLabs\Enum\Enum;

/**
 * @method static Publicity PUBLIC()
 * @method static Publicity PRIVATE()
 * @method static Publicity FRIENDS_ONLY()
 */
final class Publicity extends Enum
{
    private const PUBLIC = 'public';
    private const PRIVATE = 'private';
    private const FRIENDS_ONLY = 'friends_only';
}
